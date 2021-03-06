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
            'value' => $this->decimal(11, 2)->notNull(),
            'payer' => $this->integer()->notNull(),
            'payee' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
         ]);
         $this->addForeignKey(
            'fk-transaction-payer',
            'transaction',
            'payer',
            'user',
            'id',
            'CASCADE'
          );
         $this->addForeignKey(
            'fk-transaction-payee',
            'transaction',
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
