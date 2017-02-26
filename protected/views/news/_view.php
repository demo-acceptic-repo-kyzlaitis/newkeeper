<?php
/* @var $this NewsController */
/* @var $data News */
if($index == 0 && $blog){ //if this is blog - first block is add button
    switch($alien){
        case true: $this->renderPartial('_blog_alien',array('bloger'=>$bloger));break;
        case false: include('_blog_add.php');break;
        default: include('_blog_add.php');break;
    }
}else{
$checked = "";
$bgpos = '';
foreach($data->bookmarkers as $bmarker):
    if($bmarker->id == Yii::app()->user->id || (Yii::app()->user->isGuest && isset($sess[$data->id]))){
        $checked = "<span class='news_bookmark'></span>";
        $bgpos = ' greenbook';
    }
endforeach;
if(Yii::app()->user->isGuest && isset(Yii::app()->session['bookmarks'])){
    foreach(Yii::app()->session['bookmarks'] as $bkmrk){
        if($bkmrk == $data->id){
            $checked = "<span class='news_bookmark'></span>";
            $bgpos = ' greenbook';
        }
    }
}
$hot = '';
if($data->hot == 1)
    $hot = ' you_news';
$regpopup = "";
if(Yii::app()->user->isGuest)
    $regpopup = "regPopup()";

$sess = Yii::app()->session['bookmarks'];
?>
<div class="image_news <?php echo $hot; ?>" id="news<?php echo $data->id; ?>" data-loaded="0" data-id="<?php echo $data->id; ?>">
    <div class="news-parent">
    <div class="hot_border"></div>
    <?php echo $checked;?>
    <div class="social_news">
        <?php $this->renderPartial('_social',array('data' => $data)); ?>
    </div>

    <div class="downloaded">
			<div class="down"></div>
			<div class="caption"><?php echo Yii::t('app', 'Картинка сохранена') ?></div>
    </div>

    <div class="inner" style="/*position:absolute;*/">
    <div class="unread_news"></div>
    <div class="unread_msg"><?php echo Yii::t('app', 'Новость отмечена как непрочитанная и занесена в соответствующий раздел') ?></div>
    <div class="description_news <?php print ($data->blog ? 'bloger' : '');?>" data-loaded="0">
        <?php if($data->blog):?>
          <div class="nohover">
            <?php echo CHtml::link($data->author->getAvatar(45,'desc_ava'), Yii::app()->createUrl('news/blog/'.$data->author->bloger->slug)); ?>
          </div>
        <?php endif; ?>
        <span class="title<?php if($data->blog):?> blog<?php endif; ?>">
        <?php echo $data->getTeaserOrTitle(); ?></span>
    </div>
	<?php echo $data->previewThumb(); ?>
    <div class="shadow_and_news_icon">

        <?php if($data->blog):?>
        	<span class='shadow_bloger'>
            	<?php echo CHtml::link($data->author->bloger->getPenName(), Yii::app()->createUrl('news/blog/'.$data->author->bloger->slug)); ?>
            </span>
        <?php endif; ?>
        
    <?php if(Yii::app()->getModule('user')->isAdmin()):?>
      <span class="update" onclick="window.location = '/yiiadmin/manageModel/update?model_name=NewsAdmin&pk=<?php echo $data->id; ?>'">
      	<img src="/images/pencil-white-icon.png" class="" />
      	<?php //echo Yii::t('app','Редактировать')?>
      </span>
        <div class="news_stat">            
            <span class="bkmrk_stat"><?php echo (isset($data->statistic) ? $data->statistic->bookmarks_count : 0)?></span>
            <span class="share_stat"><?php echo (isset($data->statistic) ? $data->statistic->getSharesCount() : 0)?></span>
            <span class="dl_stat"><?php echo (isset($data->statistic) ? $data->statistic->downloads_count : 0)?></span>
        </div>
    <?php endif;?>
<span class="read_news" onclick="readNews('news_<?php echo $data->slug?>', '<?php echo Yii::app()->params->lang; ?>',<?php echo $data->id?>)" data-href="/<?php echo Yii::app()->params->lang; ?>/news/view/-<?php echo $data->slug?>">
	<?php echo Yii::t("app","Прочитать")?>
</span>
      <?php /* old ajax link. Replaced by readNews())
          echo CHtml::ajaxLink(Yii::t("app","Прочитать"), Yii::app()->createUrl('/news/view', array('id'=>$data->id,"asDialog"=>1)),
                    array('type' => 'POST',
                        'update'=>'#id_view',
                    ),
                    array(
                        'class'=>'read_news',
                        'live'=>true,
                        //'id'=>'yt'.$data->id,
                    ));*/
      ?>

        <div class="panel">
			<a class="bookmark<?php echo $bgpos?>" onclick="loggedAction('bkmrkNews', <?php echo $data->id?>);" href="javascript:void(0);"></a>
            <?php /*echo CHtml::ajaxLink("", CController::createUrl('news/bookmark', array('id'=>$data->id)),
                  array('type' => 'POST',
                      'dataType' => 'json',
                      'success'=>new CJavaScriptExpression("function(html){
                          bookmark(html,".$data->id.");
                      }"),
                  ),
                  array(
                      'class'=>'bookmark',
                      'style'=>'background-position: '.$bgpos,
                      'live'=>true,
                      "onclick"=>$regpopup,
                  ));*/
            ?>
            <a class="share" onclick="share(<?php echo $data->id; ?>)" href="javascript:void(0);"></a>
            <a class="download" onclick="downloaded(<?=$data->id?>)" href="<?php echo Yii::app()->createUrl('/news/sendshow?id='.$data->id) ?>" target="_blank"></a>
        </div>
    </div>
    </div>
</div>
</div>
<?php } ?>