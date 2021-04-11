<?php

namespace backend\modules\swp\models;

class MaterialField extends \common\models\swp\MaterialField
{
    /**
     * @param Material $material
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function saveFields($material)
    {
        $data = $material->fieldsData;
        if (!$data['field']) return;
        foreach ($data['field'] as $key => $value) {
                $model = self::findOne(['material_id' => $material->id, 'field_id' => $key]);
                if (!$model) {
                    $model = new self();
                    $model->material_id = $material->id;
                    $model->field_id = $key;
                }
                $field = Field::findOne($key);
                if ($field->type == 500 || $field->type == 1100) {
                    $value = self::parseMultiValue($value);
                }
                $model->value = $value;
                $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toCopy($groupId)
    {
        $model = new self();
        $model->attributes = $this->attributes;
        $model->id = null;
        $model->material_id = $groupId;
        if ($model->save()) {
            return true;
        }
        return false;
    }

    /**
     * @param $value
     * @return string
     */
    protected static function parseMultiValue($value)
    {
        $val = '';
        foreach ($value as $i => $item) {
            if ($i != 0) {
                $val .= ', ';
            }
            $val .= $item;
        }
        return $val;
    }
}
