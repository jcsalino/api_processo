<?php

namespace app\modules\security\controllers;

use Yii;
use app\modules\security\models\Transaction as ModelsTransaction;
use yii\data\ActiveDataProvider;

class TransactionController extends Security
{
    public $modelClass = 'app\modules\security\models\Transaction';
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
        $transactionDB = Yii::$app->db->beginTransaction();
        try {
            $transaction = new ModelsTransaction();
            $transaction->load($params, '');
            $transaction->payer = Yii::$app->user->getId();
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
    
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if ($action->id === 'index') {
            if (is_array($result['transactions'])) {
                for( $i=0; $i < count($result['transactions']); $i++) {
                    if($result['transactions'][$i]['payer'] != Yii::$app->user->getId() &&
                        $result['transactions'][$i]['payee'] != Yii::$app->user->getId()
                    ) {
                        unset($result['transactions'][$i]['value']);
                    }
                }
            }
        }
        if ($action->id === 'view') {
            if($result['payer'] != Yii::$app->user->getId() && $result['payee'] != Yii::$app->user->getId()) {
                unset($result['value']);
            }
        }
        return $result;
    }

}
