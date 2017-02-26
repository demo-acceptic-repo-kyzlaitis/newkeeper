<div class="mobile">
			<p><?php echo Yii::t('app','Мобильные приложения'); ?></p>
			
			<div class="dop_text"><?php $text = Content::model()->find('name="application"');echo $text->getText(); ?></div>
			
			<div class="mobile_gadgets">	
				<a href="#"><img src="/images/iPhone_icon.png" alt="" /><span>iPhone</span></a>
				<a href="#"><img src="/images/iPad_icon.png" alt="" /><span>iPad</span></a>
				<a href="#"><img src="/images/android_icon.png" alt="" /><span>Android</span><span class="mytype_ok"></span></a>
			</div>	
			
			<div class="recommendations_radioblock">
				<div class="radio radio1 later" onclick="radioLater('mobile')"></div><p>Напомнить позже</p>
				<div class="radio radio1 never" onclick="radioNever('mobile')"></div><p>Больше не напоминать</p>

				<input type="hidden" id="radion" />
			</div>
			
            <div class="buttom_recommendations">
                <a href="javascript:void(0)" class="followus_ok_close" onclick="setLater(1,'mobile')">OK</a>
			</div>
			
			<div class="btn-close" onclick="$.colorbox.close()"></div>
</div>