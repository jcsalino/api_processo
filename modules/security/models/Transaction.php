<?php

namespace app\modules\security\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property float $value
 * @property int $payer
 * @property int $payee
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $payee
 * @property User $payer
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
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
            [['value', 'payer', 'payee', 'status'], 'required'],
            [['value'], 'number'],
            ['value', 'compare', 'compareValue' => 0.01, 'operator' => '>=', 'type' => 'number'],
            [['payer', 'payee', 'status'], 'integer'],
            [['payee'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['payee' => 'id']],
            [['payer'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['payer' => 'id']],
            ['value', 'validateBalance'],
            ['payer', 'validatePayer'],
        ];
    }

    /**
     * {@inheritdoc}
     * validar se o payer tem saldo na carteira
     */
    public function validateBalance($attribute) {
        if ($this->userPayer->wallet->balance < $this->{$attribute}) {
            $this->addError($attribute, Yii::t('app', "The payer's balance is not sufficient for this transaction"));
        }
    }

    /**
     * {@inheritdoc}
     * validar se o payer é um usuario tipo loja
     */
    public function validatePayer($attribute) {
        if ($this->userPayer->type === User::TYPE_STORE) {
            $this->addError($attribute, Yii::t('app', "The payer must be a type user common"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
            'payer' => Yii::t('app', 'Payer'),
            'payee' => Yii::t('app', 'Payee'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Payee0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPayee()
    {
        return $this->hasOne(User::class, ['id' => 'payee']);
    }

    /**
     * Gets query for [[Payer0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserPayer()
    {
        return $this->hasOne(User::class, ['id' => 'payer']);
    }
}
