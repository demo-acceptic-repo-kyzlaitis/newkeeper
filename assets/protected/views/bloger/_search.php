<?php
/* @var $this BlogerController */
/* @var $model Bloger */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row-form">
		<?php echo $form->label($model,'user_id',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'pen_name_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'pen_name_en',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'pen_name_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'pen_name_ru',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'pen_name_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'pen_name_uk',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'phone',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'description_en',array('class'=>'span2')); ?>
		<?php echo $form->textArea($model,'description_en',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'description_ru',array('class'=>'span2')); ?>
		<?php echo $form->textArea($model,'description_ru',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'description_uk',array('class'=>'span2')); ?>
		<?php echo $form->textArea($model,'description_uk',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->