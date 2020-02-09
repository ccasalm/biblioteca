<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%generos}}`.
 */
class m200209_130558_create_generos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%generos}}', [
            'id' => $this->primaryKey(),
            'denom' => $this->string(30)->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%generos}}');
    }
}
