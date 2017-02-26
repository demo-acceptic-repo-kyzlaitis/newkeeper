<?php
/* @var $this WidgetcurrencyclementController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Widget Currency Elements',
);

$this->menu=array(
	array('label'=>'Create WidgetCurrencyElement', 'url'=>array('create')),
	array('label'=>'Manage WidgetCurrencyElement', 'url'=>array('admin')),
);
?>

<h1>Widget Currency Elements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
