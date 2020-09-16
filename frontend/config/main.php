<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'defaultRoute' => 'landing',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'frontend\models\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/messages',
                    'prefix' => 'api',
                    'patterns' => [
                        'GET {id}' => 'view',
                        'POST {id}' => 'create',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/tasks',
                    'prefix' => 'api',
                    'patterns' => [
                        'GET' => 'index',
                    ],
                ],
                '//' => '/',
                'tasks' => 'tasks/index',
                'task/view/<id:\d+>' => 'tasks/view',
                'reply/<id:\d+>' => 'tasks/reply',
                'decline/<id:\d+>' => 'tasks/decline',
                'complete/<id:\d+>' => 'tasks/complete',
                'users' => 'users/index',
                'events' => 'events/index',
                'user/view/<id:\d+>' => 'users/view',
                'user/addfavourite/<id:\d+>' => 'users/addfavourite',
                'location/<query:.*>' => 'location/',
                'mytasks' => 'mytasks/new',
                'settings' => 'settings/index',
                'changecity' => 'site/changecity',
            ],
        ],

    ],
    'params' => $params,
];
