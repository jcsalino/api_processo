<?php

namespace app\modules\nodbt\controllers;

use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UnauthorizedHttpException;

class UserController extends NoSecurity
{
    public $modelClass = 'app\modules\nodbt\models\User';
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

}
