<?php
$text = Content::model()->find('name="recommend"');
?>

<div class="recommendations">
	<div id="auth_block">
	  <h4 id="head_auth" style=""></h4>
	  <div id="user-info" style="margin-bottom: 20px;"></div> 
	</div>
	<p class="title"><?php echo $text->getName(); ?></p>
	<div class="dop_text"><?php echo $text->getText(); ?></div>
  <div id="result_friends" class="recommendations_checkbox checkboxes"> 
	<button id="fb-auth" style="font-size: 20px;background-color: #c9c9c9;font-weight: normal;border-radius: 18px;line-height: 46px;margin-top: 80px;">Please, login here</button>
  </div>
  <div id="fb-root" style="left: -102.5%;position: relative;top: -95%;"></div>
  <div class="buttom_recommendations"></div>

			<div class="btn-close"></div>
			<div class="btn-recommendations"><a href="#">Ок</a></div>

		    <div class="recommendations_radioblock">
		        <span><div class="radio radio1 later" onclick="radioLater('friends')"></div><p><?php echo Yii::t('app','Напомнить позже')?></p></span>
		        <span><div class="radio radio1 never" onclick="radioNever('friends')"></div><p><?php echo Yii::t('app','Больше не напоминать')?></p></span>
		    </div>

	</div>
<script>
$("#result_friends").mCustomScrollbar({
    autoHideScrollbar:false,
    scrollButtons:{
          enable:true
        }
});
</script>