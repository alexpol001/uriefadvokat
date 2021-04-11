<?php
namespace backend\components;

use yii\base\Component;
use yii\helpers\Url;

class UrlProvider extends Component {

    public static function getUrlUser($user){
        return Url::to(['/user/update', 'id' => $user->id]);
    }

    public static function getUrlResetPassword(){
        return Url::to(['/site/request-password-reset']);
    }
}
