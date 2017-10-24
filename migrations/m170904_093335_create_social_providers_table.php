<?php

use yii\db\Migration;

/**
 * Handles the creation of table `social_providers`.
 */
class m170904_093335_create_social_providers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('social_providers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ], 'ENGINE=InnoDB');

        $this->batchInsert('social_providers', ['id', 'name'], [
            [1, 'google'],
            [2, 'facebook'],
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('social_providers');
    }
}
