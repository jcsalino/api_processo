<?php

namespace app\modules\nodbt\controllers;

use Yii;
use app\modules\nodbt\models\Transaction as ModelsTransaction;
use yii\data\ActiveDataProvider;

class TransactionController extends NoSecurity
{
    public $modelClass = 'app\modules\nodbt\models\Transaction';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'transactions',
    ];

    public function actions() {
        $actions = parent::actions();
        unset($actions['delete']);
        unset($actions['update']);
        unset($actions['create']);
        return $actions;
    }

    
    public function actionCreate() {
        $params = Yii::$app->request->bodyParams;
        try {
            $transaction = new ModelsTransaction();
            $transaction->load($params, '');
            $transaction->status = 1;
            $transaction->validate();
            if ($transaction->hasErrors()) {
                return $transaction;
            }
            $transaction->userPayer->wallet->withdrawn((float)$transaction->value);
            $transaction->withdrawn = true;
            $transaction->userPayee->wallet->deposit((float)$transaction->value);
            $transaction->deposit = true;
            $transaction->save();
        }catch (\Throwable $e) {
            if ($transaction->deposit) {
                $transaction->userPayee->wallet->revertDeposit((float)$transaction->value);
            }
            if ($transaction->withdrawn) {
                $transaction->userPayer->wallet->revertWithdrawn((float)$transaction->value);
            }
            $transaction->status = 9;
            $transaction->save();
            throw $e;
        }
        return [
            'name' => "Success",
            'message' => 'transaction successfull',
            'status' => 200
        ];
    }
    
}
