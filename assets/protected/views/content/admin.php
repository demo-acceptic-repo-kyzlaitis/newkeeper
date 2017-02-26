<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs=array(
	'Content'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Content', 'url'=>array('index')),
	array('label'=>'Create Content', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#content-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cities</h1>


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
            <h2>Управление полями профиля</h2>                       
        </div>                
            <div class="block-fluid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'content-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'itemsCssClass'=>'fpTable dataTable',
	'columns'=>array(
		'id',
		'name',
		'title_en',
		'title_ru',
		'title_uk',
		'text_en',
		'text_ru',
		'text_uk',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>
