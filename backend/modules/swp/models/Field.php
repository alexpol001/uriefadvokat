<?php

namespace backend\modules\swp\models;

use backend\components\Backend;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class Field extends \common\models\swp\Field
{
    private $totallyDelete = null;
    public $common_field;

    private static $types = [
        '0' => 'Заголовок материала',
        '100' => 'Текстовое поле',
        '150' => 'Общее поле',
        '200' => 'Текст',
        '300' => 'Текстовый редактор',
        '400' => 'Выбор',
        '500' => 'Множественный выбор',
        '600' => 'Файл',
        '700' => 'Файлы',
        '800' => 'Цвет',
        '900' => 'Иконка (font awesome)',
        '1000' => 'Дата',
        '1100' => 'Период (Даты)',
    ];

    public function rules()
    {
        return array_merge([
            [['common_field'], 'integer'],
            [['type'], 'in', 'range' => function () {
                return array_keys(self::$types);
            }]
        ], parent::rules());
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge([
            'common_field' => 'Общее поле'
        ], parent::attributeLabels());
    }

    /**
     * @param $id
     * @return Group|null
     * @throws NotFoundHttpException
     */
    public function findGroup($id)
    {
        $model = Group::findOne($id);
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException();
    }

    /**
     * @param Group $group
     * @return bool
     */
    public static function createBasicFields($group)
    {
        $model = new self();
        $model->title = 'Заголовок';
        $model->type = 0;
        $model->group_id = $group->id;
        $model->status = 100;
        return $model->save();
    }

    /**
     * @param bool $full
     * @param bool $common
     * @return array
     */
    public static function getTypes($full = false, $common = false)
    {
        $types = self::$types;
        if (!$full) {
            unset($types[0]);
        }
        if ($common) {
            unset($types[150]);
        }
        return $types;
    }

    public static function getCommonFields() {
        return ArrayHelper::map(self::findAll(['group_id' => 0]), 'id', 'title');
    }

    private function saveParams($insert) {
        if (!$insert) {
            if (!$this->group_id) {
                foreach (self::findAll(['type' => 150, 'params' => $this->id]) as $field) {
                    $field->title = $this->title;
                    $field->save();
                }
                return true;
            }
        }
        if (!$this->params) {
            $this->params = null;
        }
        if ($this->type == 150 && $this->common_field) {
            $this->params = $this->common_field;
            $fields = [];
            foreach ($this->group->group->groups as $group) {
                $fields[] = $group->id;
            }
            if (!$insert) {
                $field = self::find()->where(['params' => $this->params])->andWhere(['in', 'group_id', $fields])->andWhere(['<>', 'id', $this->id])->one();
            } else {
                $field = self::find()->where(['params' => $this->params])->andWhere(['in', 'group_id', $fields])->one();
            }
            if ($field) {
                Yii::$app->session->setFlash('danger', 'Вы не можете добавить несколько общих полей к одному типу материалов.');
                return false;
            }
        }
        return true;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->sort = $this->generateSortValue();
        }
        if ($this->getScenario() == self::SCENARIO_EDIT) {
            $model = self::findOne($this->id);
            if ($model->status == 100 && $this->status != $model->status) {
                return false;
            }
        } else {
            if (!$this->saveParams($insert)) return false;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        if ($this->status == 100 && !$this->totallyDelete) {
            Yii::$app->session->setFlash('danger', 'Не удалось удалить некторые элементы (Они являются обязательными для каждого материала).');
            return false;
        }
        if (!$this->group_id) {
            Backend::deleteAll(self::findAll(['type' => 150, 'params' => $this->id]), true);
        }
        Backend::deleteAll($this->materialFields);
        return parent::beforeDelete();
    }

    public function delete($totally = false)
    {
        $this->totallyDelete = $totally;
        return parent::delete();
    }

    public static function create($title, $type, $group_id, $default = '', $params = '', $is_require = 0, $is_hidden = 0, $is_search = 0) {
        $field = new self();
        $field->title = $title;
        $field->type = $type;
        $field->group_id = $group_id;
        $field->default = $default;
        $field->params = $params;
        $field->is_require = $is_require;
        $field->is_hidden = $is_hidden;
        $field->is_search = $is_search;
        return $field->save() ? $field : null;
    }
}
