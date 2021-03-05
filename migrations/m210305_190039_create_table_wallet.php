<?php

use yii\db\Migration;

/**
 * Class m210305_190039_create_table_wallet
 */
class m210305_190039_create_table_wallet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wallet',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'balance' => $this->number(11, 2)->notNull()->defaultValue(0.00),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
         ]);
         $this->addForeignKey(
            'fk-wallet-user_id',
            'wallet',
            'user_id',
            'wallet',
            'id',
            'CASCADE'
          );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210305_190039_create_table_wallet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210305_190039_create_table_wallet cannot be reverted.\n";

        return false;
    }
    */
}
