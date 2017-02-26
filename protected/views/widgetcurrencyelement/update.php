<?php
/* @var $this WidgetcurrencyclementController */
/* @var $model WidgetCurrencyElement */

$this->breadcrumbs=array(
	'Widget Currency Elements'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WidgetCurrencyElement', 'url'=>array('index')),
	array('label'=>'Create WidgetCurrencyElement', 'url'=>array('create')),
	array('label'=>'View WidgetCurrencyElement', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WidgetCurrencyElement', 'url'=>array('admin')),
);
?>
<section id="main_section" class="">
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Редактирование валюты</h2>                       
        </div>                
            <div class="block-fluid">

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>
</div>
</section>