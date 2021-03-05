<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host={{.Env.DB_HOST}};dbname={{.Env.DB_DATABASE}}',
    'username' => '{{.Env.DB_USERNAME}}',
    'password' => '{{.Env.DB_PASSWORD}}',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];