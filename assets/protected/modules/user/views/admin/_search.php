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
        <?php echo $form->label($model,'username',array('class'=>'span2')); ?>
        <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
    </div>

    <div class="row-form">
        <?php echo $form->label($model,'email',array('class'=>'span2')); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row-form">
        <?php echo $form->label($model,'activkey',array('class'=>'span2')); ?>
        <?php echo $form->textField($model,'activkey',array('size'=>60,'maxlength'=>128)); ?>
    </div>

    <div class="row-form">
        <?php echo $form->label($model,'created',array('class'=>'span2')); ?>
        <?php echo $form->textField($model,'created'); ?>
    </div>

    <div class="row-form">
        <?php echo $form->label($model,'lastvisit_at',array('class'=>'span2')); ?>
        <?php echo $form->textField($model,'lastvisit_at'); ?>
    </div>

    <div class="row-form">
        <?php echo $form->label($model,'superuser',array('class'=>'span2')); ?>
        <?php echo $form->dropDownList($model,'superuser',$model->itemAlias('AdminStatus')); ?>
    </div>

    <div class="row-form">
        <?php echo $form->label($model,'status',array('class'=>'span2')); ?>
        <?php echo $form->dropDownList($model,'status',$model->itemAlias('UserStatus')); ?>
    </div>

    <div class="toolbar bottom TAR">
        <?php echo CHtml::submitButton(UserModule::t('Search'),array('class'=>'btn btn-primary')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->