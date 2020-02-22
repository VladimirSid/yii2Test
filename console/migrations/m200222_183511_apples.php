<?php

use yii\db\Migration;

/**
 * Class m200222_183511_apples
 */
class m200222_183511_apples extends Migration
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
        echo "m200222_183511_apples cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('apples', [
            'id' => $this->primaryKey(),
            'color' => $this->char(6)->notNull(), //для хранения цвета => формат (FF345A)
            'createdAt' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'fallAt' => $this->timestamp()->Null(), //дата падения на землю, одновременно статус (null => висит)
            'eaten' => $this->tinyInteger()->unsigned(), //считаем что откусывают целые проценты
        ]);
        $this->alterColumn('apples', 'id', $this->integer()->unsigned()->notNull().' AUTO_INCREMENT');
    }

    public function down()
    {
        //echo "m200222_183511_apples cannot be reverted.\n";
        //return false;
        $this->dropTable('apples');
    }

}
