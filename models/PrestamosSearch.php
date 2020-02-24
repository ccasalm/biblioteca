<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestamos;
use yii\data\Sort;

/**
 * PrestamosSearch represents the model behind the search form of `app\models\Prestamos`.
 */
class PrestamosSearch extends Prestamos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'libro_id', 'lector_id'], 'integer'],
            [['created_at', 'devolucion'], 'safe'],
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
        $sort = new Sort([
            'attributes' =>[
                'libro.titulo' => [
                    'asc' => ['l.titulo' => SORT_ASC],
                    'desc' => ['l.titulo' => SORT_DESC],
                    
                ],
                'lector.nombre' => [
                    'asc' => ['lec.nombre' => SORT_ASC],
                    'desc' => ['lec.nombre' => SORT_DESC],
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                ],
                'devolucion' => [
                    'asc' => ['devolucion' => SORT_ASC],
                    'desc' => ['devolucion' => SORT_DESC],
                ],
                
            ]
        ]);

        $query = Prestamos::find()->joinWith('libro l')->joinWith('lector lec');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' =>[
                'pageSize' => 5,
            ]
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
            'libro_id' => $this->libro_id,
            'lector_id' => $this->lector_id,
            'created_at' => $this->created_at,
            'devolucion' => $this->devolucion,
        ]);

        return $dataProvider;
    }
}
