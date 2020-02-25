<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArtistasTemas;

/**
 * ArtistasTemasSearch represents the model behind the search form of `app\models\ArtistasTemas`.
 */
class ArtistasTemasSearch extends ArtistasTemas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['artista_id', 'tema_id'], 'integer'],
            [['artista.nombre', 'tema.titulo'], 'safe'],
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

    public function attributes()
    {
        return array_merge(parent::attributes(), ['artista.nombre','tema.titulo']);
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
        $query = ArtistasTemas::find()->joinWith('artista a')->joinWith('tema t');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['tema.titulo'] = [
            'asc' => ['t.titulo' => SORT_ASC],
            'desc' => ['t.titulo' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['artista.nombre'] = [
            'asc' => ['a.nombre' => SORT_ASC],
            'desc' => ['a.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'artista_id' => $this->artista_id,
            'tema_id' => $this->tema_id,
        ]);

        $query->andFilterWhere(['ilike', 'a.nombre', $this->getAttribute('artista.nombre')])
        ->andFilterWhere(['ilike', 't.titulo', $this->getAttribute('tema.titulo')]);

        return $dataProvider;
    }
}
