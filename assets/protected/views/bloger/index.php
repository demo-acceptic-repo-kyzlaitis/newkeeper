<?php
/* @var $this BlogerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blogers',
);
/*
$this->menu=array(
	array('label'=>'Create Bloger', 'url'=>array('create')),
	array('label'=>'Manage Bloger', 'url'=>array('admin')),
);*/
?>
<section id="blog_tabscontainer" class="">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'tagName'=>'div',
        'itemsTagName'=>'ul',
        'template'=>'{items}',
        'htmlOptions'=>array('class'=>'different_blogers'),
        'itemsCssClass'=>'blogger_blocks',
        'id'=>'',
        //'ajaxUpdate'=>false,
        //'viewData' => array( 'cur_pname' => $cur_pname, 'cur_description' => $cur_description ),
)); ?>
    <!--div class="curvedContainer">
        <div id="tab_content_1" class="description_blogger tabcontent" style="display: block;"></div>
    </div>
    <div class="spacer"></div-->
</section>
<script>
	$('#<?php echo $id ?>').addClass('selected');
</script>