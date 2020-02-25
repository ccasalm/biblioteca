<?php

namespace app\models;

/**
 * This is the model class for table "temas".
 *
 * @property int $id
 * @property string $titulo
 * @property string|null $duracion
 * @property string|null $ruta
 *
 * @property AlbumesTemas[] $albumesTemas
 * @property Albumes[] $albumes
 * @property ArtistasTemas[] $artistasTemas
 * @property Artistas[] $artistas
 */
class Temas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['duracion'], 'string'],
            [['titulo', 'ruta'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'duracion' => 'Duración',
            'ruta' => 'Ruta',
        ];
    }
    public function getDuracionFormat()
    {
        $matches = [];
        if (preg_match('/^PT(\d+)M(\d+)S$/', $this->duracion, $matches)) {
            return $matches[1] . ':' . $matches[2];
        }
    }

    /**
     * Gets query for [[AlbumesTemas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumesTemas()
    {
        return $this->hasMany(AlbumesTemas::className(), ['tema_id' => 'id'])->inverseOf('tema');
    }

    /**
     * Gets query for [[Albums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumes()
    {
        return $this->hasMany(Albumes::className(), ['id' => 'album_id'])->viaTable('albumes_temas', ['tema_id' => 'id']);
    }

    /**
     * Gets query for [[ArtistasTemas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtistasTemas()
    {
        return $this->hasMany(ArtistasTemas::className(), ['tema_id' => 'id'])->inverseOf('tema');
    }

    /**
     * Gets query for [[Artistas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtistas()
    {
        return $this->hasMany(Artistas::className(), ['id' => 'artista_id'])->viaTable('artistas_temas', ['tema_id' => 'id']);
    }
    public static function lista()
    {
        return static::find()->select('titulo')->indexBy('id')->column();
    }
}
