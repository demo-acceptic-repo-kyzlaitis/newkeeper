<?php
/* @var $this BlogerController */
/* @var $model Bloger */

$this->breadcrumbs=array(
	'Blogers'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bloger', 'url'=>array('index')),
	array('label'=>'Create Bloger', 'url'=>array('create')),
	array('label'=>'View Bloger', 'url'=>array('view', 'id'=>$model->user_id)),
	array('label'=>'Manage Bloger', 'url'=>array('admin')),
);
?>
<section id="main_section" class="">
<div class="widget">
<div class="head dark">
    <?php if(strpos($this->layout,'admin')):?>
    <div class="icon"><i class="icos-pencil2"></i></div>
    <?php endif;?>
    <h2>Редактировать блоггера <?php echo $model->pen_name_ru; ?> (<?php echo CHtml::link($model->user->getFullName(),"/user/admin/update/".$model->user_id); ?>)</h2>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model,'users'=>$users,'update'=>true)); ?>
<div style="clear: both;"></div>
</div>
</section>