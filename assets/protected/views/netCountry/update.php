<?php
/* @var $this NetCountryController */
/* @var $model NetCountry */

$this->breadcrumbs=array(
	'Net Countries'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List NetCountry', 'url'=>array('index')),
	array('label'=>'Create NetCountry', 'url'=>array('create')),
	array('label'=>'View NetCountry', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NetCountry', 'url'=>array('admin')),
);
?>

<h1>Update NetCountry <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>