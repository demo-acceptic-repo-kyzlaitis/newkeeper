<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
	'action'=>"cropper/getfile",
    'focus'=>array($model,'avatar_source'),
)); ?>


  
    <?php 
	// echo "<pre>";
	// var_dump($form);
	// echo "</pre>";
	echo $form->fileField($model,'avatar_source'); ?>
	<?php echo "<br>",CHtml::submitButton('OK',array('enctype'=>'multipart/form-data')); ?>


<?php $this->endWidget(); ?>