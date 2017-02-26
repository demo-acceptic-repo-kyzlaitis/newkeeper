<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'city-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-form">
		<?php echo $form->labelEx($model,'name_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'name_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_ru',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name_ru'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'name_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_uk',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name_uk'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'country_id',array('class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'country_id', CHtml::listData($model->getCountries(), 'id','name_ru')); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'temp',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'temp',array('size'=>30,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'temp'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'traffic',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'traffic',array('size'=>30,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'traffic'); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->