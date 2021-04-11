<?php

/* @var $this yii\web\View */
/* @var $model array */

?>
<div class="send">
    <table style="width: 100%">
        <? if ($model['name']) : ?>
            <tr>
                <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Имя</b></td>
                <td style='padding: 10px; border: #e9e9e9 1px solid;'><?= $model['name'] ?></td>
            </tr>
        <? endif ?>
        <tr>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>Телефон</b></td>
            <td style='padding: 10px; border: #e9e9e9 1px solid;'><?= $model['phone'] ?></td>
        </tr>
    </table>
</div>
