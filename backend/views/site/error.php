<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Такой страницы не существует';
?>
<section class="content">

    <div class="error-page">
        <div class="error-title">
            <p class="error-value">#404</p>
            <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>
        </div>

        <div class="error-content">
            <h3><?= $this->title ?></h3>

            <p>
                <strong>В процессе обработки вашего запроса произошла ошибка.</strong>
            </p>

            <p>Вы не можете посетить текущую страницу по причине:</p>

            <ul>
                <li>
                    <strong>просроченная страница</strong>
                </li>
                <li>
                    <strong>пропущен адрес</strong>
                </li>
                <li>
                    у вас <strong>нет права доступа</strong> на эту страницу
                </li>
            </ul>
        </div>
        <div class="home">
            <a href="/admin"><i class="fa fa-home"></i><span>Вернуться на главную</span></a>
        </div>
    </div>

</section>
