<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%usuarios}}`.
 */
class m200224_093459_add_codigo_verificacion_column_to_usuarios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('usuarios', 'codigo_verificacion', $this->string(250));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('usuarios', 'codigo_verificacion');
    }
}
