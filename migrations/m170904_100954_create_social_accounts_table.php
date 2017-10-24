<?php

use yii\db\Migration;

/**
 * Handles the creation of table `social_accounts`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `social_providers`
 */
class m170904_100954_create_social_accounts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('social_accounts', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'provider_id' => $this->integer()->notNull(),
            'client_id' => $this->string()->notNull(),
            'username' => $this->string()->notNull(),
            'email' => $this->string()->null(),
            'img' => $this->string()->null(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-social_accounts-user_id',
            'social_accounts',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-social_accounts-user_id',
            'social_accounts',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `provider_id`
        $this->createIndex(
            'idx-social_accounts-provider_id',
            'social_accounts',
            'provider_id'
        );

        // add foreign key for table `social_providers`
        $this->addForeignKey(
            'fk-social_accounts-provider_id',
            'social_accounts',
            'provider_id',
            'social_providers',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-social_accounts-user_id',
            'social_accounts'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-social_accounts-user_id',
            'social_accounts'
        );

        // drops foreign key for table `social_providers`
        $this->dropForeignKey(
            'fk-social_accounts-provider_id',
            'social_accounts'
        );

        // drops index for column `provider_id`
        $this->dropIndex(
            'idx-social_accounts-provider_id',
            'social_accounts'
        );

        $this->dropTable('social_accounts');
    }
}
