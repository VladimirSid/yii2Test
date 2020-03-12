<?php

use yii\db\Migration;

/**
 * Class m200312_105609_add_admin_user
 */
class m200312_105609_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200312_105609_add_admin_user cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->insert('user', [
            'username' => 'farmer_john',
            'password_hash' => '$2y$13$H0PxElhBVXPzcByCWS.0hurAiZbZIIHUKWw/aq4vCFxL7WGpiIqdO',
            'status' => 10
        ]);
    }

    public function down()
    {
        echo "m200312_105609_add_admin_user cannot be reverted.\n";

        return false;
    }

}
