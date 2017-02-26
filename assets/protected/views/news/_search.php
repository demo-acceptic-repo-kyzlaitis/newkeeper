<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<!--
	<div class="personal_information">
		<?php echo $form->label($model,'id',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'id',array('size'=>60,'maxlength'=>255, 'class'=>"")); ?>
	</div>-->

	<div class="row-form">
		<?php echo $form->label($model,'name_en',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255, 'class'=>"")); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'name_ru',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_ru',array('size'=>60,'maxlength'=>255, 'class'=>"")); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'name_uk',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'name_uk',array('size'=>60,'maxlength'=>255, 'class'=>"")); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'author_id',array('class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'author_id',CHtml::listData($model->getBlogers(), 'user.id', 'user.username'),array('class'=>"",'empty' => 'Выберите из списка...')); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'category_id',array('class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'category_id',CHtml::listData($model->getCategories(), 'id', 'name_ru'),array('class'=>"",'empty' => 'Выберите из списка...')); ?>
	</div>

	<div class="row-form">
		<?php echo $form->label($model,'type_id',array('class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'type_id',$model->getTypes(),array('class'=>'','empty' => 'Выберите из списка...')); ?>
	</div>
<!--
	<div class="personal_information">
		<?php echo $form->label($model,'source',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255, 'class'=>"text")); ?>
	</div>

	<div class="personal_information">
		<?php echo $form->label($model,'media_source',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'media_source',array('size'=>60,'maxlength'=>255, 'class'=>"text")); ?>
	</div>

	<div class="personal_information">
		<?php echo $form->label($model,'create_time',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="personal_information">
		<?php echo $form->label($model,'update_time',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'update_time'); ?>
	</div>-->

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->