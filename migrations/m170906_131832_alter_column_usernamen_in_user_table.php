<?php

use yii\db\Migration;

class m170906_131832_alter_column_usernamen_in_user_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user', 'username', $this->string()->null()->after('id'));
    }

    public function safeDown()
    {
        $this->alterColumn('user', 'username', $this->string()->notNull()->after('id'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170906_131832_alter_column_usernamen_in_user_table cannot be reverted.\n";

        return false;
    }
    */
}
