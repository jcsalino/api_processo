<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m210306_131921_seed_user_and_wallet
 */
class m210306_131921_seed_user_and_wallet extends Migration
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
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('transaction',[
            'id' => 3,
            'value' => 1,
            'payer' => 3,
            'payee' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210306_131921_seed_user_and_wallet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210306_131921_seed_user_and_wallet cannot be reverted.\n";

        return false;
    }
    */
}
