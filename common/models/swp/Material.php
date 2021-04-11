<?php

namespace common\models\swp;

use common\behaviors\SluggableBehavior;
use common\models\swp\inherit\Common as CommonModel;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%swp_material}}".
 *
 * @property int $id
 * @property int $group_id
 * @property int $material_id
 * @property string $slug
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Group $group
 * @property Material[] $materials
 * @property MaterialField[] $swFields
 */
class Material extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swp_material}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => ['title'],
                'ensureUnique' => true,
                'uniqueValidator' => ['targetAttribute' => ['slug', 'group_id', 'material_id']]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'group_id'], 'required'],
            [['group_id', 'material_id', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['sort', 'material_id'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(array_merge([
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ], parent::attributeLabels()));
    }

    /**
     * @param null $group_id
     * @return Material[]
     */
    public function getMaterials($group_id = null)
    {
        $params['material_id'] = $this->id;
        if ($group_id) {
            $params['group_id'] = $group_id;
        }
        $materials = self::find()
            ->andWhere($params)->andWhere(['>', 'status', 0])
            ->orderBy(['sort' => SORT_ASC])->all();
        return $materials;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSwFields()
    {
        return $this->hasMany(MaterialField::className(), ['material_id' => 'id']);
    }

    /**
     * @param $id
     * @return string|null
     */
    public function getValue($id)
    {
        /** @var MaterialField $field */
        $field = MaterialField::findOne(['field_id' => $id, 'material_id' => $this->id]);
        return $field ? $field->value : null;
    }

    public static function getMaterialsByFieldValue($field_id, $value, $exclude = [])
    {
        $materials = [];
        /** @var Material $material */
        $field = Field::findOne($field_id);
        if ($field) {
            $array = $field->group->group->materials;
            if ($array) {
                foreach ($array as $material) {
                    if ($material->getValue($field_id) == $value && !in_array($material->id, $exclude)) {
                        $materials[] = $material;
                    }
                }
            }
        }
        return $materials;
    }

    public function isHiddenTitle()
    {
        $group = Group::findOne($this->group->id);
        $group = Group::findOne(['group_id' => $group->id, 'status' => 100]);
        return Field::findOne(['group_id' => $group->id, 'type' => 0, 'is_hidden' => 1]) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function toCopy($parentId)
    {
        $model = new self();
        $model->attributes = $this->attributes;
        $model->id = null;
        $model->material_id = $parentId;
        $model->setCopy($this->id);
        if ($model->save()) {
            /** @var MaterialField $field */
            foreach ($this->swFields as $field) {
                $field->toCopy($model->id);
            }
            return true;
        }
        return false;
    }
}
