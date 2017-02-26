<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
        
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
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
		);
        $cs = Yii::app()->getClientScript();
		foreach($js_arr as $js){
			$cs->registerScriptFile($baseUrl.'/js/'.$js.'.js');
		}
        ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <?php //unset(Yii::app()->session['cat_choice']);
if(Yii::app()->user->isGuest){
    if(!isset(Yii::app()->session['cat_choice'])){
        Yii::app()->session['cat_choice'] = time();
    }
    if((time() - Yii::app()->session['cat_choice']) < 30){
    ?>
    <script>
    setTimeout(function(){/*
        $.post('/category/index',{"asDialog" : 1},function(html){
            $("#id_category").html(html);
        }).done(function(){
         $(".modal-body").addClass("mytape");
        });
    },3000-<?php print 1000*(time() - Yii::app()->session['cat_choice']); ?>);
    
     $(".bootbox").on("hide", function() { 
        alert("agfas")
     });*/

    </script>
<?php
    }
    if(!isset(Yii::app()->session['register_timeout'])){
        Yii::app()->session['register_timeout'] = time();
    }
    if((time() - Yii::app()->session['register_timeout']) < 30){
    ?>
    <script>
    setTimeout(function(){
        $.post('/user/registration',{"asDialog" : 1},function(html){
            $("#registration").html(html);
        }).done(function(){
         $(".modal-body").addClass("mytape");
        });
    },4000-<?php print 1000*(time() - Yii::app()->session['register_timeout']); ?>);
    </script>
<?php
    }
}else{ ?>
	<script>
	
    </script>
<?php }

	if(isset(Yii::app()->session["lang"])){ ?>
		<script>
		</script>
<?php }else{ ?>
		<script>
		</script>
<?php } //var_dump(Yii::app()->session["lang"]);exit;
?>
<div class="line"></div>

	<header id="main_head">
		<div class="main-wrapper">
                    <a href="/" class="logo"><?php echo CHtml::image("/images/logo.png"); ?></a>
			
			<nav class="main_nav">
                            <?php $lang = Yii::app()->language;
                $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
	        array('label'=>'Мои темы', 'url'=>array('/news/mynews')),
	        array('label'=>'Все темы', 'url'=>array('/news')),
                            ),
		)); 
                $this->widget('application.components.widgets.ActiveMenu');?>
			
			</nav>
                        <!--<nav>
				<ul class="main_nav" id="mainNavbar">
					<li><a class="active" href="#">РњРѕРё С‚РµР�?С‹</a></li>
					<li class="menus_bord"><a  href="#">Р’СЃРµ С‚РµР�?С‹</a></li>
					<li><a href="#">РџРѕР»РёС‚РёРєР°</a></li>
					<li><a href="#">Р­РєРѕРЅРѕР�?РёРєР°</a></li>
					<li><a href="#">РљСѓР»СЊС‚СѓСЂР°</a></li>
					<li><a href="#">РќР°СѓРєР°</a></li>
					<li><a href="#">РЎРїРѕСЂС‚</a></li>
					<li><a href="#">РЁРѕСѓ-Р±РёР·</a></li>
					<li class="menus_bord"><a href="#">Р—РґРѕСЂРѕРІСЊРµ</a></li>
					<li><a href="#">Р’РѕР№РЅР°</a></li>
					<li><a href="#">РњРѕРґР°</a></li>
					<li><a href="#">РљРёРЅРѕ</a></li>
				</ul>
			</nav>-->
		</div>
	</header>
<div id="content">
	<div id="mainmenu">
		<?php $lang = Yii::app()->language;
                $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
	        array('label'=>'Category', 'url'=>array('/category')),
	        array('label'=>'Blogers', 'url'=>array('/bloger')),
	        array('label'=>Yii::t('main-ui','Users'), 'url'=>array('/user'), 'visible'=>!Yii::app()->user->isGuest),
	        array('label'=>'Rights', 'url'=>array('/rights'), 'visible'=>!Yii::app()->user->isGuest),
	        array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->
	
	
 <div id="searchresultdata" class="faq-articles"> </div>
	<?php echo $content; ?>
	<script type="text/javascript">
$(document).ready(function() {
 
$("#faq_search_input").keyup(function()
{

var faq_search_input = $(this).val();
var dataString = 'keyword='+ faq_search_input;
 
var ref_id = $('#ref_id').val(); 
var cust_id = $('#cust_id').val(); 
var current_url = $('.current_url').attr("id"); 
/*This is the minimum size of search string. Search will be only done when at-least 3 characters are provided in input*/
if(faq_search_input.length>3)
{

$.ajax({
type: "POST",
url: current_url+"/SearchEngine",
data: dataString,
/*Uncomment this if you want to send the additional data*/
//data: dataString+"&refid="+ref_id+"&custid="+cust_id,
beforeSend:  function() {

$('input#faq_search_input').addClass('loading');
},
success: function(server_response)
{
//$('#content').append(server_response).show();
$(server_response).insertAfter('#mainmenu');

$('#content > #main_section').hide();
$('#content > #main_section.search').show();
$('#searchresultdata').show();
$('#blog_tabscontainer').css('display','none');
$('#yw0').css('display','none');
$('.dop_text').css('display','none');
$('#content > #content').css('display','none');

$('span#faq_category_title').html(faq_search_input);
 
if ($('input#faq_search_input').hasClass("loading")) {
 $("input#faq_search_input").removeClass("loading");
        } 
 
}
});
}else{

$('#content > #main_section').show();
$('#content > #main_section.search').remove();
$('#searchresultdata').css('display','none');
$('#blog_tabscontainer').css('display','');
$('#yw0').css('display','');
$('.dop_text').css('display','');
$('#content > #content').css('display','');


}

return false;
});
});
 
</script>


	<div class="clear"></div>
</div><!-- content -->
	<footer>
		<ul class="social">
			<li><a class="apple_icon" href="#"></a></li>
			<li><a class="android_icon" href="#"></a></li>
		</ul>
		
		<ul class="contact_copyright">
			<li>&copy; 2000-2013, Все права защищены \</li>
			<li><a href="#">Контакты</a></li>
		</ul>
		
<!-- search starts --> 
<body onload="document.search_form.query.focus()">
<?php 
/*To import the client script*/
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
?>
 
<div class="admin">
 
<?php
$model_name=Yii::app()->controller->id;
$current_url=$baseUrl."/news";
?>

        <input class="current_url" type="hidden" id="<?php echo $current_url;?>" value="Поиск по сайту""/>
                <!-- The Searchbox Starts Here  -->
                <form  name="search_form" id="searchForm">
				
                 <input  name="query" type="text" id="faq_search_input" style="background-color: #FFFFFF" />
                </form>
                <!-- The Searchbox Ends  Here  -->
       
     </div>
<!-- search ends -->	
	<ul class="social2">
			<li><a class="social_icon_x" href="#"></a></li>
			<li><a class="twitter" href="#"></a></li>
			<li><a class="facebook" href="#"></a></li>
		</ul>
          
	</footer>
<div id="id_view"></div>
<div id="id_category"></div>
<div id="registration"></div>





 <script type="text/javascript">
  $('#mainNavbar').flexMenu();
 </script>
</body>
</html>
