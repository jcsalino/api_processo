<?php

namespace app\controllers;

use app\models\User;
use Yii;

class UserController extends NoSecurity
{
    public $modelClass = 'app\models\User';
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
