<?php
/* @var $this NewsController */
/* @var $model News */
?>
<script>
$(document).ready(function($){
	var a = Math.floor(Math.random()*150+1);
	$('.mfp-close').css('color','#333333');
});
</script>

<div class="pupua-news-mfp mfp-prevent-close">
	<header class="news-header mfp-prevent-close">
	</header>
	<div id="id_view" class="mfp-prevent-close">
		<section class="popup_news popup2 mfp-prevent-close">
            <div class="date mfp-prevent-close"><?php echo $model->getDate(); ?></div>
            <ul class="text-size">
                <li class="plus"><a href="javascript:void(0)" onclick="font(1)"></a></li>
                <li class="minus"><a href="javascript:void(0)" onclick="font(0)"></a></li>
            </ul>
            <article class="mfp-prevent-close">
		        <h1 class="mfp-prevent-close"><?php echo $model->getName(); ?></h1>
		        <?php if($model->isPhotoType()):?>
		        <?php //echo $model->imageThumb(200); ?>
		        <?php else:?>
		            <?php if(strlen($model->video_src) > 0):?>
		              <span class="mfp-prevent-close">
		                <!--<iframe width="370" height="280" src="<?php echo $model->getEmbedVideo(); ?>" frameborder="0" allowfullscreen></iframe>-->
		                <?php echo $model->video_src ?>
		              </span>
		            <?php endif;?>
		        <?php endif;?>
		        
		        <div class="inner-article mfp-prevent-close" style="font-size: <?php print $font_size; ?>px;"><?php echo $model->getText(); ?></div>
		    </article>
		    <div class="source">
			<p style="font-size: <?php print $font_size; ?>px;">Источник: </p>
			<a href="<?php echo $model->source; ?>" target="_blank"><?php echo $model->source; ?></a>
		    </div>
			<div class="between" style="height: 28px;"></div>
		</section>
	</div>
</div>