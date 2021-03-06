<?php

use yii\db\Migration;

/**
 * Class m210305_182717_create_table_user
 */
class m210305_182717_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user',[
            'id' => $this->primaryKey(),
            'full_name' => $this->string(200)->notNull(),
            'email' => $this->string(200)->notNull()->unique(),
            'password' => $this->string(200)->notNull(),
            'token' => $this->string(200)->unique(),
            'cpf_cnpj' => $this->string(14)->notNull()->unique(),
            'type' => $this->integer(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
         ]);
        
        $this->addCommentOnColumn('user', 'type', '1 => TYPE_STORE, 2 => TYPE_USER');

        $this->createIndex(
            'idx_user_email',
            'user',
            'email'
        );
    
        $this->createIndex(
            'idx_user_full_name',
            'user',
            'full_name'
        );
         
        $this->createIndex(
            'idx_user_token',
            'user',
            'token'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210305_182717_create_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210305_182717_create_table_user cannot be reverted.\n";

        return false;
    }
    */
}
