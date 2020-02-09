<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libros".
 *
 * @property int $id
 * @property string|null $denom
 * @property int|null $num_pags
 * @property string|null $isbn
 * @property string $created_at
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
            [['num_pags'], 'default', 'value' => null],
            [['num_pags'], 'integer'],
            [['created_at'], 'safe'],
            [['denom'], 'string', 'max' => 60],
            [['isbn'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denom' => 'Título',
            'num_pags' => 'Num Pags',
            'isbn' => 'Isbn',
            'created_at' => 'Fecha Alta',
        ];
    }
}
