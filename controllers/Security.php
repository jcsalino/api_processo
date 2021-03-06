<?php

namespace app\controllers;
 
use yii\web\Response;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;  
use yii\filters\auth\{CompositeAuth, HttpBearerAuth};



class Security extends ActiveController
{
   const KE_VALI = 10;
   const KST_SUCSS = "sucesso";

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
            'Access-Control-Request-Method'    => ['*'],
            'Access-Control-Allow-Origin'    => ['*'],
            'Access-Control-Allow-Headers' => ['*'],
            'Access-Control-Request-Headers' => ['*'],
            'Access-Control-Max-Age' => 3600,
        ]];
        $behaviors['authenticator'] = [
         'class' => CompositeAuth::class,
         'authMethods' => [
            HttpBearerAuth::class,
         ],
      ];
      $behaviors['authenticator']['except'] = ['options'];
      return  $behaviors;
   }

}