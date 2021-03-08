<?php

namespace app\modules\nodbt\controllers;
 
use yii\web\Response;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;





class NoSecurity extends ActiveController
{

    public function behaviors()
    {
        $behaviors = [
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Allow-Headers' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Max-Age' => 3600,
            ]
        ];
        return  $behaviors;
    }
}