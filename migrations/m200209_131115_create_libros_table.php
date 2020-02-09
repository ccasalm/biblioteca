<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%libros}}`.
 */
class m200209_131115_create_libros_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%libros}}', [
            'id' => $this->primaryKey(),
            'titulo' => $this->string(60),
            'genero_id' => $this->bigInteger()->notNull(),
            'num_pags' => $this->integer(),
            'isbn' => $this->string(13),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_libros_generos',
            'libros',
            'genero_id',
            'generos',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_libros_generos','libros');
        $this->dropTable('{{%libros}}');
    }
}
