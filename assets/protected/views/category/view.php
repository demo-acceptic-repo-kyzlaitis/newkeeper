<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Add To My Themes', 'url'=>array('category/subscribe', 'id'=>$model->id)),
	array('label'=>'Remove From My Themes', 'url'=>array('unsubscribe', 'id'=>$model->id)),
	array('label'=>'Create News', 'url'=>array('news/create', 'cid'=>$model->id)),
	array('label'=>'Update Category', 'url'=>array('update', 'cid'=>$model->id)),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>View Category #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name_en',
		'name_ru',
		'name_ru',
                'media_source',
	),
)); ?>
