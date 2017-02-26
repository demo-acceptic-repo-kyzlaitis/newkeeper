

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
if(strpos($this->layout,'admin'))
{
    $text = '';
    $textarea = '';
    $row_class = 'row-form';
    $label_class = 'span2';
    $area_class = $row_class;
    $check = 'adm_check';
    $checkbox = 'row-form news_checkbox';
    $button_block = 'toolbar bottom TAR';
    $button_class = 'btn btn-primary';
}else{
    $text = 'text';
    $textarea = 'textarea';
    $row_class = 'personal_information';
    $label_class = '';
    $area_class = 'personal_area';
    $check = 'check';
    $checkbox = 'checkboxes checkbox_news';
    $button_block = 'buttom_registration';
    $button_class = '';
}
?>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

<?php if($update):?>
	<div class="row-form">
		<?php echo $model->getAvatar(100,'form_ava'); ?>
	</div>
 <?php endif; ?>

	<div class="row-form">
		<?php echo $form->labelEx($model,'username',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20,'class'=>$text)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'password',array('class'=>'span2')); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128,'class'=>$text)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'email',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128,'class'=>$text)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'superuser',array('class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('class'=>$text)); ?>
		<?php echo $form->error($model,'superuser'); ?>
	</div>

	<div class="row-form">
		<?php echo $form->labelEx($model,'status',array('class'=>'span2')); ?>
		<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus'),array('class'=>$text)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			?>
	<div class="row-form">
		<?php echo $form->labelEx($profile,$field->varname,array('class'=>'span2')); ?>
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255),'class'=>$text));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>
			<?php
			}
		}
?>
	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
