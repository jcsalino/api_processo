<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $token
 * @property int|null $type 1 => TYPE_STORE, 2 => TYPE_USER
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Transaction[] $transactions
 * @property Transaction[] $transactions0
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

     /**
     * {@inheritdoc}
     * constante para o usuario tipo lojista
     */
    const TYPE_STORE = 1;

     /**
     * {@inheritdoc}
     * constante para o usuario tipo comum
     */
    const TYPE_USER = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'password'], 'required'],
            [['type'], 'integer'],
            [['full_name', 'email', 'password', 'token'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'token' => Yii::t('app', 'Token'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

     /**
     * {@inheritdoc}
     */
    public static function findIdentity($id){
        return static::findOne($id);
    }
    public function getId(){
        return $this->id;
    }

    public static function findIdentityByAccessToken($token, $type=null)
    {
        return static::findOne(['token' => $token]);
    }
    
    public function validatePassword($password)
    {
        return password_verify($password, $this->password );
    }
  
    public function validateToken($token){
        return (trim($this->token) === trim($token));
    }
      
    public function getAuthKey(){
        throw new NotSupportedException();
    }

    public function validateAuthKey($authKey){
        throw new NotSupportedException();
    }


    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, ['payee' => 'id']);
    }

    /**
     * Gets query for [[Transactions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions0()
    {
        return $this->hasMany(Transaction::class, ['payer' => 'id']);
    }
}
