<?php

use yii\db\Migration;

/**
 * Class m210305_190056_create_table_transaction
 */
class m210305_190056_create_table_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction',[
            'id' => $this->primaryKey(),
            'value' => $this->number(11, 2)->notNull(),
            'payer' => $this->integer()->notNull(),
            'payee' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
         ]);
         $this->addForeignKey(
            'fk-transaction-payer',
            'wallet',
            'payer',
            'user',
            'id',
            'CASCADE'
          );
         $this->addForeignKey(
            'fk-transaction-payee',
            'wallet',
            'payee',
            'user',
            'id',
            'CASCADE'
          );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210305_190056_create_table_transaction cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210305_190056_create_table_transaction cannot be reverted.\n";

        return false;
    }
    */
}
