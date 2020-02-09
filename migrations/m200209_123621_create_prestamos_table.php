<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prestamos}}`.
 */
class m200209_123621_create_prestamos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prestamos}}', [
            'id' => $this->primaryKey(),
            'lector_id' => $this->bigInteger()->notNull(),
            'libro_id' => $this->bigInteger()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'devolucion' => $this->timestamp()
        ]);

        $this->addForeignKey(
            'fk_prestamos_libros',
            'prestamos',
            'libro_id',
            'libros',
            'id'
        );

        $this->addForeignKey(
            'fk_prestamos_lectores',
            'prestamos',
            'lector_id',
            'lectores',
            'id'
        );

        $this->createIndex(
            'idx_prestamos_libro_id_lector_id_created_at',
            'prestamos',
            [
                'libro_id',
                'lector_id',
                'created_at',
            ],
            true,
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_prestamos_libro_id_lector_id_created_at', 'prestamos');
        $this->dropForeignKey('fk_prestamos_lectores', 'prestamos');
        $this->dropForeignKey('fk_prestamos_libros', 'prestamos');
        $this->dropTable('{{%prestamos}}');
    }
}
