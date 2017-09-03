<?php
$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$db = require(__DIR__ . '/test_db.php');

/**
 * Application configuration shared by all test types
 */
return [
    'id'             => 'basic-tests',
    'basePath'       => dirname(__DIR__),
    'language'       => 'en-EN',
    'modules'        => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'v1'    => [
            'class' => 'app\modules\api\v1\Module',
        ],
    ],
    'components'     => [
        'db'           => $db,
        'mailer'       => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager'   => [
            'showScriptName' => true,
        ],
        'user'         => [
            'identityClass' => 'app\models\User',
        ],
        'request'      => [
            'cookieValidationKey'  => 'test',
            'enableCsrfValidation' => false,
            'parsers'              => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
//        'response'     => [
//            'formatters' => [
//                'json' => [
//                    'class'         => 'yii\web\JsonResponseFormatter',
//                    'prettyPrint'   => YII_DEBUG,
//                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
//                ],
//            ],
//        ],
    ],
    'params'         => $params,

];
