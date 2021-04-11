<?php
namespace frontend\controllers;

use common\models\setting\Mail;
use common\models\swp\Group;
use frontend\models\OnlineOrderForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @param int $send
     * @return mixed
     */
    public function actionIndex($send = 0)
    {
        $model = new OnlineOrderForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendEmail(Mail::instance()->login)) {
            return $this->redirect(['/', 'send' => 1]);
        }
        if ($send) {
            Yii::$app->session->setFlash('onlineOrderFormSubmitted');
            return $this->redirect('/');
        }

        $serviceModel = Group::findOne(7)->materials;
        $caseModel = Group::findOne(9)->materials;
        $pricesModel = Group::findOne(16)->materials;
        $consultationModel = Group::findOne(14)->materials;
        return $this->render('index', [
            'model' => $model,
            'serviceModel' => $serviceModel,
            'caseModel' => $caseModel,
            'pricesModel' => $pricesModel,
            'consultationModel' => $consultationModel,
        ]);
    }
}
