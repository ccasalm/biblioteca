<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lectores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $created_at
 * @property string|null $telefono
 * @property string|null $poblacion
 */
class Lectores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lectores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['created_at'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['telefono', 'poblacion'], 'string', 'max' => 255],
            [['telefono'], 'unique'],
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
            'created_at' => 'Fecha Alta',
            'telefono' => 'Telefono',
            'poblacion' => 'Poblacion',
        ];
    }
}
