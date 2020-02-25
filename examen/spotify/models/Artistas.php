<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artistas".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ArtistasTemas[] $artistasTemas
 * @property Temas[] $temas
 */
class Artistas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artistas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[ArtistasTemas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtistasTemas()
    {
        return $this->hasMany(ArtistasTemas::className(), ['artista_id' => 'id'])->inverseOf('artista');
    }

    /**
     * Gets query for [[Temas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemas()
    {
        return $this->hasMany(Temas::className(), ['id' => 'tema_id'])->viaTable('artistas_temas', ['artista_id' => 'id']);
    }

    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }

    public static function listaPorId($artista_id)
    {
        return static::find()
            ->select('nombre')
            ->where(['id' => $artista_id])
            ->orderBy('nombre')
            ->indexBy('id')
            ->column();
    }
}
