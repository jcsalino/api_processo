<?php

namespace app\modules\security\controllers;

use Yii;
use app\modules\security\controllers\NoSecurity;
use app\modules\security\models\User;

class NoAuthController extends NoSecurity
{
    protected function verbs()
    {
        return [
            'login' => ['POST','OPTIONS']
        ];
    }
    public function actionLogin()
    {
        
        $request =  Yii::$app->getRequest()->getBodyParams();
        $email = !empty($request['email'])?$request['email']:'';
        $password = !empty($request['password'])?$request['password']:'';
        if(empty($email) || empty($password)){
            throw new \yii\web\BadRequestHttpException('email and password must be filled in');
        }
        else{
            $user = User::findByEmail($email);
            if(!empty($user)){
                if($user->validatePassword($password)){
                    return [
                        'status' => 'success',
                        'message' => 'Login realizado com sucesso!',
                        'data' => [
                            'id' => $user->id,
                            'full_name' => $user->full_name,
                            'token' => $user->generateToken(),
                        ]
                    ];
                }
            }
            throw new \yii\web\BadRequestHttpException('incorrect email or password');
        }
    }
    public function actionOptions()
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }
        Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST');
    }  
}