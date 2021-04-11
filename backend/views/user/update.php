<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\setting\UserForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h2><?= Html::encode('Редактирование') ?></h2>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <div class="form-content">

            <?= $form->field($model, 'username')->textInput(['placeholder' => true, 'value' => $model->username ? $model->username : $model->_user->username]) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => true, 'value' => $model->email ? $model->email : $model->_user->email]) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => true]) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => true]) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
