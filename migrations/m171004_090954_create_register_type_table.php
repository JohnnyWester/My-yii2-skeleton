<?php

use yii\db\Migration;

/**
 * Handles the creation of table `register_type`.
 */
class m171004_090954_create_register_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('register_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'comment' => $this->string()->null(),
        ], 'ENGINE=InnoDB');

        $this->batchInsert('register_type', ['id', 'name'], [
            [1, 'Email'],
            [2, 'Social'],
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('register_type');
    }
}
