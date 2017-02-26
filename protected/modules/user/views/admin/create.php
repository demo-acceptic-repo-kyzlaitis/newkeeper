<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Create'),
);

$this->menu=array(
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);
?>
<section id="main_section" class="">
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
            <h2>Создание пользователя</h2>                       
        </div>                
            <div class="block-fluid">
<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile,'update'=>false));
?>
</div>
</div>
</div>
</section>