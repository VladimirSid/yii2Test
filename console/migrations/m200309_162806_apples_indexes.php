<?php

use yii\db\Migration;

/**
 * Class m200309_162806_apples_indexes
 */
class m200309_162806_apples_indexes extends Migration
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
        echo "m200309_162806_apples_indexes cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createIndex('IDX_fallAt', 'apples','fallAt');
    }

    public function down()
    {
        echo "m200309_162806_apples_indexes cannot be reverted.\n";

        return false;
    }

}
