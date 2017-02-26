<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);
/*
$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);*/
$feed = Content::model()->find('name="feed"');
?>
<div class="mytape">
	<div class="mytape_inner">
		<p class="title"><?php echo $feed->getTitle(); ?></p>
		<div class="dop_text"><?php echo $feed->getText(); ?></div>

		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$catDataProvider,
			'itemView'=>'_view',
		    'viewData' => array( 'cur_name' => $cur_name ),
		    'template'=>'{items}',
		    'htmlOptions'=>array('class'=>'mytape_windows add_ok'),
		)); ?>
		<div class="btn-close"></div>
		<div class="buttom_recommendations">
		    <input type="submit" value="OK" <?php if (!(Yii::app()->user->id)) echo 'onclick="regAfterCat()"'; ?> class="btn-ok"/>
		</div>
	</div>
</div>