<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Temas;

/**
 * TemasSearch represents the model behind the search form of `app\models\Temas`.
 */
class TemasSearch extends Temas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['titulo', 'duracion', 'ruta'], 'safe'],
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
        $query = Temas::find();

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
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'ruta', $this->ruta]);
            

        if (preg_match('/^\d+:\d+$/', $this->duracion)) {

            $duracion = explode(':', $this->duracion);
            $duracion = 'PT' . $duracion[0] . 'M' . $duracion[1] . 'S';

            $query->andFilterWhere(['duracion' => $duracion]);
        }

        return $dataProvider;
    }
}
