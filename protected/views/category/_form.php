<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
if(strpos($this->layout,'admin'))
{
    $text = '';
    $textarea = '';
    $row_class = 'row-form';
    $label_class = 'span2';
    $area_class = $row_class;
    $check = '';
    $checkbox = 'row-form news_checkbox';
}else{
    $text = 'text';
    $textarea = 'textarea';
    $row_class = 'personal_information';
    $label_class = '';
    $area_class = 'personal_area';
    $check = 'check';
    $checkbox = 'checkboxes checkbox_news';
}
?>

<div class="form block-fluid">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'name_en',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'name_ru',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'name_ru',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'name_ru'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'name_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'name_uk',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'name_uk'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'image',array('class'=>$label_class)); ?>
        <?php if(!$model->getIsNewRecord()): ?>
            <?php echo $model->previewThumb(News::PREVIEW_SIZE); ?>
        <?php endif; ?>
        <a class="source_upld source" href="javascript:void(0)">
        <span><?php echo $form->fileField($model,'image'); ?></span>
        </a>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->