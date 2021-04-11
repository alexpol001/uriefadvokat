<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * User form
 * @property User $_user
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    public $_user;

    public function __construct($user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Этот логин уже занят.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Этот email уже занят.'],

            ['password', 'string', 'min' => 5],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Пароли не совпадают."],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update()
    {
        if (!$this->validate()) {
            return null;
        }
        /** @var User $user */
        $this->_user->username = $this->username;
        $this->_user->email = $this->email;
        if ($this->password) {
            $this->_user->setPassword($this->password);
        }
        return $this->_user->save() ? $this->_user : null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'E-Mail',
            'password' => 'Пароль',
            'password_repeat' => 'Подтвердите пароль'
        ];
    }
}
