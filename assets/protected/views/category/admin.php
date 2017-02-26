<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Categories</h1>

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
            <h2>Manage Categories</h2>                       
        </div>                
            <div class="block-fluid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
    'itemsCssClass'=>'fpTable dataTable',
    'template'=>'{items}',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'id',
            'htmlOptions'=>array("width"=>"30px"),
        ),
		//'name_en',
		'name_ru',
		//'name_uk',
        array(
            'name'=>'media_source',
            'type'=>'html',
            'value'=>'$data->previewThumb(50)',
        ),
        'news_count',
        'views_count',
        'bookmarks_count',
        'downloads_count',
        'shares_gp_count',
        'shares_vk_count',
        'shares_tw_count',
        'shares_fb_count',
        'shares_total_count',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
        </div>
    </div>
</div>