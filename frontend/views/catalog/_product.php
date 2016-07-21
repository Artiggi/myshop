<?php
use yii\helpers\Html;
?>
<?php /** @var $model \common\models\Product */ ?>
<div class="col-xs-12 well">
    <div class="col-xs-4">
        <h2><?= Html::encode($model->name) ?></h2>
    </div>

    <div class="col-xs-4">
        <h3><div class="col-xs-12">$<?= $model->price ?></div></h3>
    </div>

	<div class="col-xs-4">
		<h3><div class="col-xs-12"><?= Html::a('Добавить в заказ', ['cart/add', 'id' => $model->id], ['class' => 'btn btn-success'])?></div></h3>
	</div>
</div>