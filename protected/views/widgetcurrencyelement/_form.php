<?php
/* @var $this WidgetcurrencyclementController */
/* @var $model WidgetCurrencyElement */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'widget-currency-element-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-form">
		<?php echo $form->labelEx($model,'name',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'buy',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'buy',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'buy'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'sale',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'sale',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sale'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'symbol',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'symbol',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'symbol'); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->