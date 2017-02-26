<?php
/* @var $this CityController */
/* @var $model City */
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
		<?php echo $form->label($model,'name_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'name_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_ru',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'name_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_uk',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'country_id',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'country_id'); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->