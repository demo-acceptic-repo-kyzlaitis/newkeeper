<?php
/* @var $this NewsController */
/* @var $model News */

$this->breadcrumbs=array(
	'News'=>array('index'),
	'Create',
);
if(strpos($this->layout,'admin'))
{
$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Manage News', 'url'=>array('admin')),
);
}
?>
<section id="main_section" class="">
    <h2 class="create-news"><?php echo Yii::t("app","Создание новости"); ?></h2>
<?php echo $this->renderPartial('_form_blog', array('model'=>$model,'categories'=>$categories,'blog'=>$blog)); ?>
</section>