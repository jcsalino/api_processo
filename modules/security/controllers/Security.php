<?php

namespace app\modules\security\controllers;

use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;  
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use bizley\jwt\JwtHttpBearerAuth;
use Lcobucci\JWT\Signer;

class Security extends ActiveController
{

    public function behaviors()
    {
        Yii::$app->jwt->getConfiguration()
        ->setValidationConstraints(
            new LooseValidAt(SystemClock::fromSystemTimezone()),
            new SignedWith(
                Yii::$app->jwt->getConfiguration()->signer(),
                Yii::$app->jwt->getConfiguration()->signingKey()
            ),
        );
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
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'except' => ['options'],
        ];
        return  $behaviors;
    }

}