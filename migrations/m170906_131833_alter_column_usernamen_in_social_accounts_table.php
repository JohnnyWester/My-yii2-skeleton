<?php

use yii\db\Migration;

class m170906_131833_alter_column_usernamen_in_social_accounts_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('social_accounts', 'username', $this->string()->null()->after('client_id'));
    }

    public function safeDown()
    {
        $this->alterColumn('social_accounts', 'username', $this->string()->notNull()->after('client_id'));
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
