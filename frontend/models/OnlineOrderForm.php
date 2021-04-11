<?php
namespace frontend\models;

use common\models\setting\Base;
use Yii;
use yii\base\Model;

class OnlineOrderForm extends Model
{
    public $name;
    public $phone;
    public $check;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}$/', 'message' => 'Неверный формат сотового телефона'],
            [['name', 'check'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'check' => 'Привет бот',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        if (!$this->check && $this->validate()) {
            return Yii::$app->mailer
                ->compose(
                    ['html' => 'online-order/html', 'text' => 'online-order/text'],
                    ['model' => $this]
                )
                ->setTo($email)
                ->setFrom([$email => Base::instance()->title])
                ->setSubject('Заявка с сайта | ' . Base::instance()->title)
                ->send();
        }
        return false;
    }
}
