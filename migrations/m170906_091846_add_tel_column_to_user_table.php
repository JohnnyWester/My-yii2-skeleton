<?php

use yii\db\Migration;

/**
 * Handles adding tel to table `user`.
 */
class m170906_091846_add_tel_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'tel', $this->string()->null()->after('email'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'tel');
    }
}
