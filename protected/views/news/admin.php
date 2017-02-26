<?php
/* @var $this NewsController */
/* @var $model News */

$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Create News', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$title_ar = Bloger::getStatusTitle();
?>

<h1><?php echo $title_ar[$status]?></h1>

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
            <h2>Manage News</h2>
        </div>                
            <div class="block-fluid">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'',
    //'htmlOptions'=>array('class'=>'dataTables_wrapper'),
    'itemsCssClass'=>'fpTable dataTable',
	'dataProvider'=>$model->search($status),
	'filter'=>$model,
    'enableSorting'=>true,
    'template'=>'{items}{pager}',
    'pagerCssClass'=>'pagin',
    'ajaxUpdate'=>true,
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        'previousPageCssClass'=>'paginate_button previous',
        'nextPageCssClass'=>'paginate_button next',
        'lastPageCssClass'=>'paginate_button last',
        'firstPageCssClass'=>'paginate_button first',
        'selectedPageCssClass'=>'paginate_active',
        'internalPageCssClass'=>'paginate_button',
    ),
	'columns'=>array(
		array(
            'name'=>'id',
            'htmlOptions'=>array("width"=>"30px"),
        ),
		//'name_en',
		//'name_ru',
        array(
            'name'=>'name_ru',
            'value'=>'$data->getName()',
            'htmlOptions'=>array("width"=>"120px"),
        ),
		//'name_uk',
		array(
            'name'=>'author_id',
            'value'=>'$data->author->username',
            'htmlOptions'=>array("width"=>"60px"),
        ),
		array(
            'name'=>'category_id',
            'value'=>'$data->category->name',
        ),
        array(
            'name'=>'type_id',
            'value'=>'$data->getType()',
            'htmlOptions'=>array("width"=>"50px"),
        ),
		'source',
        /*array(
            'header'=>'name_en',
            'labelExpression'=>'$data->name_en',
            'urlExpression'=>'array("update","id"=>$data->id)',
            'class'=>'CLinkColumn'
        ),*/
        /*array(
            'name'=>'media_source',
            'type'=>'html',
            'value'=>'$data->imageThumb(50)',
            'htmlOptions'=>array("width"=>"50px"),
        ),*/
        'video_src',
        array(
            'name'=>'preview_source',
            'type'=>'html',
            'value'=>'$data->preview(50)',
        ),
        array(
            'name'=>'hot',
            'type'=>'raw',
            'value'=>'$data->isHot()',
            //'value'=>'CHtml::checkBox("hot",$data->hot)',
            'htmlOptions'=>array("width"=>"70px"),
        ),
        'views_count',
        'bookmarks_count',
        'downloads_count',
        'shares_gp_count',
        'shares_vk_count',
        'shares_tw_count',
        'shares_fb_count',
        /*
		'create_time',
		'update_time',
		*/
		array(
            'class'=>'CButtonColumn',
            'buttons'=>array(
            ),
		),
	),
));
?>
<div id="id_view"></div>
        </div>
    </div>
</div>