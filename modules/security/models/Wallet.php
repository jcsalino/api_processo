<?php

namespace app\modules\security\models;

use Yii;
use yii\httpclient\Client;
use yii\behaviors\TimestampBehavior;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "wallet".
 *
 * @property int $id
 * @property int $user_id
 * @property float $balance
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallet';
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
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['balance'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'balance' => Yii::t('app', 'Balance'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     *
     *  funcao para retirada de dinheiro da carteira.
     * @return boolean
     */
    public function withdrawn(float $value) {
        if ($this->balance < $value) {
            throw new BadRequestHttpException("The payer's balance is not sufficient for this transaction");
        }
        $client = new Client();
        $response = $client->post('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6')->send();
        if (!$response->getIsOk()) {
            // podemos modificar a resposta e colocar a respota do autorizador em log.
            throw new \yii\web\HttpException(422, $response->toString());
        }
        $this->balance -= $value;
        $this->save();
    }
    
    /**
     * {@inheritdoc}
     *
     *  funcao para deposito de dinheiro na carteira.
     * @return boolean
     */
    public function deposit(float $value) {
        $this->balance += $value;
        $client = new Client();
        $response = $client->post('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04')->send();
        if (!$response->getIsOk()) {
            // podemos modificar a resposta e colocar a respota do autorizador em log.
            //throw new \yii\web\HttpException(422, $response->toString());
             /**
             * criar algum evento para reenviar a notificacao algo como uma fila
             */
        }
        $this->save();
    }

}