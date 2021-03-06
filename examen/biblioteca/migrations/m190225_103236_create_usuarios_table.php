<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usuarios}}`.
 */
class m190225_103236_create_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%usuarios}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull()->unique(),
            'password' => $this->string(60)->notNull(),
            'auth_key' => $this->string(),
            'telefono' => $this->string(),
            'poblacion' => $this->string(),
            'email' => $this->string()->notNull()->unique(),
            'token' =>$this->string(32),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usuarios}}');
    }
}
