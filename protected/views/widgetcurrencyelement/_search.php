<?php
/* @var $this WidgetcurrencyclementController */
/* @var $model WidgetCurrencyElement */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row-form">
		<?php echo $form->label($model,'id',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'name',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'buy',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'buy',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'sale',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'sale',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'symbol',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'symbol',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->