<?php
$cs=Yii::app()->clientScript;
$baseUrl=$this->module->assetsUrl;
$cs->registerCssFile($baseUrl.'base.css');
//if($this->module->id == 'rights')
//{
    $baseAssetsUrl = '/css/yiiadmin/css/';
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'structures.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'base.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'components.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'forms.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'grappelli-skin-basic.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'grappelli-skin-default.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'jquery-ui-grappelli-extensions.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'tables.css');
    //$cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'tools.css');
    $cs->registerCssFile(Yii::app()->baseUrl.$baseAssetsUrl.'typography.css');
//}
$cs->registerCssFile(Yii::app()->baseUrl.'/css/yiiadmin.css');
//$cs->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap/bootstrap.min.css');
$cs->registerCssFile(Yii::app()->baseUrl.'/css/jquery.Jcrop.min.css');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/jquery/jquery-ui.min.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/jquery/jquery-ui-timepicker.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/jcrop/jquery.Jcrop.min.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/fileupload/jquery.fileupload.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/funcs.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/admincrop.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.magnific-popup.min.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/scripts-admin.js');
//$cs->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.ui.widget.js');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="" xml:lang="" > 
<head> 
    <title>Yii Administration</title> 
    <meta name="robots" content="NONE,NOARCHIVE" /> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->request->baseUrl;?>/css/instagramAdminStyles.css"/>
</head> 
<body class="dashboard"> 
    <div id="container"> 

<div id="header"> 
    <div class="branding">&nbsp;</div> 
    <div class="admin-title"><a href="/">News Keeper</a></div>
    
    <?php if(Yii::app()->getModule('user')->isWithHighPermissions()):?>
        <ul id="admin_head_menu">
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=NewsAdmin'); ?>" class="user-options-handler collapse-handler newsadmin"><?php echo YiiadminModule::t('Новости'); ?></a>
                <ul class="submenu">
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=NewsAdmin&status=1'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('
Опубликованные новости'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=NewsAdmin&status=0'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t(' Неопубликованные новости'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=NewsAdmin&status=2'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t(' Новости, ожидающие подтверждения'); ?></a></li>
                </ul>
            </li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=BlogerAdmin'); ?>" class="user-options-handler collapse-handler blogeradmin"><?php echo YiiadminModule::t('Блоггеры'); ?></a>
                <ul class="submenu">
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=BlogerAdmin&status=1'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Активные блоггеры'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=BlogerAdmin&status=0'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Неактивные блоггеры'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=BlogerAdmin&status=2'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Неподтвержденные блоггеры'); ?></a></li>
                </ul>
            </li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=UserAdmin'); ?>" class="user-options-handler collapse-handler useradmin"><?php echo YiiadminModule::t('Пользователи'); ?></a></li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=CategoryAdmin'); ?>" class="user-options-handler collapse-handler categoryadmin"><?php echo YiiadminModule::t('Категории'); ?></a></li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=CityAdmin'); ?>" class="user-options-handler collapse-handler cityadmin"><?php echo YiiadminModule::t('Города'); ?></a></li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=WidgetCurrencyElementAdmin'); ?>" class="user-options-handler collapse-handler widgetcurrencyelementadmin"><?php echo YiiadminModule::t('Валюта'); ?></a></li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=ContentAdmin'); ?>" class="user-options-handler collapse-handler contentadmin"><?php echo YiiadminModule::t('Текстовые области'); ?></a></li>
            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/instagram'); ?>" class="user-options-handler collapse-handler settingadmin"><?php echo YiiadminModule::t('Instagram'); ?></a></li>
            <?php if(Yii::app()->getModule('user')->isAdmin()):?>

            <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/list?model_name=SettingAdmin'); ?>" class="user-options-handler collapse-handler settingadmin"><?php echo YiiadminModule::t('Параметры'); ?></a></li>
            <li><a href="<?php echo $this->createUrl('/rights'); ?>" class="user-options-handler collapse-handler rightsadmin"><?php echo YiiadminModule::t('Права'); ?></a>
                <ul class="submenu">
                    <li><a href="<?php echo $this->createUrl('/yiiadmin/manageModel/update?model_name=SettingAdmin&pk=1'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('IP адреса'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/rights/assignment/view'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Присвоение ролей'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/rights/authItem/permissions'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Права доступа'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/rights/authItem/roles'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Роли'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/rights/authItem/tasks'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Задачи'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/rights/authItem/operations'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Операции'); ?></a></li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
        <script>
        $('#admin_head_menu > li').hover(function(){
            $(this).find('.submenu').show()
        },
        function(){
            $(this).find('.submenu').hide()
        })
        </script>
        <ul id="user-tools"> 
            <!--<li><a href="#" class="user-options-handler collapse-handler">username</a></li>-->
            <li><a href="<?php echo $this->createUrl('/yiiadmin/default/logout'); ?>" class="user-options-handler collapse-handler"><?php echo YiiadminModule::t('Выход'); ?></a></li>
        </ul> 
</div> 

    <?php 
        $message=Yii::app()->user->getFlash('flashMessage');
        if ($message): 
    ?> 
    <ul class="messagelist">
        <li><?php echo $message; ?></li>
    </ul>
    <?php endif; ?>

    <!-- BREADCRUMBS -->
    <div id="breadcrumbs">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'homeLink'=>CHtml::link(YiiadminModule::t('Главная'),'/yiiadmin'),
        'links'=>$this->breadcrumbs
        )
    ); 
    ?>
    </div>
        
    <!-- CONTENT --> 
    <div id="content" class="content-flexible"> 
             
 
        <?php
            echo $content;
        ?>
        <br class="clear" /> 
        </div>     
        <!-- FOOTER --> 
        <div id="footer"></div> 
        
    </div>
    <style>
    .bar {
        height: 18px;
        background: green;
    }
    </style>
    <div id="progress">
        <div class="bar" style="width: 0%;"></div>
    </div>
    <?php 
    $model_name = '';
    
    if(isset($_GET['model_name']))
        $model_name = strtolower($_GET['model_name']);
    else 
        $model_name = 'rightsadmin';
    ?>
    <script>
    $('.<?php echo $model_name; ?>').addClass('active');
    </script>
</body> 
</html> 
 
