<?

use yii\web\JsExpression;

/* @var $this yii\web\View */

$this->title = 'Файловый менеджер';
?>
<div class="file-manager">
    <?= \mihaildev\elfinder\ElFinder::widget([
        'language' => 'ru',
        'controller' => 'elfinder',
        'callbackFunction' => new JsExpression('function(file, id){}')
    ]);
    ?>
</div>
