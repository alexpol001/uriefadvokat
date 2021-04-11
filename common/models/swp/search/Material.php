<?php

namespace common\models\swp\search;

use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\swp\Material as MaterialModel;
use yii\db\ActiveQuery;

class Material extends MaterialModel
{
    public $fields;
    public $material;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'material_id', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug', 'title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Material::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'group_id' => $this->group_id,
            'material_id' => $this->material_id,
            'sort' => $this->sort,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param int $parent
     * @param int $material
     */
    public function setParent($parent, $material = null)
    {
        $this->group_id = $parent;
        if ($material) {
            $this->material_id = $material;
        }
    }

    /**
     * @param ActiveQuery $query
     */
    protected function searchFieldFilter($query) {
        if ($this->fields) {
            $materials = MaterialModel::find()->andWhere(['group_id' => $this->group_id]);
            if ($this->material) {
                $materials->andWhere(['material_id' => $this->material]);
            }
            $materials = $materials->all();
            foreach ($this->fields as $key => $value) {
                if ($value != '') {
                    /** @var Material $model */
                    foreach ($materials as $i => $model) {
                        if ($fieldValue = $model->getValue($key)) {
                            $field = \common\models\swp\Field::findOne($key);
                            switch ($field->type) {
                                case 400:
                                case 1000:
                                    if ($fieldValue != $value) {
                                        $query->andWhere(['<>', 'sw_material.id', $model->id]);
                                    }
                                    break;
                                case 500:
                                    if (!in_array($value, explode(", ", $fieldValue))) {
                                        $query->andWhere(['<>', 'sw_material.id', $model->id]);
                                    }
                                    break;
                                case 1100:
                                    $dates = explode(", ", $fieldValue);
                                    $date1 = DateTime::createFromFormat('!d/m/Y', $dates[0])->getTimestamp();
                                    $date2 = DateTime::createFromFormat('!d/m/Y', $dates[1])->getTimestamp();
                                    $searchDate = DateTime::createFromFormat('!d/m/Y', $value)->getTimestamp();
                                    if ($date1 > $searchDate || $date2 < $searchDate) {
                                        $query->andWhere(['<>', 'sw_material.id', $model->id]);
                                    }
                                    break;
                                default:
                                    if (stripos(mb_strtolower($fieldValue), mb_strtolower($value)) === false) {
                                        $query->andWhere(['<>', 'sw_material.id', $model->id]);
                                    }
                            }
                        } else {
                            $query->andWhere(['<>', 'sw_material.id', $model->id]);
                        }
                    }
                }
            }
        }
    }
}
