<?php
/* @var $this WidgetcurrencyclementController */
/* @var $model WidgetCurrencyElement */

$this->breadcrumbs=array(
	'Widget Currency Elements'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List WidgetCurrencyElement', 'url'=>array('index')),
	array('label'=>'Create WidgetCurrencyElement', 'url'=>array('create')),
	array('label'=>'Update WidgetCurrencyElement', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WidgetCurrencyElement', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WidgetCurrencyElement', 'url'=>array('admin')),
);
?>

<h1>View WidgetCurrencyElement #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'buy',
		'sale',
	),
)); ?>
