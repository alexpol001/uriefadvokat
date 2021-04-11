<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = '404 - Страница не найдена';
?>
<div class="site-error">
    <div class="container">
        <h2><?= Html::encode($this->title) ?></h2>
        <p>Сожалеем но запрашиваемая вами страница не найдена! <a href="/">Перейти на глвную?</a></p>
    </div>
</div>
