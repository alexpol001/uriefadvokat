<?php

/* @var $this yii\web\View */

/* @var $serviceModel \common\models\swp\Material[] */

/* @var $caseModel \common\models\swp\Material[] */

/* @var $pricesModel \common\models\swp\Material[] */

/* @var $consultationModel \common\models\swp\Material[] */

use common\models\setting\Base;
use frontend\models\OnlineOrderForm;
use yii\bootstrap\ActiveForm;

$this->title = Base::instance()->title;
?>
<section id="about" class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6">
                <div class="welcome">
                    <div class="person hidden-md hidden-sm hidden-xs">
                        <img src="img/person.png" alt="">
                    </div>
                    <div class="description">
                        <h2>Адвокат по уголовным делам</h2>
                        <p class="name">Юрьев Михаил Владимирович</p>
                        <p class="index hidden-xs">Регистрационный номер <?= Base::instance()->index ?></p>
                        <p class="experience hidden">Успешно выигрываю уголовные дела уже <?= (16 + (Date('Y')) - 2019) ?>
                            лет!</p>
                        <div class="speaker">
                            Готов защищать вас 24/7<br>
                            Результат гарантирую!
                        </div>
                        <div class="confidence hidden-xs">
                            <span>Конфиденциальность гарантирована</span> <i class="fa fa-thumbs-up"></i>
                        </div>
                        <a class="to-down hidden-xs hidden-sm" href="#"><i class="fa fa-angle-down"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-6">
                <div class="order-form wow zoomIn" data-wow-duration="0.5s">
                    <h3>
                        Получите бесплатную консультацию по решению вашей проблемы!
                    </h3>
                    <?php $form = ActiveForm::begin(['id' => 'about-form']); ?>
                    <p class="instruction">
                        Оставьте свой номер телефона и я свяжусь
                        с вами в течении 5 минут и сразу помогу
                        решить вашу проблему.
                    </p>
                    <?php $model = new OnlineOrderForm() ?>

                    <?= $form->field($model, 'phone', ['inputOptions' => ['id' => $form->getId() . '-phone']])->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '+7 (999) 999-99-99', 'clientOptions' => ['showMaskOnHover' => false]
                    ])->textInput(['placeholder' => '+7 (919) 411-88-98']) ?>

                    <?= $form->field($model, 'check', ['template' => "{label}\n{input}", 'inputOptions' => ['id' => $form->getId() . '-check']])->label(false)->textInput(['placeholder' => true])->hiddenInput() ?>

                    <div class="form-group">
                        <button class="online-order" type="submit" onclick="yaCounter55023220.reachGoal('f1'); return true;">
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
</section>
<section id="service" class="service">
    <div class="container">
        <h2>
            Я способен защитить вас и выиграть суд если вас обвиняют в:
        </h2>
        <? if (count($serviceModel)) : ?>
            <div class="row service-list">
                <? foreach ($serviceModel as $item) : ?>
                    <div class="col-md-3 col-sm-4">
                        <a href="#" data-toggle="modal" data-target="#myModal" class="service-item wow fadeIn" data-wow-duration="0.5s">
                            <div class="service-image">
                                <img src="<?= $item->getValue(19) ?>" alt="">
                            </div>
                            <div class="service-text">
                                <h3><?= $item->title ?></h3>
                                <p class="article"><?= $item->getValue(18) ?></p>
                            </div>
                        </a>
                    </div>
                <? endforeach; ?>
            </div>
        <? endif; ?>
        <a href="#" class="online-order big-button" data-toggle="modal" data-target="#myModal">Получить мою защиту</a>
    </div>
</section>
<section id="stages" class="stages">
    <div class="container">
        <h2>Мы начнём доказывать вашу невиновность уже сегодня!</h2>
        <p class="sub-title">
            Самый важный ресурс в нашем случае это - время!
        </p>
        <div class="row wow fadeInLeft" data-wow-duration="0.5s">
            <div class="col-sm-3 stage-item">
                <div class="wrap">
                    <div class="stage-icon">
                        <i class="fa fa-volume-control-phone"></i>
                    </div>
                    <p class="description">
                        Оставьте заявку или позвоните по номеру телефона
                    </p>
                </div>
            </div>
            <div class="col-sm-5 stage-item">
                <div class="wrap">
                    <div class="stage-icon">
                        <i class="fa fa-comments"></i>
                    </div>
                    <p class="description">
                        Получите предварительную консультацию по телефону и примите решение о сотрудничестве
                    </p>
                    <div class="arrow arrow-left hidden-xs">
                        <img src="img/arrow1.png" alt="">
                    </div>
                    <div class="arrow arrow-right hidden-xs">
                        <img src="img/arrow1.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 stage-item">
                <div class="wrap">
                    <div class="stage-icon">
                        <i class="fa fa-child"></i>
                    </div>
                    <p class="description">
                        Вы под надежной защитой Собираем все доказательства невиновности
                    </p>
                </div>
            </div>
        </div>
        <a href="#" class="online-order big-button wow fadeInRight" data-wow-duration="0.5s" data-toggle="modal" data-target="#myModal">Оставить заявку</a>
    </div>
</section>
<section id="portfolio" class="portfolio">
    <div class="container">
        <h2>Немного опыта из моей практики по уголовным делам</h2>
        <? if ($n = count($caseModel)) :?>
        <div class="row">
            <? for ($i = 0; $i < $n; $i++) :?>
            <div class="col-md-4 portfolio-item">
                <div class="portfolio-button wow zoomIn" data-wow-duration="0.5s">
                    Кейс <?=($i+1)?> <?=$caseModel[$i]->title?>
                </div>
            </div>
            <? endfor; ?>
        </div>
        <div class="row">
            <? foreach ($caseModel as $item) :?>
            <div class="portfolio-content">
                <div class="col-md-6">
                    <div class="description wow fadeInLeft" data-wow-duration="0.5s">
                        <?=$item->getValue(21)?>
                    </div>
                </div>
                <?
                $documents = $item->getMaterials(11)
                ?>
                <? if (count($documents)) :?>
                <div class="col-md-6 hidden-xs">
                    <div class="documents wow fadeInRight" data-wow-duration="0.5s">
                        <? foreach ($documents as $document) :?>
                        <a href="<?=$document->getValue(23)?>" target="_blank"><img src="<?=$document->getValue(24)?>" alt="">
                            <div class="darker"><i class="fa fa-search-plus"></i></div>
                        </a>
                        <? endforeach; ?>
                    </div>
                </div>
                <? endif; ?>
                <div class="clearfix"></div>
            </div>
            <? endforeach;?>
        </div>
        <? endif;?>
        <a href="#" class="online-order big-button" data-toggle="modal" data-target="#myModal">Получить помощь</a>
    </div>
</section>
<section id="prices" class="prices">
    <div class="container">
        <h2>Стоимость моих услуг</h2>
        <p class="sub-title">
            Окончательная стоимость услуг уголовного адвоката определяется в ходе личной консультации и ознакомления с материалами Вашего дела.
        </p>
        <? if ($n = count($pricesModel)) :?>
        <div class="row">
            <? foreach ($pricesModel as $price) :?>
            <div class="col-lg-4 col-sm-6">
                <a href="#" data-toggle="modal" data-target="#myModal" class="price-item">
                    <div class="price-text-wrap">
                        <h3><?=$price->title?></h3>
                        <? if ($description = $price->getValue(32)) :?>
                        <p class="price-description">
                            <?=$description?>
                        </p>
                        <? endif; ?>
                    </div>
                    <div class="worth">
                        Стоимость - <?=$price->getValue(33)?> рублей
                    </div>
                    <div class="button">
                        Заказать
                    </div>
                </a>
            </div>
            <? endforeach; ?>
        </div>
        <? endif; ?>
    </div>
</section>
<section id="consultation" class="consultation">
    <div class="container">
        <h2>Оставьте заявку на бесплатную консультацию</h2>
        <div class="row">
            <div class="col-md-7 advantages wow fadeInLeft" data-wow-duration="0.5s">
                <h3>
                    После бесплатной консультации по телефону вы получите:
                </h3>
                <? if ($consultationModel) : ?>
                    <? foreach ($consultationModel as $item) : ?>
                        <div class="advantage-item">
                            <i class="fa fa-check-circle"></i>
                            <p class="advantage-text">
                                <?= $item->title ?>
                            </p>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
                <p class="additional">
                    Дальнейшее решение о сотрудничестве принимаете только вы!
                </p>
            </div>
            <div class="col-lg-offset-1 col-md-5 col-lg-4 wow fadeInRight" data-wow-duration="0.5s">
                <div class="order-form">
                    <h3>
                        Получите бесплатную консультацию прямо сейчас!
                    </h3>
                    <?php $form = ActiveForm::begin(['id' => 'consultation-form']); ?>
                    <?= $form->field($model, 'name', ['inputOptions' => ['id' => $form->getId() . '-name']])->label(false)->textInput(['placeholder' => true]) ?>

                    <?= $form->field($model, 'phone', ['inputOptions' => ['id' => $form->getId() . '-phone']])->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '+7 (999) 999-99-99', 'clientOptions' => ['showMaskOnHover' => false]
                    ])->textInput(['placeholder' => '+7 (919) 411-88-98']) ?>

                    <?= $form->field($model, 'check', ['template' => "{label}\n{input}", 'inputOptions' => ['id' => $form->getId() . '-check']])->label(false)->textInput(['placeholder' => true])->hiddenInput() ?>

                    <div class="form-group">
                        <button class="online-order" type="submit" onclick="dataLayer.push({'event': 'freeconsultation'});">
                                <span class="main-title">
                                    Получить консультацию
                                </span>
                            <span class="sub-title">
                                    это бесплатно
                                </span>
                        </button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="map" class="map">
    <div class="container">
        <h2>Как меня найти?</h2>
    </div>
    <div class="map-wrap">
        <?= Base::instance()->map ?>
        <div class="container">
            <div class="order-form wow zoomIn" data-wow-duration="0.5s">
                <h3>
                    <?= Base::instance()->address ?>
                </h3>
                <p class="questions">
                    У вас остались вопросы?
                </p>
                <p class="instruction">
                    Заполните форму ниже и я обязательно свяжусь с вами!
                </p>
                <?php $form = ActiveForm::begin(['id' => 'map-form']); ?>

                <?= $form->field($model, 'phone', ['inputOptions' => ['id' => $form->getId() . '-phone']])->label(false)->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => '+7 (999) 999-99-99', 'clientOptions' => ['showMaskOnHover' => false]
                ])->textInput(['placeholder' => '+7 (919) 411-88-98']) ?>

                <?= $form->field($model, 'check', ['template' => "{label}\n{input}", 'inputOptions' => ['id' => $form->getId() . '-check']])->label(false)->textInput(['placeholder' => true])->hiddenInput() ?>

                <div class="form-group">
                    <button class="online-order" type="submit" onclick="dataLayer.push({'event': 'callorder'});">
                        Заказать звонок
                    </button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
