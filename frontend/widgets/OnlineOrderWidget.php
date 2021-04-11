<?php

namespace frontend\widgets;

use common\models\setting\Mail;
use frontend\controllers\SiteController;
use frontend\models\OnlineOrderForm;
use Yii;
use yii\base\Widget;

/** @property SiteController $controller */
class OnlineOrderWidget extends Widget
{
    public $controller;

    /**
     * @return string
     */
    public function run()
    {
        $model = new OnlineOrderForm();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->sendEmail(Mail::instance()->login)) {
            $this->controller->redirect(['/', 'send' => 1]);
        }
        return $this->render('onlineOrder/index', [
            'model' => $model,
        ]);
    }
}
