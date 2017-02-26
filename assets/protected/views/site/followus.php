<div class="followus">
    <p class="title"><?php $text = Content::model()->find('name="followus"');echo $text->getTitle(); ?></p>

    <div class="dop_text"><span><?php echo $text->getText(); ?></span></div>

    <div class="social_followus">
        <a href="https://www.facebook.com/newskeeper.official" class="facebook" target="_blank"></a>
        <a href="http://instagram.com/newskeeper_ua#" target="_blank" class="in"></a>
        <a href="https://twitter.com/newskeeper_ua" class="twiter" target="_blank"></a>
        <a href="http://vk.com/news_keeper" class="vk" target="_blank"></a>
    </div>

    <div class="recommendations_radioblock">
        <span><div class="radio radio1 later" onclick="radioLater('follow')"></div><p><?php echo Yii::t('app','Напомнить позже')?></p></span>
        <span><div class="radio radio1 never" onclick="radioNever('follow')"></div><p><?php echo Yii::t('app','Больше не напоминать')?></p></span>

        <input type="hidden" id="radion" />
    </div>

    <div class="block-followus_ok_close"><a href="javascript:void(0)" class="followus_ok_close" onclick="setLater(1,'follow')">OK</a></div>

    <div class="btn-close" onclick="$.colorbox.close()"></div>
</div>

