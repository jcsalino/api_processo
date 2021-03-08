<?php

$env = require __DIR__ . '/env.php';
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'api-processo',
    'modules' => [
        'security' => [
            'class' => 'app\modules\security\Module',
        ],
        'nodbt' => [
            'class' => 'app\modules\nodbt\Module',
        ],
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'jwt' => [
            'class' => \bizley\jwt\Jwt::class,
            'signer' => $env['signer'], // Signer ID
            'signingKey' => $env['signingKey'], // Secret key string or path to the signing key file
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8'
        ],
        'user' => [
            'identityClass' => 'app\modules\security\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'prefix' => '',
                    'controller' => [
                        'transaction' => 'transaction',
                        'user' => 'user',
                    ],
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'prefix' => 'security',
                    'controller' => [
                        'noauth' => 'security/no-auth',
                        'transaction' => 'security/transaction',
                        'user' => 'security/user',
                    ],
                    'extraPatterns' =>  [
                        'POST login' => 'login',
                        'OPTIONS <action>' => 'options'
                    ],
                    'pluralize' => false,
                ], 
                [
                    'class' => 'yii\rest\UrlRule', 
                    'prefix' => 'nodbt',
                    'controller' => [
                        'transaction' => 'nodbt/transaction',
                        'user' => 'nodbt/user',
                    ],
                    'extraPatterns' =>  [
                        'POST login' => 'login',
                        'OPTIONS <action>' => 'options'
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
