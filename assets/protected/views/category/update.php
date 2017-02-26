<?php
/* @var $this CategoryController */
/* @var $model Category */


$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'View Category', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>
<section id="main_section" class="">
<div class="widget">
<div class="head dark">
    <?php if(strpos($this->layout,'admin')):?>
    <div class="icon"><i class="icos-pencil2"></i></div>
    <?php endif;?>
    <h2>Редактировать категорию '<?php echo $model->name_ru; ?>'</h2>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<div style="clear: both;"></div>
</div>
</section>