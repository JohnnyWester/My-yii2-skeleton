<?php

use yii\db\Migration;

class m170902_084453_role_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('role', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'comment' => $this->string()->null(),
        ], 'ENGINE=InnoDB');

        $this->batchInsert('role', ['id', 'name'], [
            [1, 'guest'],
            [2, 'user'],
            [3, 'admin'],
            [10, 'developer'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170902_084453_role_table cannot be reverted.\n";

        return false;
    }
    */
}
