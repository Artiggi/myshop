<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Menu;
/* @var $this yii\web\View */

$title = 'Витрина';
$this->title = Html::encode($title);
?>

<h1><?= Html::encode($title) ?></h1>

<div class="container-fluid">
  <div class="row">
      <div class="col-xs-8">
          <?= ListView::widget([
              'dataProvider' => $productsDataProvider,
              'itemView' => '_product',
          ]) ?>
      </div>
  </div>
</div>