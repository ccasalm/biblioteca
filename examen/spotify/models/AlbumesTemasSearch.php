<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AlbumesTemas;

/**
 * AlbumesTemasSearch represents the model behind the search form of `app\models\AlbumesTemas`.
 */
class AlbumesTemasSearch extends AlbumesTemas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['album_id', 'tema_id'], 'integer'],
            [['tema.titulo','album.titulo', 'tema_id'], 'safe'],

        ];
    }
    public function attributes()
    {
        return array_merge(parent::attributes(), ['tema.titulo','album.titulo']);
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
        $query = AlbumesTemas::find()->joinWith('album a')->joinWith('tema t');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['album.titulo'] = [
            'asc' => ['a.titulo' => SORT_ASC],
            'desc' => ['a.titulo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['tema.titulo'] = [
            'asc' => ['t.titulo' => SORT_ASC],
            'desc' => ['t.titulo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'album_id' => $this->album_id,
            'tema_id' => $this->tema_id,
        ]);

        $query->andFilterWhere(['ilike', 'a.titulo', $this->getAttribute('album.titulo')])
        ->andFilterWhere(['ilike', 't.titulo', $this->getAttribute('tema.titulo')]);

        return $dataProvider;
    }
}
