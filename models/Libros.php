<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libros".
 *
 * @property int $id
 * @property string|null $titulo
 * @property int $genero_id
 * @property int|null $num_pags
 * @property string|null $isbn
 * @property string $created_at
 *
 * @property Generos $genero
 * @property Prestamos[] $prestamos
 */
class Libros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['genero_id'], 'required'],
            [['genero_id', 'num_pags'], 'default', 'value' => null],
            [['genero_id', 'num_pags'], 'integer'],
            [['created_at'], 'safe'],
            [['titulo'], 'string', 'max' => 60],
            [['isbn'], 'string', 'max' => 13],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'genero_id' => 'Genero ID',
            'num_pags' => 'Num Pags',
            'isbn' => 'Isbn',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestamos()
    {
        return $this->hasMany(Prestamos::className(), ['libro_id' => 'id']);
    }
}
