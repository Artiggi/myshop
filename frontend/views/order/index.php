<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

echo Breadcrumbs::widget([
    'homeLink' => false,
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        [
            'label' => 'К магазину',
            'url' => ['catalog/list'],
        ],
        'Ваши заказы',
    ],
]);

/*
$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
*/
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'productName',
            'price',
            ['attribute'=> 'count', 'label'=>'Количество'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
