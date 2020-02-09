<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%libros}}`.
 */
class m200209_114638_create_libros_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%libros}}', [
            'id' => $this->primaryKey(),
            'denom' => $this->string(60),
            'num_pags' => $this->integer(),
            'isbn' => $this->string(13),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%libros}}');
    }
}
