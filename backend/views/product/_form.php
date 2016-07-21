<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model frontend\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        
        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'count') ?>

        <?= $form->field($model, 'price') ?>

        <?= $form->field($model, 'cat_id')->dropDownList($catItems)



        ?>


		<div class="row">
			<div class="panel panel-default">
		        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Атрибуты продукта</h4></div>
		        <div class="panel-body">
		             <?php DynamicFormWidget::begin([
		                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
		                'widgetBody' => '.container-items', // required: css class selector
		                'widgetItem' => '.item', // required: css class
		                'limit' => 10, // the maximum times, an element can be cloned (default 999)
		                'min' => 1, // 0 or 1 (default 1)
		                'insertButton' => '.add-item', // css class
		                'deleteButton' => '.remove-item', // css class
		                'model' => $modelAttr[0],
		                'formId' => 'dynamic-form',
		                'formFields' => [
		                    'name',
		                    'value',
		                ],
		            ]); ?>

		            <div class="container-items"><!-- widgetContainer -->
		            <?php foreach ($modelAttr as $i => $modelAttr): ?>
		                <div class="item panel panel-default"><!-- widgetBody -->
		                    <div class="panel-heading">
		                        <h3 class="panel-title pull-left">Добавить/Удалить атрибут</h3>
		                        <div class="pull-right">
		                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
		                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
		                        </div>
		                        <div class="clearfix"></div>
		                    </div>
		                    <div class="panel-body">
			                <?php
			                    // necessary for update action.
			                    if (! $modelAttr->isNewRecord) {
			                        echo Html::activeHiddenInput($modelAttr, "[{$i}]id");
			                    }
			                    ?>
		                        <div class="row">
		                            <div class="col-sm-6">
		                                <?= $form->field($modelAttr, "[{$i}]name")->textInput(['maxlength' => true]) ?>
		                            </div>
		                            <div class="col-sm-6">
		                                <?= $form->field($modelAttr, "[{$i}]value")->textInput(['maxlength' => true]) ?>
		                            </div>
		                    	</div>
			                </div>
			            	<?php endforeach; ?>
			            </div>
			            <?php DynamicFormWidget::end(); ?>
			        </div>
			    </div>
			</div>


    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
