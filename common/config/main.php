<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => function () {
            if (\common\models\setting\Mail::instance()->protocol != 0) {
                return Yii::createObject([
                    'class' => 'yii\swiftmailer\Mailer',
                    'viewPath' => '@common/mail',
                    'transport' => [
                        'class' => 'Swift_SmtpTransport',
                        'host' => \common\models\setting\Mail::instance()->host,
                        'username' => \common\models\setting\Mail::instance()->login,
                        'password' => \common\models\setting\Mail::instance()->password,
                        'port' => \common\models\setting\Mail::instance()->port,
                        'encryption' => \common\models\setting\Mail::instance()->encryption,
                    ],
                    'useFileTransport' => false,
                ]);
            }
            return Yii::createObject([
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                'useFileTransport' => false,
            ]);
        },
    ],
];
