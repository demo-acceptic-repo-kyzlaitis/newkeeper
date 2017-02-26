<section id="main_section">
<div id="crop_target">
<?php if(isset($user)) echo $user->getAvatar(200); ?>
<?php if(isset($news) && $type == 'preview') echo $news->previewThumb(200); ?>
<?php if(isset($news) && $type == 'image') echo $news->imageThumb(200); ?>
</div>
<div class="button">
<ul class="photos">
<li>
<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>
</li>
<li>
<?php echo CHtml::activeFileField($model, 'image'); ?>
</li>
<li>
<a href="#" class="doing_photo"><?=CHtml::submitButton('OK',array('enctype'=>'multipart/form-data','style'=>'width: 100px !important; border-radius: 3px; background-color: #424242;'))?></a>
</li>
</ul>
</div>

<?php echo CHtml::endForm(); ?>
</section>