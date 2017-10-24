<?php

use yii\db\Migration;

/**
 * Handles adding img to table `user`.
 */
class m170904_143740_add_img_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'img', $this->string()->null()->after('email'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'img');
    }
}
