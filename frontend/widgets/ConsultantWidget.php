<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

class ConsultantWidget extends Widget
{
    public function run()
    {
        return $this->render('consultant/index');
    }
}
