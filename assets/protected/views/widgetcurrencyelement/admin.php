<?php
/* @var $this WidgetcurrencyclementController */
/* @var $model WidgetCurrencyElement */

$this->breadcrumbs=array(
	'Widget Currency Elements'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WidgetCurrencyElement', 'url'=>array('index')),
	array('label'=>'Create WidgetCurrencyElement', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#widget-currency-element-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Widget Currency Elements</h1>

<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
<h2><?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?></h2>
        </div>                
            <div class="block-fluid">
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
</div>
</div>
</div>

<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Управление виджетом валюты</h2>                       
        </div>                
            <div class="block-fluid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'widget-currency-element-grid',
	'dataProvider'=>$model->search(),
    'itemsCssClass'=>'fpTable dataTable',
	//'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'buy',
		'sale',
		/*array(
            'name'=>'symbol',
            'type'=>'html',
            'value'=>'<img alt="rurw.png" src="/images/rur.png">',
        ),*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>
