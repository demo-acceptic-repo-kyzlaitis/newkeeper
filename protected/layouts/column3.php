<?php /* @var $this Controller */ 
$user = User::model()->findByPk(Yii::app()->user->id);

// link for blogger
$uslug = '';
//if($user)
    //$uslug = $user->bloger->slug;
    
$uri = $_SERVER['REQUEST_URI'];?>
<?php $this->beginContent('//layouts/main'); ?>
		<?php echo $content; ?>
<div id="cabinet_wrapper">
<aside id="cabinet">
    <div class="cabinet_inner">
			<div class="cabinet_avatar profile">

				<?php print (Yii::app()->user->id) ?  User::model()->findByPk(Yii::app()->user->id)->getAvatar(65,'side_ava') : CHtml::image("/images/avatar_unregistered.jpg")?>
                <div><span>
				<?php 
                    if(Yii::app()->user->id){
                        $username = User::model()->findByPk(Yii::app()->user->id)->getFullName(false, 'en');
                        print strlen(trim($username)) > 0 ? $username : Yii::t('app','Кабинет');
                    }
                ?>
                </span></div>
				<?php
			if(Yii::app()->user->isGuest){
				echo "<div class='open'>".CHtml::link(Yii::t("app","Войти"),'javascript:void(0);',array('onclick'=>'regPopup()'))."</div>";
			}?>
			</div>

			<script>
	            while($('.cabinet_avatar span').width() >= $('.cabinet_avatar div').width() && $('.cabinet_avatar span').css('font-size').substr(0,2)>8){
			         var font = $('.cabinet_avatar span').css('font-size');
                     if(font)
			             $('.cabinet_avatar span').css('font-size',font.substr(0,2)-1);
			    }
			    if($('.cabinet_avatar span').width() >= $('.cabinet_avatar p').width())
			        var font = $('.cabinet_avatar span').css('font-size');
                    if(font)
			             $('.cabinet_avatar span').css('font-size',font.substr(0,2)-1);
            </script>

			<ul class="different_indormation user-panel">
				<li class="one_info<?php print(($uri == '/news/bookmarks' || substr($uri,3) == '/news/bookmarks') ? ' active' : ' ')?>">
					<a href="<?php echo Yii::app()->createUrl('/news/bookmarks'); ?>" >
						<i class="bookmarks"></i>
					</a>	
					<span class="tooltip"><?=Yii::t("app","Закладки")?></span>					
				</li>
				
				<li class="two_info<?php print(($uri == '/category/mythemes' || substr($uri,3) == '/category/mythemes') ? ' active' : ' ')?>">
					<a href="<?php echo Yii::app()->createUrl('/category/mythemes'); ?>" class="">
						<i class="mythemes"></i>
					</a>
					<span class="tooltip"><?=Yii::t("app","Настройка&nbsp;тем")?></span>
				</li>
                <!--
				<li class="three_info<?php print(($uri == '/news/blog/'.$uslug || substr($uri,3) == '/news/blog/'.$uslug || $uri == '/news/create/blog' || substr($uri,3) == '/news/create/blog') ? ' active' : ' ')?>">
					<a href="<?php echo Yii::app()->createUrl('/bloger/request'); ?>">
						<i class="request"></i>
					</a>
					<span class="tooltip"><?=Yii::t("app","Блог")?></span>
				</li>-->
				
				<li class="four_info<?php print(($uri == '/user/profile/edit' || substr($uri,3) == '/user/profile/edit') ? ' active' : ' ')?>">
                    <?php if(Yii::app()->user->isGuest):?>
                        <?php echo CHtml::link('<i class="edit"></i>','javascript:void(0);',array('onclick'=>'regPopup()'));?>
                    <?php else: ?>
                        <?php echo CHtml::link('<i class="edit"></i>', Yii::app()->createUrl('/user/profile/edit')); ?>
                    <?php endif; ?>
					<span class="tooltip"><?=Yii::t("app","Настройки")?></span>

				</li>
			</ul>
			
			<?php $this->widget('application.components.widgets.LangMenu');?>
			<?php //$this->widget('application.components.widgets.LangMenuSelect');?>
			
			
			<div class="logout_wrap"><?php print (((Yii::app()->user->id)) ? CHtml::link(Yii::t("app","Выйти"),'/user/logout',array('class'=>'logout')) : "")?></div>
</div>
			</aside>
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
?>
	
            <?php //$this->widget('application.components.weather.GoogleWeatherAPI', array('location'=>$location)); 
    $location  = "Kiev"; // can also be: Denver,CO
    $API_url = "http://api.worldweatheronline.com/free/v1/weather.ashx?q=".$location."&format=xml&num_of_days=1&key=rcsvmajxeyqsedyw69mvgzjj";

   // $xml  = simplexml_load_file($API_url);
//print($xml->current_condition->temp_C);
            ?>
	</div><!-- sidebar -->
</div><!-- sidebar wrapper -->
<?php $this->endContent(); ?>

<script>
	(function($){
	    $('.user-panel a').each(function () {             // получаем все нужные нам ссылки
	        var location = window.location.href; // получаем адрес страницы
	        var link = this.href;                // получаем адрес ссылки
	        if(location == link) {               // при совпадении адреса ссылки и адреса окна
	            $(this).parent().addClass('active');  //добавляем класс
	        }
	    });
	})(jQuery);
</script>