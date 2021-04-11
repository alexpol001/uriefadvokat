<?php

use backend\widgets\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'username',
            'value' => function ($data) {
                return Html::a(Html::encode($data->username), Url::to(['update', 'id' => $data->id]));
            },
            'format' => 'html'
        ],
    ],
    'create' => false,
    'refresh' => false,
    'delete' => false,
]); ?>
