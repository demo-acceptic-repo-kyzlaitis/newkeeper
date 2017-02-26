<?php
/* @var $this NewsController */
/* @var $model News */
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



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'lang',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'lang', $model->getLangsAdmin(),array('class'=>$text)); ?>
		<?php echo $form->error($model,'lang'); ?>
	</div>
    
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'source',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'source'); ?>
        <p><?php echo $form->labelEx($model,'fixed',array('class'=>$label_class)); ?></p>
    	<div class="<?php echo $check;?> <?php echo ($model->fixed == 1 ? 'active' : '');?>">
    		<?php echo $form->checkBox($model,'fixed'); ?>
    		<?php echo $form->error($model,'fixed'); ?>
    	</div>
	</div>
<div class="news_title">
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
</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'category_id',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'category_id', CHtml::listData($model->getCategories(), 'id', 'name_ru'),array('class'=>$text)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'status',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'status', $model->getStatuses(),array('class'=>$text)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'type_id',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'type_id', $model->getTypes(),array('class'=>$text)); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

<div class="<?php echo $row_class;?>">
<?php echo $form->labelEx($model,'preview_source',array('class'=>$label_class)); ?>
	<div id="<?php echo $blog?>" class="display_thumb">
        <div class="img_cont">
            <?php echo CHtml::image('/uploads/preview/'.$model->preview_source,'',array('id'=>'preview_src'));?>
            <img id="change_arrow" src="/images/Forward_Arrow1.png" />
            <img src='' id="result" />
        </div>
        <div class="pic_button">
            <span id="addAva" class="btn btn-success"><?php echo Yii::t('app','Изменить фото'); ?></span>
            <span id="resetcrop" class="btn btn-danger"><?php echo Yii::t('app','Отмена'); ?></span>
        </div>
    </div>
    <?php echo $form->hiddenField($model,'preview_source',array()); ?>
</div>

    
    <div class="<?php echo $row_class;?>">
        <?php echo $form->labelEx($model,'video_src',array('class'=>$label_class)); ?>
        <?php echo $form->textField($model,'video_src',array('size'=>60,'maxlength'=>255,'class'=>$text/*,'disabled'=>'disabled'*/)); ?>
        <?php echo $form->error($model,'video_src'); ?>
    </div>

    <div class="<?php echo $row_class;?>">
<p class="comment"><?php echo Yii::t('app','Оставьте анонс пустым чтобы в превью выводилось название новости.');?></p>
</div>
	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'teaser_en',array('class'=>$label_class)); ?>
        <?php echo $form->textArea($model,'teaser_en',array('rows'=>10,'class'=>$textarea)); ?>
		<?php echo $form->error($model,'teaser_en'); ?>
	</div>

	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'teaser_ru',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'teaser_ru',array('rows'=>10,'class'=>$textarea)); ?>
		<?php echo $form->error($model,'teaser_ru'); ?>
	</div>

	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'teaser_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'teaser_uk',array('rows'=>10,'class'=>$textarea)); ?>
		<?php echo $form->error($model,'teaser_uk'); ?>
	</div>

<div class="news_text">
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'text_en',array('class'=>$label_class)); ?>
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$model,
            'attribute'=>'text_en',
        ));?>
		<?php echo $form->error($model,'text_en'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'text_ru',array('class'=>$label_class)); ?>
		<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
                    'model'=>$model,
                    'attribute'=>'text_ru',
                ));?>
		<?php echo $form->error($model,'text_ru'); ?>
	</div>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'text_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'text_uk', array('class'=>$textarea));?>
		<?php echo $form->error($model,'text_uk'); ?>
	</div>
</div>

<?php if(Yii::app()->getModule('user')->isAdmin()):?>
<div class="<?php echo $checkbox;?>">
    <p><?php echo $form->labelEx($model,'fb_pub',array('class'=>$label_class)); ?></p>
	<div class="<?php echo $check;?> <?php echo ($model->fb_pub == 1 ? 'active' : '');?>">
		<?php echo $form->checkBox($model,'fb_pub'); ?>
		<?php echo $form->error($model,'fb_pub'); ?>
	</div>
    
    <p><?php echo $form->labelEx($model,'tw_pub',array('class'=>$label_class)); ?></p>
	<div class="<?php echo $check;?> <?php echo ($model->tw_pub == 1 ? 'active' : '');?>">
		<?php echo $form->checkBox($model,'tw_pub'); ?>
		<?php echo $form->error($model,'tw_pub'); ?>
	</div>
    
    <p><?php echo $form->labelEx($model,'vk_pub',array('class'=>$label_class)); ?></p>
	<div class="<?php echo $check;?> <?php echo ($model->vk_pub == 1 ? 'active' : '');?>">
		<?php echo $form->checkBox($model,'vk_pub'); ?>
		<?php echo $form->error($model,'vk_pub'); ?>
	</div>
    
    <p><?php echo $form->labelEx($model,'gp_pub',array('class'=>$label_class)); ?></p>
	<div class="<?php echo $check;?> <?php echo ($model->gp_pub == 1 ? 'active' : '');?>">
		<?php echo $form->checkBox($model,'gp_pub'); ?>
		<?php echo $form->error($model,'gp_pub'); ?>
	</div>
    
    <p><?php echo $form->labelEx($model,'hot',array('class'=>$label_class)); ?></p>
	<div class="<?php echo $check;?> <?php echo ($model->hot == 1 ? 'active' : '');?>">
		<?php echo $form->checkBox($model,'hot'); ?>
		<?php echo $form->error($model,'hot'); ?>
	</div>
</div>
<?php endif; ?>

	<div class="<?php echo $button_block; ?>">
		<?php print (CHtml::submitButton($model->isNewRecord ? Yii::t('app','Создать') : Yii::t('app','Сохранить'),array('class'=>$button_class))); ?>
	</div>

<?php $this->endWidget(); ?>