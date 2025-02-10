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
    'timeZone' => 'Europe/Moscow',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mp_oGTz3cxp-XVwmqbvZRHGs3tTHW5zJ',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        'response' => [
            'format' =>  \yii\web\Response::FORMAT_JSON
        ],
        // 'serializer' => [
        //     'class' => 'yii\rest\Serializer',
        //     'collectionEnvelope' => 'items',
        // ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'jwt' => [
            'class' => \bizley\jwt\Jwt::class,
            'signer' => \bizley\jwt\Jwt::ES256,
            'signingKey' => [
                'key' => '../keys/private.pem',
                'method' => \bizley\jwt\Jwt::METHOD_FILE,
            ],
            'verifyingKey' => [
                'key' => '../keys/public.pem',
                'method' => \bizley\jwt\Jwt::METHOD_FILE,
            ],
            'validationConstraints' => static function (\bizley\jwt\Jwt $jwt) {
                $config = $jwt->getConfiguration();
                return [
                    new \Lcobucci\JWT\Validation\Constraint\SignedWith($config->signer(), $config->verificationKey()),
                    new \Lcobucci\JWT\Validation\Constraint\LooseValidAt(
                        new \Lcobucci\Clock\SystemClock(new \DateTimeZone(\Yii::$app->timeZone)),
                        new \DateInterval('PT10S')
                    ),
                ];
            },
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'category'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'product'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'property', 'only' => ['index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'product-property', 'only' => ['index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'defect', 'only' => ['index']],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'vendor',
                    'extraPatterns' => [
                        'GET name/<name>' => 'name'
                    ]
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'office'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'advertisement'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'image',
                    'extraPatterns' => [
                        'OPTIONS,POST upload' => 'upload'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'auth',
                    'extraPatterns' => [
                        'OPTIONS,POST register' => 'register',
                        'OPTIONS,POST login' => 'login',
                        'OPTIONS,GET me' => 'me',
                    ],
                ],
            ],
        ],
    ],
    'as cors' => [
        'class' => \yii\filters\Cors::class,
        'cors' => [
            'Origin' => ['http://localhost:3032'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
            'Access-Control-Allow-Credentials' => true, // Разрешить учётные данные (cookies и т. д.)
            'Access-Control-Max-Age' => 3600, // Кэшировать предполетный ответ на 1 час
            // 'Access-Control-Allow-Headers' => ['*']
            'Access-Control-Allow-Headers' => ['origin', 'authorization', 'X-Requested-With', 'X-Auth-Token', 'content-type']
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
