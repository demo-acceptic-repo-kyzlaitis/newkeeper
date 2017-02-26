<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-form">
		<?php echo $form->labelEx($model,'name',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'title_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'title_en',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title_en'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'title_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'title_ru',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title_ru'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'title_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'title_uk',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title_uk'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'text_en',array('class'=>'span2')); ?>
		<?php echo $form->textArea($model,'text_en',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'text_en'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'text_ru',array('class'=>'span2')); ?>
		<?php echo $form->textArea($model,'text_ru',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'text_ru'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'text_uk',array('class'=>'span2')); ?>
		<?php echo $form->textArea($model,'text_uk',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'text_uk'); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->