<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
$this->menu=array(
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
);
?>
<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Создание полей профиля</h2>                       
        </div>                
            <div class="block-fluid">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>
</div>