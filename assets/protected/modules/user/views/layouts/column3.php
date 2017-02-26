<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
		<?php echo $content; ?>
<aside id="cabinet">
			<div class="cabinet_avatar">
				<img src="images/avatar.png" alt="" />
				<p>Виктор Грудаков</p>
			</div>
			
			<ul class="different_indormation profile_information">
				<li class="one_info">
					<div class="icon_profile icon_profile_1"><p>Закладки</p></div>	
					<a href="/news/bookmarks"></a>
				</li>
				
				<li class="two_info">
					<div class="icon_profile icon_profile_2"><p>Настройка&nbsp;тем</p></div>
					<a href="/category/mythemes"></a>
				</li>
				
				<li class="three_info">
					<div class="icon_profile icon_profile_3"><p>Блог</p></div>
					<a href="/bloger/request"></a>
				</li>
				
				<li class="four_info">
					<div class="icon_profile icon_profile_4"><p>Настройки</p></div>	
					<a href="/user/profile/edit"></a>
				</li>
			</ul>
			
			<!-- <ul class="languages">
				<li><a href="#">Ua</a></li>
				<li><a href="#">Rus</a></li>
				<li><a class="active" href="#">Eng</a></li>
			</ul> -->
			<?php
			if(Yii::app()->user->isGuest){
				echo CHtml::link('Login','/user/login',array('class'=>'logout'));
			}else{
				echo CHtml::link('Logout','/user/logout',array('class'=>'logout'));
			}
			?>

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

    $xml  = simplexml_load_file($API_url);
//print($xml->current_condition->temp_C);
            ?>
	</div><!-- sidebar -->
<?php $this->endContent(); ?>