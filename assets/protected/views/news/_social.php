<?php 
$title=urlencode(Yii::app()->name." :: ".$data->getName());
$url=urlencode("http://".$_SERVER['HTTP_HOST']."/?news_popup=news_" . $data->slug);
$summary=urlencode($data->getTeaserOrTitle());
$image=urlencode("http://".$_SERVER['HTTP_HOST']."/uploads/preview/".$data->preview_source);

?><!--
<a class="fb" data-soc="fb" target="_blank" href="https://www.facebook.com/sharer/sharer.php?s=100
&p[title]=<?=$data->getName()?>
&p[url]=<?=$url?>
&p[images][0]=<?=urlencode("http://".$_SERVER['HTTP_HOST']."/uploads/preview/".$data->preview_source)?>
"></a>
-->

<a class="fb" data-soc="fb" target="_blank" href="https://www.facebook.com/dialog/feed?
app_id=1526643264271868
&display=popup&caption=http://<?=$_SERVER['HTTP_HOST']?>
&link=<?=$url?>
&redirect_uri=http://<?=$_SERVER['HTTP_HOST']?>/site/closewindow
&picture=<?=urlencode("http://".$_SERVER['HTTP_HOST']."/uploads/preview/".$data->preview_source)?>
&name=<?=$data->getName()?>
"></a>


<a class="in" data-soc="in" href="javascript:void(0)" onclick="instshare(<?php echo $data->id ?>)"></a>

<a class="tw" data-soc="tw" target="_blank" href="http://twitter.com/home?status=<?php echo Yii::app()->name; ?>::<?php print $data->getName()?>+<?php print $url; ?>"></a>

<a class="vk" data-soc="vk" target="_blank" href="http://vk.com/share.php?url=<?=$url?>
&title=<?=$data->getName()?>
&image=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/uploads/preview/'.$data->preview_source)?>"></a>

<span class="share_text"><?php echo Yii::t('app','Поделиться новостью с друзьями')?></span>
<span class="share_inst"><?php echo Yii::t('app','Опция размещения новостей в Инстаграм доступна на мобильных устройствах')?></span>