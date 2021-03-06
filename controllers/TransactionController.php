<?php

namespace app\controllers;

use app\models\Transaction;
use Yii;

class TransactionController extends NoSecurity
{
    public $modelClass = 'app\models\Transaction';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'transactions',
    ];

    public function actions(){
        $actions = parent::actions();
        unset($actions['delete']);
        unset($actions['update']);
        unset($actions['create']);
        return $actions;
    }

    
    public function actionCreate() {
        $params = Yii::$app->request->bodyParams;
        $transactionDB = Yii::$app->db->beginTransaction();
        try {
            $transaction = new Transaction();
            $transaction->load($params, '');
            $transaction->status = 1;
            $transaction->validate();
            if ($transaction->hasErrors()) {
                return $transaction;
            }
            $transaction->userPayer->wallet->withdrawn((float)$transaction->value);
            $transaction->userPayee->wallet->deposit((float)$transaction->value);
            $transaction->save();
            $transactionDB->commit();
        }catch (\Throwable $e) {
            $transactionDB->rollBack();
            throw $e;
        }
        return [
            'name' => "Success",
            'message' => 'transaction successfull',
            'status' => 200
        ];
    }
}
