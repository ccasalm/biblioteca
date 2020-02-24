<?php

use yii\db\Migration;

/**
 * Class m200203_200027_insert_usuarios
 */
class m200203_200027_insert_usuarios extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('usuarios', [
            'nombre' => 'christian',
            'password' => Yii::$app->security->generatePasswordHash('1'),
            'auth_key' => Yii::$app->security->generateRandomString(60),
            'telefono' => '123123123',
            'poblacion' => 'Sanlúcar',
            'token' => null,
            'email' => 'christian.casal21@gmail.com'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('usuarios', ['nombre' => 'christian']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200203_200027_insert_usuarios cannot be reverted.\n";

        return false;
    }
    */
}
