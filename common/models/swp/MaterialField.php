<?php

namespace common\models\swp;

/**
 * This is the model class for table "{{%swp_material_field}}".
 *
 * @property int $id
 * @property int $material_id
 * @property int $field_id
 * @property string $value
 */
class MaterialField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swp_material_field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['material_id', 'field_id'], 'required'],
            [['material_id', 'field_id'], 'integer'],
            [['value'], 'string'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'field_id' => 'Field ID',
            'value' => 'Value',
        ];
    }
}
