<?php
/* @var $this ContentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Content',
);

$this->menu=array(
	array('label'=>'Create Content', 'url'=>array('create')),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>

<h1>Content</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
