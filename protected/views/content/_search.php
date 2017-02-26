<?php
/* @var $this ContentController */
/* @var $model Content */
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
		<?php echo $form->label($model,'title_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'title_en',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'title_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'title_ru',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'title_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'title_uk',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'text_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'text_en',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'text_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'text_ru',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'text_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'text_uk',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->