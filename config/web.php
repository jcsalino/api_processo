<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'enableCookieValidation'   => false,
            'enableCsrfValidation'     => false,
            'parsers'                  => [
              'application/json' => 'yii\web\JsonParser',
            ]
          ],
          'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8'
          ],
          'user' => [
            'identityClass'   => 'app\modules\v0\models\Usuario',
            'enableSession'   => false,
            'loginUrl'        => null,
          ],
          // 'errorHandler' => [
          //     'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
          // ],
          'db' => $db,
          'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class'        => 'yii\rest\UrlRule', 
                    'prefix'       => 'api',
                    'controller'   => [
                                      'transaction'                => 'transaction',
                    ],
                    'extraPatterns' =>  [
                    ],
                    'pluralize' => false,
                ],
            ],
          ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
