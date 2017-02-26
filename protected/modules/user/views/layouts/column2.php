<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
		<?php echo $content; ?>
<aside id="cabinet">
			<div class="cabinet_avatar">
                            <?php echo CHtml::image("/images/avatar1.png"); ?>
				<div><?php echo CHtml::link("Кабинет","/news/bookmarks"); ?></div>
			</div>
			
			<script type="text/javascript">
				$(document).ready(function(){
					$('#slider1').tinycarousel({ axis: 'y', start: 2, pager: true});
				});
				
				$(document).ready(function(){
					$('#slider2').tinycarousel({ axis: 'y', start: 2, pager: true});
				});
			</script>
			
			<ul class="different_indormation">
				<li class="one_info"><div id="temperature"><?php $this->widget('application.components.widgets.Temperature');?></div><span></span>
					<ul id="slider1" class="info1 sliders">
					<div class="viewport">
                                                <?php $this->widget('application.components.widgets.WeatherMenu');?>
					</div>
						<a class="arrow_up buttons prev" href="javascript:void()"></a>
						<a class="arrow_down buttons next" href="javascript:void()"></a>
					</ul>
				</li>
				
				<li class="two_info"><div id="currency"><?php $this->widget('application.components.widgets.Currency');?></div><span></span>
					<ul class="info2">
						<ol class="currency_trade">
							<li>покупка</li>
							<li class="money"><?php $this->widget('application.components.widgets.Currency');?></li>
							<li>продажа</li>
							<li class="money"><?php $this->widget('application.components.widgets.CurSale');?></li>
						</ol>
						
						<?php $this->widget('application.components.widgets.CurrencyMenu');?>
						
						<a class="arrow_up" href="javascript:void(0);"></a>
						<a class="arrow_down" href="javascript:void(0);"></a>
					</ul>
				</li>
				
				<li class="three_info"><div id="traffic"><?php $this->widget('application.components.widgets.Traffic');?></div><span></span>
					<ul id="slider2" class="info1 sliders">
					<div class="viewport">
					<?php $this->widget('application.components.widgets.TrafficMenu');?>
					</div>
						<a class="arrow_up buttons prev" href="javascript:void()"></a>
						<a class="arrow_down buttons next" href="javascript:void()"></a>
					</ul>
				</li>
			</ul>
			<?php $this->widget('application.components.widgets.LangMenu');?>
			
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