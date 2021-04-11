<?php

namespace common\models\swp;

use common\behaviors\SluggableBehavior;
use common\models\swp\inherit\Common as CommonModel;
use Yii;

/**
 * This is the model class for table "{{%swp_group}}".
 *
 * @property int $id
 * @property int $group_id
 * @property string $slug
 * @property string $title
 * @property int $is_singleton
 * @property int $type
 * @property int $sort
 * @property int $status
 *
 * @property Field[] $swFields
 * @property Group[] $groups
 * @property Material[] $materials
 * @property Material $material
 */
class Group extends CommonModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swp_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => ['title'],
                'ensureUnique' => true,
                'uniqueValidator' => ['targetAttribute' => ['slug', 'group_id']]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'slug', 'title', 'type'], 'required'],
            [['group_id', 'is_singleton', 'type', 'sort', 'status'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['sort', 'is_singleton'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {

        return array_merge([
            'type' => 'Тип',
            'is_require' => 'Запретить удаление',
            'is_singleton' => 'Только один элемент',
        ], parent::attributeLabels());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSwFields()
    {
        return $this->hasMany(Field::className(), ['group_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['group_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function toCopy($parentId)
    {
        $model = new self();
        $model->attributes = $this->attributes;
        $model->id = null;
        $model->group_id = $parentId;
        $model->setCopy($this->id);
        if ($model->save()) {
            return true;
        }
        return false;
    }
}
