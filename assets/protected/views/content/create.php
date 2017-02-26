<?php
/* @var $this ContentController */
/* @var $model Content */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Content', 'url'=>array('index')),
	array('label'=>'Manage Content', 'url'=>array('admin')),
);
?>
<section id="main_section" class="">
<h1>Create Content</h1>
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Создание города</h2>                       
        </div>                
            <div class="block-fluid">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>
</div>
</section>