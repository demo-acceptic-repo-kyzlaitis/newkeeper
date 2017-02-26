<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/blogcrop.js');
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
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
<?php if(strpos($this->layout,'admin')): ?>

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'lang',array('class'=>$label_class)); ?>
		<?php echo $form->dropDownList($model,'lang', $model->getLangsAdmin(),array('class'=>$text)); ?>
		<?php echo $form->error($model,'lang'); ?>
	</div>
    
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'source',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'source',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>
    
<?php endif; ?>

<div class="news_text"><!--
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'text_en',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'text_en', array('class'=>$textarea));?>
		<?php echo $form->error($model,'text_en'); ?>
	</div>-->

    <div class="<?php echo $row_class;?>">
        <?php echo $form->labelEx($model,'text_ru',array('class'=>$label_class)); ?>
        <?php echo $form->textArea($model,'text_ru', array('class'=>$textarea));?>
        <?php echo $form->error($model,'text_ru'); ?>
    </div>
    <!--
	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'text_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textArea($model,'text_uk', array('class'=>$textarea));?>
		<?php echo $form->error($model,'text_uk'); ?>
	</div>-->
</div>

<div class="news_title">
	<!--<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'name_en',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>-->

	<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'name_ru',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'name_ru',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'name_ru'); ?>
	</div>

	<!--<div class="<?php echo $row_class;?>">
		<?php echo $form->labelEx($model,'name_uk',array('class'=>$label_class)); ?>
		<?php echo $form->textField($model,'name_uk',array('size'=>60,'maxlength'=>255,'class'=>$text)); ?>
		<?php echo $form->error($model,'name_uk'); ?>
	</div>-->
</div>

<!--    <div class="<?php echo $row_class;?>">
<p class="comment"><?php echo Yii::t('app','Оставьте анонс пустым чтобы в превью выводилось название новости.');?></p>
</div>-->
<!--
	<div class="<?php echo $area_class;?>">
		<?php echo $form->labelEx($model,'teaser_en',array('class'=>$label_class)); ?>
        <?php echo $form->textArea($model,'teaser_en',array('rows'=>10,'class'=>$textarea)); ?>
		<?php echo $form->error($model,'teaser_en'); ?>
	</div>-->

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

<div class="<?php echo $row_class;?>">
    <?php echo $form->labelEx($model,'preview_source',array('class'=>$label_class)); ?>
    <div id="<?php echo $blog?>" class="display_thumb">
        <div class="img_cont">

            <?php
            $urli = $model->preview_source;
            if ($urli) {
                echo '<img src="'.$urli1 = '/uploads/preview/'.$urli.'">';
            }
            ?>
        </div>
        <div class="btn_popup blog_choose_pic">
            <span id="addPic" class=""><?php echo Yii::t('app','Изменить фото'); ?></span>
            <input id="fileupload_blog" type="file" name="loadedFile" data-url="/news/upload" />
            <span id="resetcrop" class=""><?php echo Yii::t('app','Отмена'); ?></span>
        </div>
    </div>
    <div style="clear: both;"></div>
    <?php echo $form->hiddenField($model,'preview_source',array()); ?>
</div>

<div class="sel-n">

	<div class="<?php echo $row_class;?> category_id">
		<?php echo $form->labelEx($model,'categories_id',array('class'=>$label_class)); ?>
		<?php echo $form->checkBoxList($model,'categories_id', CHtml::listData($model->getCategories(), 'id', 'name_'.Yii::app()->language),array(
            'template'=>'<div class="zzzz-2">{label}{input}</div>',
            'container' => 'div',
            'separator' => '',
            'class'=>''
          )); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div style="clear:boch"></div>
</div>


	<div class="<?php echo $button_block; ?>">
		<?php print (CHtml::submitButton($model->isNewRecord ? Yii::t('app','Создать') : Yii::t('app','Сохранить'),array('class'=>$button_class))); ?>
	</div>

<?php $this->endWidget(); ?>
