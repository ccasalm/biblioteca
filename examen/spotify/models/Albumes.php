<?php

namespace app\models;

/**
 * This is the model class for table "albumes".
 *
 * @property int $id
 * @property string $titulo
 * @property float $anyo
 *
 * @property AlbumesTemas[] $albumesTemas
 * @property Temas[] $temas
 */
class Albumes extends \yii\db\ActiveRecord
{
    private $_total = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'albumes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'anyo'], 'required'],
            [['anyo'], 'number'],
            [['titulo'], 'string', 'max' => 255],
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
            'anyo' => 'Año',
        ];
    }

    public function getTotal()
    {
        if ($this->_total === null) {
            $this->setTotal($this->getTemas()->sum('duracion'));
        }

        return $this->_total;
    }

    public function setTotal($total)
    {
        $this->_total = $total;
    }

    public function getTotalFormat()
    {
        $matches = [];
        if (preg_match('/^PT(\d+)M(\d+)S$/', $this->getTotal(), $matches)) {
            return $matches[1] . ':' . $matches[2];
        }
    }

    public static function findWithTotal()
    {
        return static::find()
            ->select(['albumes.*', "SUM(COALESCE(t.duracion, 'PT0S')) AS total"])
            ->joinWith('temas t')
            ->groupBy('albumes.id');
    }

    /**
     * Gets query for [[AlbumesTemas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbumesTemas()
    {
        return $this->hasMany(AlbumesTemas::className(), ['album_id' => 'id'])->inverseOf('album');
    }

    /**
     * Gets query for [[Temas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemas()
    {
        return $this->hasMany(Temas::className(), ['id' => 'tema_id'])->viaTable('albumes_temas', ['album_id' => 'id']);
    }

    public function getArtistas()
    {
        return $this->hasMany(Artistas::class, ['id' => 'id'])->via('temas');
    }

    public static function lista()
    {
        return static::find()->select('titulo')->indexBy('id')->column();
    }
}
