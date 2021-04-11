<?php

namespace common\components;

use yii\captcha\CaptchaAction;

class NumericCaptcha extends CaptchaAction
{

    public $fontFile = '@webroot/font/Exo2/Exo2-ExtraBoldItalic.ttf';
    public $offset = '0';

    protected function generateVerifyCode()
    {
        //Длина
        $length = 4;

        //Цифры, которые используются при генерации
        $digits = '0123456789';

        $code = '';
        for($i = 0; $i < $length; $i++) {
            $code .= $digits[mt_rand(0, 9)];
        }
        return $code;
    }
}