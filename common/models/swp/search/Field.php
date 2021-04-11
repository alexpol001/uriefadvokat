<?php

namespace common\models\swp\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\swp\Field as FieldModel;

class Field extends FieldModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'is_require', 'is_hidden', 'is_search', 'type', 'sort', 'status'], 'integer'],
            [['title', 'default', 'params'], 'safe'],
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
        $query = FieldModel::find();

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
            'is_require' => $this->is_require,
            'is_hidden' => $this->is_hidden,
            'is_search' => $this->is_search,
            'type' => $this->type,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'default', $this->default])
            ->andFilterWhere(['like', 'params', $this->params]);

        return $dataProvider;
    }

    /**
     * @param $parent
     */
    public function setParent($parent) {
        $this->group_id = $parent;
    }
}
