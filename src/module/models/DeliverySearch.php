<?php

namespace uranum\delivery\module\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class DeliverySearch extends DeliveryServices
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isActive', 'serviceShownFor', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code', 'dateDb'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = DeliveryServices::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'isActive' => $this->isActive,
            'serviceShownFor' => $this->serviceShownFor,
            'dateDb' => $this->dateDb,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
