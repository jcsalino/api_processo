<?php

namespace app\modules\security\models;

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
 * @property string $cpf_cnpj
 * @property int|null $type 1 => TYPE_STORE, 2 => TYPE_USER
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Transaction[] $transactionsPayer
 * @property Transaction[] $transactionsPayee
 * @property Wallet[] $wallets
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
    public function rules()
    {
        return [
            [['full_name', 'email', 'password', 'cpf_cnpj'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['full_name', 'email', 'password', 'token'], 'string', 'max' => 200],
            [['cpf_cnpj'], 'string', 'max' => 14],
            [['email'], 'unique'],
            [['cpf_cnpj'], 'unique'],
            [['token'], 'unique'],
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
            'cpf_cnpj' => Yii::t('app', 'Cpf Cnpj'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }

    public static function findByEmail($email, $type=null)
    {
        return static::findOne(['email' => $email]);
    }
    
    public static function findIdentityByAccessToken($token, $type=null)
    {
        Yii::$app->jwt->validate($token);
        $token = Yii::$app->jwt->parse($token);
        return static::findOne(['token' => (string)$token->claims()->get('token')]);
    }
    /**
     * {@inheritdoc}
     * funcao para validar o password
     */
    public function validatePassword($password) : bool
    {
        return password_verify($password, $this->password );
    }
      
    public function getAuthKey()
    {
        throw new NotSupportedException();
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsPayee()
    {
        return $this->hasMany(Transaction::class, ['payee' => 'id']);
    }

    /**
     * Gets query for [[Transactions0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsPayer()
    {
        return $this->hasMany(Transaction::class, ['payer' => 'id']);
    }

    /**
     * Gets query for [[Wallets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWallet()
    {
        return $this->hasOne(Wallet::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['wallet'];
    }

     /**
     * {@inheritdoc}
     */
    public function fields() {
        return [
            'id',
            'full_name',
            'cpf_cnpj',
            'email',
            'type',
            'typeString' => function($model) {
                $reponse = "";
                if ($this->type === $this::TYPE_STORE) {
                    $response = 'TYPE_STORE';
                }
                if ($this->type === $this::TYPE_USER) {
                    $response = 'TYPE_USER';
                }
                return $response;
            },
            'wallet',
            'created_at',
            'updated_at',
        ];
    }
     /**
     * {@inheritdoc}
     * funcao para gerar o token jwt
     */
    public function generateToken() :string 
    {
        $now = new \DateTimeImmutable();
        $tmz = new \DateTimeZone('-0300');
        $now->setTimezone($tmz);
        $token = md5($this->id+time());
        $tokenJWT = Yii::$app->jwt->getBuilder()
            ->identifiedBy('4f1g23a12aa')
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+24 hour'))
            ->withClaim('token', $token)
            ->getToken(
                Yii::$app->jwt->getConfiguration()->signer(),
                Yii::$app->jwt->getConfiguration()->signingKey()
            );
        $this->token = $token;
        $this->save();
        return $tokenJWT->toString();
    }
}
