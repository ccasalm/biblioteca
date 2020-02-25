<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artistas_temas".
 *
 * @property int $artista_id
 * @property int $tema_id
 *
 * @property Artistas $artista
 * @property Temas $tema
 */
class ArtistasTemas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artistas_temas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['artista_id', 'tema_id'], 'required'],
            [['artista_id', 'tema_id'], 'default', 'value' => null],
            [['artista_id', 'tema_id'], 'integer'],
            [['artista_id', 'tema_id'], 'unique', 'targetAttribute' => ['artista_id', 'tema_id']],
            [['artista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artistas::className(), 'targetAttribute' => ['artista_id' => 'id']],
            [['tema_id'], 'exist', 'skipOnError' => true, 'targetClass' => Temas::className(), 'targetAttribute' => ['tema_id' => 'id']],
            [['tema_id'], 'temaOcupado', 'skipOnError' => true],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'artista_id' => 'Artista ID',
            'tema_id' => 'Tema ID',
        ];
    }

    /**
     * Gets query for [[Artista]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtista()
    {
        return $this->hasOne(Artistas::className(), ['id' => 'artista_id'])->inverseOf('artistasTemas');
    }

    /**
     * Gets query for [[Tema]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTema()
    {
        return $this->hasOne(Temas::className(), ['id' => 'tema_id'])->inverseOf('artistasTemas');
    }
    public static function listaPorId($attribute)
    {
        return static::find()
            ->where(['tema_id' => $attribute])
            ->orderBy('tema_id')
            ->column();
    }

    public function temaOcupado($attribute, $params)
    {
        if (static::listaPorId($this->$attribute)){
            $this->addError($attribute, 'El tema ya tiene autor.');
        }
    }
}
