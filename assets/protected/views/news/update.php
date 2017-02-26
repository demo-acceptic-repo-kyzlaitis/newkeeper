<?php
/* @var $this NewsController */
/* @var $model News */
/*
$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Create News', 'url'=>array('create')),
	array('label'=>'View News', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage News', 'url'=>array('admin')),
);*/
?>
<section id="main_section" class="">
<?php if(!$blog): ?>
<div class="widget">
<div class="head">
    <?php if(strpos($this->layout,'admin')):?>
    <div class="icon"><i class="icos-pencil2"></i></div>
    <?php endif;?>
    <h2>Редактировать новость '<?php echo $model->name_ru; ?>'</h2>
</div>
    <div class="block-fluid">

<?php echo $this->renderPartial('_form', array('model'=>$model,'blog'=>$blog,)); ?>
<?php else: ?>
    <h2>Редактировать новость '<?php echo $model->name_ru; ?>'</h2>
<?php echo $this->renderPartial('_form_blog', array('model'=>$model,'blog'=>$blog)); ?>
<?php endif; ?>
<div style="clear: both;"></div>
<?php if(!$blog): ?>
    </div>
    </div>
<?php endif; ?>
</section>