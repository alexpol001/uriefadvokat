<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>

<?php if (Yii::$app->session->hasFlash('onlineOrderFormSubmitted')) { ?>

    <?php
    $this->registerJs(
        "$('#myModalSendOk').modal('show');",
        yii\web\View::POS_READY
    );
    ?>

    <!-- Modal -->
    <div class="modal fade" id="myModalSendOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Бесплатная консультация</h4>
                </div>
                <div class="modal-body">
                    <p>Благодарим вас за заявку. Мы свяжемся с вами в ближайшее время.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="order-form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">х</span></button>
                </div>
                <h3>
                    Получите бесплатную консультацию по решению вашей проблемы!
                </h3>
                <?php $form = ActiveForm::begin(['id' => 'order-form']); ?>
                <p class="instruction">
                    Оставьте свой номер телефона и я свяжусь
                    с вами в течении 5 минут и сразу помогу
                    решить вашу проблему.
                </p>

                <?= $form->field($model, 'phone', ['inputOptions' => ['id' => $form->getId() . '-phone']])->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '+7 (999) 999-99-99', 'clientOptions' => ['showMaskOnHover' => false]
                ])->textInput(['placeholder' => '+7 (919) 411-88-98']) ?>

                <?= $form->field($model, 'check', ['template' => "{label}\n{input}", 'inputOptions' => ['id' => $form->getId() . '-check']])->label(false)->textInput(['placeholder' => true])->hiddenInput() ?>

                <div class="form-group">
                    <button class="online-order" type="submit" onclick="dataLayer.push({'event': 'onlinecal'});">
                                <span class="main-title">
                                    Получить консультацию
                                </span>
                        <span class="sub-title">
                                    это бесплатно
                                </span>
                    </button>
                </div>
                <?php ActiveForm::end(); ?>
                <p class="addition">
                    Бесплатная консультация по телефону ни к чему вас не обязывает.
                </p>
                <p class="limit">
                    В месяц беру не больше 4 дел!
                </p>
            </div>
        </div>
    </div>
</div>

