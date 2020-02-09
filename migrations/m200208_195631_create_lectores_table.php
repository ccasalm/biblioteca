<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lectores}}`.
 */
class m200208_195631_create_lectores_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lectores}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(60)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'telefono' => $this->string()->unique(),
            'poblacion' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lectores}}');
    }
}
