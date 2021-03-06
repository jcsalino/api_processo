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
        $this->insert('user',[
            'id' => 1,
            'full_name' => 'User Type Comun Test',
            'email' => 'user1@apiprocesso.teste',
            'password' => '$2y$13$QyRERhJbypBHhvsxp0aV9eLELDWLfTmDEEaP9/7sPxAmjb1gzQd/a', // passowrd => teste
            'token' =>  Yii::$app->getSecurity()->generateRandomString().'1',
            'cpf_cnpj' => '11111111111',
            'type' => User::TYPE_USER,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('wallet',[
            'user_id' => 1,
            'balance' => 0.00,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('user',[
            'id' => 2,
            'full_name' => 'User2 Type Comun Test',
            'email' => 'user2@apiprocesso.teste',
            'password' => '$2y$13$QyRERhJbypBHhvsxp0aV9eLELDWLfTmDEEaP9/7sPxAmjb1gzQd/a', // passowrd => teste
            'token' =>  Yii::$app->getSecurity()->generateRandomString().'2',
            'cpf_cnpj' => '22222222222',
            'type' => User::TYPE_USER,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('wallet',[
            'user_id' => 2,
            'balance' => 100.00,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('user',[
            'id' => 3,
            'full_name' => 'User3 Type Comun Test',
            'email' => 'user3@apiprocesso.teste',
            'password' => '$2y$13$QyRERhJbypBHhvsxp0aV9eLELDWLfTmDEEaP9/7sPxAmjb1gzQd/a', // passowrd => teste
            'token' =>  Yii::$app->getSecurity()->generateRandomString().'3',
            'cpf_cnpj' => '33333333333',
            'type' => User::TYPE_USER,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('wallet',[
            'user_id' => 3,
            'balance' => 50.00,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('user',[
            'id' => 4,
            'full_name' => 'User4 Type Store Test',
            'email' => 'user4@apiprocesso.teste',
            'password' => '$2y$13$QyRERhJbypBHhvsxp0aV9eLELDWLfTmDEEaP9/7sPxAmjb1gzQd/a', // passowrd => teste
            'token' =>  Yii::$app->getSecurity()->generateRandomString().'4',
            'cpf_cnpj' => '44444444444444',
            'type' => User::TYPE_STORE,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('wallet',[
            'user_id' => 4,
            'balance' => 100.00,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('user',[
            'id' => 5,
            'full_name' => 'User5 Type Store Test',
            'email' => 'user5@apiprocesso.teste',
            'password' => '$2y$13$QyRERhJbypBHhvsxp0aV9eLELDWLfTmDEEaP9/7sPxAmjb1gzQd/a', // passowrd => teste
            'token' =>  Yii::$app->getSecurity()->generateRandomString().'5',
            'cpf_cnpj' => '55555555555555',
            'type' => User::TYPE_STORE,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('wallet',[
            'user_id' => 5,
            'balance' => 50.00,
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
