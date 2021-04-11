<?php

namespace common\models\swp;

use common\models\swp\inherit\Common as CommonModel;

/**
 * This is the model class for table "{{%swp_field}}".
 *
 * @property int $id
 * @property int $group_id
 * @property string $title
 * @property string $default
 * @property string $params
 * @property int $is_require
 * @property int $is_hidden
 * @property int $is_search
 * @property int $type
 * @property int $sort
 * @property int $status
 *
 * @property MaterialField[] $materialFields
 */
class Field extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swp_field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['group_id', 'is_require', 'is_hidden', 'is_search', 'type', 'sort', 'status'], 'integer'],
            [['default', 'params'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['default'], 'default', 'value' => ''],
            [['status'], 'default', 'value' => 10],
            [['group_id', 'is_require', 'is_hidden', 'is_search'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge([
            'type' => 'Тип',
            'params' => 'Дополнительные параметры',
            'default' => 'Значение по умолчанию',
            'is_require' => 'Обязательно для заполнения',
            'is_hidden' => 'Скрытое поле',
            'is_search' => 'Поле поиска',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialFields()
    {
        return $this->hasMany(MaterialField::className(), ['field_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function toCopy($groupId)
    {
        $model = new self();
        $model->attributes = $this->attributes;
        $model->id = null;
        $model->group_id = $groupId;
        if ($model->save()) {
            return true;
        }
        return false;
    }
}
