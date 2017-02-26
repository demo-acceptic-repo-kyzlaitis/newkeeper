<?php
/* @var $this BlogerController */
/* @var $model Bloger */

$this->breadcrumbs=array(
	'Blogers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bloger', 'url'=>array('index')),
	array('label'=>'Manage Bloger', 'url'=>array('admin')),
);
?>
<section id="main_section" class="">
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Создание блоггера</h2>                       
        </div>                
            <div class="block-fluid">
<?php echo $this->renderPartial('_form', array('model'=>$model, 'users'=>$users)); ?>
</div>
</div>
</div>
</section>