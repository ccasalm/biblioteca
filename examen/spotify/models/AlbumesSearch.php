<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AlbumesSearch represents the model behind the search form of `app\models\Albumes`.
 */
class AlbumesSearch extends Albumes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['titulo', 'total'], 'safe'],
            [['anyo'], 'number'],
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
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Albumes::findWithTotal();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['total'] = [
            'asc' => ['total' => SORT_ASC],
            'desc' => ['total' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'anyo' => $this->anyo,
        ]);

        $query->andFilterWhere(['ilike', 'albumes.titulo', $this->titulo]);

        if (preg_match('/^\d+:\d+$/', $this->total)) {
            $total = explode(':', $this->total);
            $total = 'PT' . $total[0] . 'M' . $total[1] . 'S';
            $query->andFilterHaving(['SUM(t.duracion)' => $total]);
        }

        return $dataProvider;
    }
}
