<?php

namespace app\modules\security\controllers;

use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UnauthorizedHttpException;

class UserController extends Security
{
    public $modelClass = 'app\modules\security\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'users',
    ];

    public function actions(){
        $actions = parent::actions();
        unset($actions['delete']);
        unset($actions['update']);
        unset($actions['create']);
        return $actions;
    }
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if ($action->id === 'index') {
            if (is_array($result['users'])) {
                for( $i=0; $i < count($result['users']); $i++) {
                    if($result['users'][$i]['id'] != Yii::$app->user->getId()) {
                        unset($result['users'][$i]['wallet']);
                    }
                }
            }
        }
        if ($action->id === 'view') {
            if($result['id'] != Yii::$app->user->getId()) {
                unset($result['wallet']);
            }
        }
        return $result;
    }

}
