<?php
/* @var $this BlogerController */
/* @var $model Bloger */

$this->breadcrumbs=array(
	'Blogers'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'Blogers News', 'url'=>array('news/blog', 'id'=>$model->user_id)),
	array('label'=>'Subscribe', 'url'=>array('bloger/subscribe', 'id'=>$model->user_id)),
	array('label'=>'Unsubscribe', 'url'=>array('bloger/unsubscribe', 'id'=>$model->user_id)),
	array('label'=>'List Bloger', 'url'=>array('index')),
	array('label'=>'Create Bloger', 'url'=>array('create')),
	array('label'=>'Update Bloger', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete Bloger', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bloger', 'url'=>array('admin')),
);
?>

<h1>View Bloger #<?php echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'pen_name_en',
		'pen_name_ru',
		'pen_name_uk',
		'phone',
		'description_en',
		'description_ru',
		'description_uk',
	),
)); ?>
