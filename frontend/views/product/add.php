<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\products */
/* @var $form ActiveForm */
?>


<div class="product-add">

    <?php $form = ActiveForm::begin(); ?>
        
        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'count') ?>

        <?= $form->field($model, 'price') ?>

        <?= $form->field($model, 'cat_id') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- product-add -->
