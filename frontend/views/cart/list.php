<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */

$title = 'Подтверждение заказа';
$this->title = Html::encode($title);
?>

<h1><?= Html::encode($title) ?></h1>

<div class="col-xs-4 well">
<div class="row">
	<div class="col-xs-8"><h4>Вы заказали товар: <?= Html::encode($model->productName)?> </h4></div>
</div>
<div class="row">
	<div class="col-xs-6"><h4>По цене: <?= Html::encode($model->price)?> </h4></div>
</div>

<div class="row">
		<div class="col-xs-6"><h6>Всего доступно: <?= Html::encode($model->productCount)?> </h6></div>
</div>
<div class="row">
<div class="col-xs-6">
	<?php $form = ActiveForm::begin(); ?>
		
			<?= $form->field($model, 'count') ?>
		
	<div class="form-group">
		<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
</div>
</div>