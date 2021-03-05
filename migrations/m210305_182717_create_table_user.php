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
            'email' => $this->string(200)->notNull(),
            'password' => $this->string(200)->notNull(),
            'token' => $this->string(200),
            'type' => $this->integer(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
         ]);
        
        $this->addCommentOnColumn('user', 'type', '1 => TYPE_STORE, 2 => TYPE_USER');

        $this->createIndex(
            'idx_user_email',
            'user',
            'email'
        );
    
        $this->createIndex(
            'idx_user_fullname',
            'user',
            'fullname'
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
