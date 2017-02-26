<!DOCTYPE html>
<html lang="en">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="robots" content="noindex">
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->        
    
    <title>Users List - Virgo Premium Admin Template</title>
    
    <link href="/css/virgo/stylesheets.css" rel="stylesheet" type="text/css" />      
    <!--[if lt IE 10]>
        <link href="css/ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->        
    <link rel="icon" type="image/ico" href="favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/colorbox/example2/colorbox.css" />
    
    <script type='text/javascript' src='/js/plugins/jquery/jquery-1.8.3.min.js'></script>
    <script type='text/javascript' src='/js/plugins/jquery/jquery-ui-1.9.1.custom.min.js'></script>
    <script type='text/javascript' src='/js/plugins/jquery/globalize.js'></script>
    <script type='text/javascript' src='/js/plugins/other/excanvas.js'></script>
    
    <script type='text/javascript' src='/js/plugins/other/jquery.mousewheel.min.js'></script>
        
    <script type='text/javascript' src='/js/plugins/bootstrap/bootstrap.min.js'></script>            
    
    <script type='text/javascript' src='/js/plugins/cookies/jquery.cookies.2.2.0.min.js'></script>
    
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    
    <script type='text/javascript' src='/js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    
    <script type='text/javascript' src='/js/plugins/jflot/jquery.flot.js'></script>    
    <script type='text/javascript' src='/js/plugins/jflot/jquery.flot.stack.js'></script>    
    <script type='text/javascript' src='/js/plugins/jflot/jquery.flot.pie.js'></script>
    <script type='text/javascript' src='/js/plugins/jflot/jquery.flot.resize.js'></script>
    
    <script type='text/javascript' src='/js/plugins/epiechart/jquery.easy-pie-chart.js'></script>
    <script type='text/javascript' src='/js/plugins/knob/jquery.knob.js'></script>
        
    <script type='text/javascript' src='/js/plugins/sparklines/jquery.sparkline.min.js'></script>    
    
    <script type='text/javascript' src='/js/plugins/pnotify/jquery.pnotify.min.js'></script>
    
    <script type='text/javascript' src='/js/plugins/fullcalendar/fullcalendar.min.js'></script>        
    
    <script type='text/javascript' src='/js/plugins/datatables/jquery.dataTables.min.js'></script>    
    
    <script type='text/javascript' src='/js/plugins/wookmark/jquery.wookmark.js'></script>        
    
    <script type='text/javascript' src='/js/plugins/jbreadcrumb/jquery.jBreadCrumb.1.1.js'></script>
    
    <script type='text/javascript' src='/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    
    <script type='text/javascript' src="/js/plugins/uniform/jquery.uniform.min.js"></script>
    <script type='text/javascript' src="/js/plugins/select/select2.min.js"></script>
    <script type='text/javascript' src='/js/plugins/tagsinput/jquery.tagsinput.min.js'></script>
    <script type='text/javascript' src='/js/plugins/maskedinput/jquery.maskedinput-1.3.min.js'></script>
    <script type='text/javascript' src='/js/plugins/multiselect/jquery.multi-select.min.js'></script>    
    
    <script type='text/javascript' src='/js/plugins/validationEngine/languages/jquery.validationEngine-en.js'></script>
    <script type='text/javascript' src='/js/plugins/validationEngine/jquery.validationEngine.js'></script>        
    <script type='text/javascript' src='/js/plugins/stepywizard/jquery.stepy.js'></script>

    <script type='text/javascript' src='/js/plugins/animatedprogressbar/animated_progressbar.js'></script>
    <script type='text/javascript' src='/js/plugins/hoverintent/jquery.hoverIntent.minified.js'></script>
    
    <script type='text/javascript' src='/js/plugins/media/mediaelement-and-player.min.js'></script>    
    
    <script type='text/javascript' src='/js/plugins/cleditor/jquery.cleditor.js'></script>
    
    <script type='text/javascript' src='/js/plugins/shbrush/XRegExp.js'></script>
    <script type='text/javascript' src='/js/plugins/shbrush/shCore.js'></script>
    <script type='text/javascript' src='/js/plugins/shbrush/shBrushXml.js'></script>
    <script type='text/javascript' src='/js/plugins/shbrush/shBrushJScript.js'></script>
    <script type='text/javascript' src='/js/plugins/shbrush/shBrushCss.js'></script>    
    
    <script type='text/javascript' src='/js/plugins/filetree/jqueryFileTree.js'></script>        
        
    <script type='text/javascript' src='/js/plugins/slidernav/slidernav-min.js'></script>    
    <script type='text/javascript' src='/js/plugins/isotope/jquery.isotope.min.js'></script>    
    <script type='text/javascript' src='/js/plugins/jnotes/jquery-notes_1.0.8_min.js'></script>
    <script type='text/javascript' src='/js/plugins/jcrop/jquery.Jcrop.min.js'></script>
    <script type='text/javascript' src='/js/plugins/ibutton/jquery.ibutton.min.js'></script>
        
    <script type='text/javascript' src='/js/plugins.js'></script>
    <script type='text/javascript' src='/js/charts.js'></script>
    <script type='text/javascript' src='/js/actions.js'></script>
    
    <script src="/js/vendor/jquery.ui.widget.js"></script>
    <script src="/js/jquery.iframe-transport.js"></script>
    <script src="/js/jquery.fileupload.js"></script>
    <script src="/js/admin_scripts.js"></script>
    <!-- added -->
    <script>
    
    </script>
    <?php
        $baseUrl = Yii::app()->baseUrl;
		$js_arr = array('scripts',
						'small_scripts',
						'jquery.tinycarousel',
						'respond',
						'checkBox',
						'flexmenu.min',
						'jquery.nicescroll.min',
						'litebox',
						'tabMenu',
						'tabs',
						'download',
						'bookmark',
						'share',
		);
        $cs = Yii::app()->getClientScript();
		foreach($js_arr as $js){
			$cs->registerScriptFile($baseUrl.'/js/'.$js.'.js');
		}
        ?>
    
</head>
<body>
    
    <div class="header">
        <a href="/" class="logo"><?php echo CHtml::image("/images/logo.png"); ?></a>
        
        <!--<div class="buttons">
            <div class="popup" id="subNavControll">
                <div class="label"><span class="icos-list"></span></div>
            </div>
            <div class="dropdown">
                <div class="label"><span class="icos-user2"></span></div>
                <div class="body" style="width: 160px;">
                    <div class="itemLink">
                        <a href="#"><span class="icon-cog icon-white"></span> Settings</a>
                    </div>
                    <div class="itemLink">
                        <a href="#"><span class="icon-comment icon-white"></span> Messages</a>
                    </div>                    
                    <div class="itemLink">
                        <a href="#"><span class="icon-off icon-white"></span> Logoff</a>
                    </div>                                        
                </div>                
            </div>            
            <div class="popup">
                <div class="label"><span class="icos-search1"></span></div>
                <div class="body">
                    <div class="arrow"></div>
                    <div class="row-fluid">
                        <div class="row-form">
                            <div class="span12">                    
                                <div class="input-append input-prepend">
                                    <span class="add-on"><i class="icon-search"></i></span>                                    
                                    <input type="text" name="search" placeholder="Keyword..."/>
                                    <button class="btn" type="button">Search</button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup">
                <div class="label"><span class="icos-cog"></span></div>
                <div class="body">
                    <div class="arrow"></div>
                    <div class="row-fluid">
                        <div class="row-form">
                            <div class="span12">
                                <span class="top">Themes:</span>
                                <div class="themes">
                                    <a href="#" data-theme="" class="tip" title="Default"><img src="img/themes/default.jpg"/></a>                                    
                                    <a href="#" data-theme="ssDaB" class="tip" title="DaB"><img src="img/themes/dab.jpg"/></a>
                                    <a href="#" data-theme="ssTq" class="tip" title="Tq"><img src="img/themes/tq.jpg"/></a>
                                    <a href="#" data-theme="ssGy" class="tip" title="Gy"><img src="img/themes/gy.jpg"/></a>
                                    <a href="#" data-theme="ssLight" class="tip" title="Light"><img src="img/themes/light.jpg"/></a>
                                    <a href="#" data-theme="ssDark" class="tip" title="Dark"><img src="img/themes/dark.jpg"/></a>
                                    <a href="#" data-theme="ssGreen" class="tip" title="Green"><img src="img/themes/green.jpg"/></a>
                                    <a href="#" data-theme="ssRed" class="tip" title="Red"><img src="img/themes/red.jpg"/></a>
                                </div>
                            </div>
                        </div>
                        <div class="row-form">
                            <div class="span12">
                                <span class="top">Backgrounds:</span>
                                <div class="backgrounds">
                                    <a href="#" data-background="bg_default" class="bg_default"></a>
                                    <a href="#" data-background="bg_mgrid" class="bg_mgrid"></a>
                                    <a href="#" data-background="bg_crosshatch" class="bg_crosshatch"></a>
                                    <a href="#" data-background="bg_hatch" class="bg_hatch"></a>                                    
                                    <a href="#" data-background="bg_light_gray" class="bg_light_gray"></a>
                                    <a href="#" data-background="bg_dark_gray" class="bg_dark_gray"></a>
                                    <a href="#" data-background="bg_texture" class="bg_texture"></a>
                                    <a href="#" data-background="bg_light_orange" class="bg_light_orange"></a>
                                    <a href="#" data-background="bg_yellow_hatch" class="bg_yellow_hatch"></a>                        
                                    <a href="#" data-background="bg_green_hatch" class="bg_green_hatch"></a>                        
                                </div>
                            </div>          
                        </div>
                        <div class="row-form">
                            <div class="span12">
                                <span class="top">Navigation:</span>
                                <input type="radio" name="navigation" id="fixedNav"/> Fixed 
                                <input type="radio" name="navigation" id="collapsedNav"/> Collapsible
                                <input type="radio" name="navigation" id="hiddenNav"/> Hidden
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
            
        </div>-->
        
    </div>
    <!--<div class="navigation">

        <ul class="main">
            <li><a href="/"><span class="icom-screen"></span><span class="text">Главная</span></a></li>
            <li><a href="/bloger/admin" class="bloger"><span class="icom-screen"></span><span class="text">Блогеры</span></a></li>
            <li><a href="#samples" class="rights"><span class="icom-box-add"></span><span class="text">Права</span></a></li>
            <li><a href="#other" class="user"><span class="icom-star1"></span><span class="text">Пользователи</span></a></li>            
        </ul>
        
        <div class="control"></div>
        
        <div class="submain">


            <div id="samples">
                <div class="menu">
                    <a href="/rights/assignment"> </span> Assignment</a>
                    <a href="/rights/authItem/permissions"><span class="icon-refresh"></span> Permissions</a>
                    <a href="/rights/authItem/roles"><span class="icon-envelope"></span> Roles</a>
                    <a href="/rights/authItem/tasks"><span class="icon-list-alt"></span> Tasks</a>
                    <a href="/rights/authItem/operations"><span class="icon-picture"></span> Operations</a>
                </div>
            </div>

            <div id="other">
                <div class="menu">
                    <a href="/user/admin"><span class="icon-warning-sign"></span> Пользователи</a>
                    <a href="/user/profileField/admin"><span class="icon-off"></span> Поля профиля</a>
                </div>
            </div>

        </div>

    </div>-->
    <div class="navigation">

        <ul class="main">
            <li><a href="/"><span class="icom-screen"></span><span class="text">Main</span></a></li>
            <li><a href="#news"><span class="icom-newspaper"></span><span class="text">Новости</span></a></li>
            <li><a href="#category"><span class="icom-box-add"></span><span class="text">Категории</span></a></li>
            <li><a href="#bloger"><span class="icom-videos"></span><span class="text">Блогеры</span></a></li>
            <li><a href="#rights" class="active"><span class="icom-pencil3"></span><span class="text">Права</span></a></li>
            <li><a href="#user"><span class="icom-bookmark"></span><span class="text">Пользователи</span></a></li>
            <li><a href="#city"><span class="icom-star1"></span><span class="text">Города</span></a></li>
            <li><a href="#widgetcurrencyelement"><span class="icom-star1"></span><span class="text">Валюта</span></a></li>
            <li><a href="#content_item"><span class="icom-star1"></span><span class="text">Контент</span></a></li>
            <li><a href="/user/logout"><span class="icom-off"></span><span class="text">Выход</span></a></li>
        </ul>
        
        
        <div class="control"></div>
        
        <div class="submain">
            
            <div id="news_item">
                <div class="menu">
                    <a href="/news/create">Создать новость</a>
                    <a href="/news/admin">Опубликованные новости</a>
                    <a href="/news/adminblog">Неподтвержденные новости</a>
                    <a href="/news/adminhide">Неактивные новости</a>
                </div>
            </div>
            
            <div id="category_item">
                <div class="menu">
                    <a href="/category/create">Создать категорию</a>
                    <a href="/category/admin">Управление категориями</a>
                </div>
            </div>
            
            <div id="bloger_item">
                <div class="menu">
                    <a href="/bloger/create">Создать блоггера</a>
                    <a href="/bloger/admin">Активные блоггеры</a>
                    <a href="/bloger/adminrequest">Заявки блоггеров</a>
                    <a href="/bloger/adminunactive">Неактивные блоггеры</a>
                </div>
            </div>
                        
            
            <div id="rights_item">
                <div class="menu">
                    <a href="/rights/assignment"> Assignment</a>
                    <a href="/rights/authItem/permissions">Permissions</a>
                    <a href="/rights/authItem/roles">Roles</a>
                    <a href="/rights/authItem/tasks">Tasks</a>
                    <a href="/rights/authItem/operations">Operations</a>
                </div>
            </div>

            <div id="user_item">
                <div class="menu">
                    <a href="/user/admin">Пользователи</a>
                    <a href="/user/admin/create">Создать пользователя</a>
                    <a href="/user/profileField/admin">Поля профиля</a>
                    <a href="/user/profileField/create">Создать поле профиля</a>
                </div>
            </div>

            <div id="city_item">
                <div class="menu">
                    <a href="/city/create">Добавить город</a>
                    <a href="/city/admin">Управление городами</a>
                </div>
            </div>

            <div id="widgetcurrencyelement_item">
                <div class="menu">
                    <a href="/widgetcurrencyelement/create">Добавить валюту</a>
                    <a href="/widgetcurrencyelement/admin">Управление валютами</a>
                </div>
            </div>

            <div id="content_item">
                <div class="menu">
                    <a href="/content/create">Добавить контент</a>
                    <a href="/content/admin">Управление контентом</a>
                </div>
            </div>

        </div>

    </div>
    <!--
    <div class="breadCrumb clearfix">    
        <ul id="breadcrumbs">
            <li><a href="/news/admin">Home</a></li>
            <li><a href="#">Sample pages</a></li>
            <li>Users list</li>
        </ul>
    </div>-->
    
    <div class="content">
        <?php echo $content; ?>
    </div>  
    
    <script src="/js/admincrop.js"></script>
    <script type='text/javascript' src='/js/plugins/colorbox/jquery.colorbox-min.js'></script>
</body>
<script>
$(document).ready(function(){
    $('body .submain .navigation').height(function(){
        return $('.content').height() + 370;
    });
});
</script>
</html>
