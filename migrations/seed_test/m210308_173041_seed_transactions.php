<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m210308_173041_seed_transactions
 */
class m210308_173041_seed_transactions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('transaction',[
            'id' => 2,
            'value' => 1,
            'payer' => 2,
            'payee' => 1,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('transaction',[
            'id' => 3,
            'value' => 1,
            'payer' => 3,
            'payee' => 1,
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210308_173041_seed_transactions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210308_173041_seed_transactions cannot be reverted.\n";

        return false;
    }
    */
}
