<?php
/* @var $this BlogerController */
/* @var $model Bloger */

$this->breadcrumbs=array(
	'Blogers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Bloger', 'url'=>array('index')),
	array('label'=>'Create Bloger', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bloger-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$title_ar = Bloger::getStatusTitle();
?>

<h1><?php echo $title_ar[$status]?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

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
            <h2>Управление блоггерами</h2>                       
        </div>                
            <div class="block-fluid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bloger-grid',
	'dataProvider'=>$model->search($status),
    'itemsCssClass'=>'fpTable dataTable',
    'template'=>'{items}',
	//'filter'=>$model,
	'columns'=>array(
		array(
            'header'=>'Пользователь',
            'value'=>'$data->user->username',
        ),
		'pen_name_en',
		'pen_name_ru',
		'pen_name_uk',
		'phone',
        'news_count',
        'bookmarks_count',
        'downloads_count',
        'shares_gp_count',
        'shares_vk_count',
        'shares_tw_count',
        'shares_fb_count',
        'shares_total_count',
		/*
		'description_en',
		'description_ru',
		'description_ua',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
        </div>
    </div>
</div>