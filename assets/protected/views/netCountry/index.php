<?php
/* @var $this NetCountryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Net Countries',
);

$this->menu=array(
	array('label'=>'Create NetCountry', 'url'=>array('create')),
	array('label'=>'Manage NetCountry', 'url'=>array('admin')),
);
?>

<h1>Net Countries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
