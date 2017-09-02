<?php

use yii\db\Migration;

/**
 * Handles adding role_id to table `user`.
 * Has foreign keys to the tables:
 *
 * - `role`
 */
class m170902_085411_add_role_id_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'role_id', $this->integer()->defaultValue(1)->after('access_token'));

        // creates index for column `role_id`
        $this->createIndex(
            'idx-user-role_id',
            'user',
            'role_id'
        );

        // add foreign key for table `role`
        $this->addForeignKey(
            'fk-user-role_id',
            'user',
            'role_id',
            'role',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `role`
        $this->dropForeignKey(
            'fk-user-role_id',
            'user'
        );

        // drops index for column `role_id`
        $this->dropIndex(
            'idx-user-role_id',
            'user'
        );

        $this->dropColumn('user', 'role_id');
    }
}
