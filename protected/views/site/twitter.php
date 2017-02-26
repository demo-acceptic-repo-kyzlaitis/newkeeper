<div class="login_registration">
<div class="login_registration_inner">
    <div class="entry"><?php $text = Content::model()->find('name="twitter"');echo $text->getTitle(); ?></div>
	
	<span class="error_msg"></span>
    
    <div class="tw_text"><span><?php echo $text->getText(); ?></span></div>

	<form id="twitter_complete" name="twitter_complete">
		<div class="reg_row single">
	        <input type="text" id="email" name="email" placeholder="E-mail" />
    	</div>
    </form>

	<div class="pop_but">
	    <div class="cancel_close"><a href="javascript:void(0)" class="" onclick="tw_cancel()">Отмена</a></div>
	    <div class="ok_close"><a href="javascript:void(0)" class="" onclick="tw_ok()">OK</a></div>
	</div>
</div>
</div>