<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'public/iframe',
    'aliases' => [
        '@rbac' => '@backend/modules/rbac',
    ],
    'modules' => [
        'rbac' => ['class' => 'rbac\Module',],
        'global-setting' => [
            'class' => 'common\components\globalSetting\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'rbac\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['/public/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'logFile' => '@app/runtime/logs/'.date('Ymd').'/app_'.date('H').'.log',
                    'maxFileSize' => 2048 * 2,
                    'maxLogFiles' => 1000,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'public/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'rbac\components\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
            'ruleTable' => 'auth_rule',
        ],
        //????????????????????? jquery ??? bootstrap.css ??????
        'assetManager'=>[
            'bundles'=>[
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],  // ?????? bootstrap.css
                    'sourcePath' => null, // ????????? web/asset ???????????????
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],  // ?????? bootstrap.js
                    'sourcePath' => null,  // ????????? web/asset ???????????????
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'global-setting' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/components/globalSetting/messages',
                    'forceTranslation' => true,
                    'fileMap' => [
                        'global-setting' => 'setting.php',
                    ]
                ],
            ],
        ],
    ],
    'as access' => [
        'class' => 'rbac\components\AccessControl',
        'allowActions' => [
            'public/login',
            'public/logout',
            'public/error',
            'gii/*',
        ]
    ],
    'params' => $params,
];
