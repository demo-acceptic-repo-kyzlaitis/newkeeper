<?php
/* @var $this BlogerController */
/* @var $model Bloger */
/* @var $form CActiveForm */
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
<?php if(!strpos($this->layout,'admin')): ?>
<p class="registration_title">
<?php echo $summary->getText();?>
</p>
<?php endif; ?>
<div class="form block-fluid">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blogger-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<?php if(isset($update)): ?>
        <!--<p>Username: <?php echo $model->user->username; ?></p>-->
<?php else: ?>
<?php if(isset($users)): ?>
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'user_id',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'user_id', CHtml::listData($users, 'id', 'username'), array('class'=>$text)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>
<?php endif; ?>
<?php endif; ?>
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'pen_name_en',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'pen_name_en',array('size'=>60,'maxlength'=>255, 'class'=>$text)); ?>
		<?php echo $form->error($model,'pen_name_en'); ?>
	</div>
<!--
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'pen_name_ru',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'pen_name_ru',array('size'=>60,'maxlength'=>255, 'class'=>$text)); ?>
		<?php echo $form->error($model,'pen_name_ru'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'pen_name_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'pen_name_uk',array('size'=>60,'maxlength'=>255, 'class'=>$text)); ?>
		<?php echo $form->error($model,'pen_name_uk'); ?>
	</div>-->

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'phone',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255, 'class'=>$text)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'description_en',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'description_en',array('rows'=>6, 'cols'=>50, 'class'=>$textarea)); ?>
		<?php echo $form->error($model,'description_en'); ?>
	</div>
<!--
	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'description_ru',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'description_ru',array('rows'=>6, 'cols'=>50, 'class'=>$textarea)); ?>
		<?php echo $form->error($model,'description_ru'); ?>
	</div>

	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'description_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'description_uk',array('rows'=>6, 'cols'=>50, 'class'=>$textarea)); ?>
		<?php echo $form->error($model,'description_uk'); ?>
	</div>-->
<?php if(strpos($this->layout,'admin')):?>
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'status',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'status',$model->getStatuses(), array('class'=>$text)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
<?php endif; ?>
    <div class="<?php echo $checkbox; ?>">
        <div class="<?php echo $check;?>">
			<?php echo $form->checkBox($model,'journalist'); ?>
        </div>
		<p><label class="<?php echo $label_class?>"><?php echo Yii::t('app','Я пишу для других издательств');?></label></p>
		<?php echo $form->error($model,'journalist'); ?>
	</div>
<?php if(!strpos($this->layout,'admin')):?>
	<div class="<?php echo $checkbox; ?>">
        <div class="<?php echo $check;?>">
            <input type="checkbox" name="rules" />
        </div>
		<p><label class="<?php echo $label_class?>" id="chk_rules"><?php echo Yii::t('app','Я ознакомлен с')." ".CHtml::link(Yii::t("app","правилами"),Yii::app()->createUrl("/site/page_with_blog_rules"))." ".
		Yii::t("app",'получения статуса "Блогер"')?></label></p>
	</div>
<?php endif; ?>    
<?php if(isset($users)): ?>
	<div class="<?php echo $checkbox; ?>">
		<p><label class="<?php echo $label_class?>"><?php echo Yii::t('app','Проверенный');?></label></p>
            <div class="<?php echo $check;?>">
		<?php echo $form->checkBox($model,'tried'); ?>
            </div>
		<?php echo $form->error($model,'tried'); ?>
	</div>
<?php endif; ?>

	<div class="<?php echo $button_block; ?>">
		<?php echo CHtml::submitButton($model->isNewRecord || $model->status != 1 ? Yii::t('app','Отправить заявку') : Yii::t('app','Обновить'),array('id'=>'blg_sbmt_btn','class'=>$button_class)); //js в main.php ~170 строка?>
	</div>

<?php $this->endWidget(); ?>
</div>