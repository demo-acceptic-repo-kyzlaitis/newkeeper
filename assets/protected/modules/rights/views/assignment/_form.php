<?php $form=$this->beginWidget('CActiveForm'); ?>
	
	<div class="row-form">
    <label class="span2"><?php echo Rights::t('core', 'Assign item'); ?></label>
		<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
		<?php echo $form->error($model, 'itemname'); ?>
	</div>
	
	<div class="toolbar bottom TAR">
		<?php echo CHtml::submitButton(Rights::t('core', 'Assign'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>
