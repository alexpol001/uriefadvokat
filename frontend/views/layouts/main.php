<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\setting\Base;
use common\models\setting\Mail;
use frontend\widgets\ConsultantWidget;
use frontend\widgets\OnlineOrderWidget;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/img/favicon.png'])]);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=Base::instance()->description?>">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Yandex.Metrika counter -->

    <script type="text/javascript" >

        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};

            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})

        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(55023220, "init", {

            clickmap:true,

            trackLinks:true,

            accurateTrackBounce:true,

            webvisor:true

        });

    </script>

    <noscript><div><img src="https://mc.yandex.ru/watch/55023220" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

    <!-- /Yandex.Metrika counter -->

    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146332961-1"></script>

    <script>

        window.dataLayer = window.dataLayer || [];

        function gtag(){dataLayer.push(arguments);}

        gtag('js', new Date());

        gtag('config', 'UA-146332961-1');

    </script>
</head>
<body>
<?php $this->beginBody() ?>
<a href="#" class="scrollup hidden-xs"><i class="fa fa-angle-up"></i></a>
<header>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="title">
                    <div class="logo">
                        <img src="img/logo.png" alt="">
                    </div>
                    <div class="name hidden-xs">
                        <p>Юрьев Михаил Владимирович</p>
                        <h1>Адвокат по уголовным делам в г. Москва</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="call">
                    <div class="phone">
                        <i class="fa fa-phone"></i>
                        <span class="number">
                    <?=Base::instance()->phone?>
                </span>
                    </div>
                    <a href="#" class="online-order" data-toggle="modal" data-target="#myModal">
                        Бесплатный звонок
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<?=$content?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-4">
                <div class="title">
                    <div class="logo">
                        <img src="img/logo.png" alt="">
                    </div>
                    <div class="name hidden-md hidden-sm hidden-xs">
                        <p>Юрьев Михаил Владимирович</p>
                        <h2 class="h1">Адвокат по уголовным делам в г. Москва</h2>
                    </div>
                    <div class="clearfix"></div>
                    <p class="copyright">
                        &copy; 2019 «Адвокат Юрьев Михаил» Все права защищены.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="politics">
                    <a class="email" href="mailto:<?=Mail::instance()->login?>">
                        Email: <?=Mail::instance()->login?>
                    </a>
                    <a href="<?=Base::instance()->politics?>" target="_blank">Политика конфиденциальности</a>
                    <p class="developer">
                        Сайт разработан <a href="http://symbweb.ru" target="_blank" title="Сайты и веб-приложения любой сложности!">Digital-агентством Симбиоз</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="call">
                    <div class="phone">
                        <div class="whatsapp">
                            <img src="img/whatapp.png" alt="">
                        </div>
                        <i class="fa fa-phone"></i>
                        <span class="number">
                    <?=Base::instance()->phone?>
                </span>
                    </div>
                    <a href="#" class="online-order" data-toggle="modal" data-target="#myModal">
                        Бесплатный звонок
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<?=OnlineOrderWidget::widget(['controller' => $this->context]);?>
<?=ConsultantWidget::widget([]);?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
