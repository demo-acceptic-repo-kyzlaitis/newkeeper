<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);
$choose_all = Yii::t('app','Выбрать все');
/*
$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);*/
?>

<section id="setting_section">

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$catDataProvider,
    'itemView'=>'_view2',
    'template'=>'{summary}
    <div class="check_all">
        <div class="all_theme check">
            <input type="checkbox" checked="" value="">
        </div>
    <span class="all_theme">'.$choose_all.'</span>
    </div>
    {items}',
    //<div class="buttom_selected"><input type="submit" value="Выбрать все" id="theme_all" /></div>',
    'summaryText'=>"<p>".$summary_t->getText()."</p>",
    'htmlOptions'=>array('class'=>'select_themes'),
)); ?>

<?php if(isset($blogerDataProvider)): ?>

<?php   $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$blogerDataProvider,
    'htmlOptions'=>array('class'=>'select_bloggers'),
    'itemView'=>'/bloger/_view2',
    'template'=>'{summary}
    <div class="check_all">
        <div class="all_blog check">
            <input type="checkbox" checked="" value="">
        </div>
    <span class="all_blog">'.$choose_all.'</span>
    </div>
    {items}',
//    <div class="buttom_selected"><input type="submit" value="Выбрать все" id="blogger_all" /></div>',
    'summaryText'=>'<p>'.$summary_b->getText().'</p>',
)); ?>
<?php endif;?>
<div class="clear"></div>
</section>