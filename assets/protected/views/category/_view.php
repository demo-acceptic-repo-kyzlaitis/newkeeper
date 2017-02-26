<?php
/* @var $this CategoryController */
/* @var $data Category */
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/scripts.js');
$checked = "none";
if(Yii::app()->user->isGuest && isset(Yii::app()->session['categories'])){
    foreach(Yii::app()->session['categories'] as $bkmrk){
        if($bkmrk == $data->id){
            $checked = "block";
        }
    }
}else{
    foreach($data->readers as $reader){
        if($reader->id == Yii::app()->user->id){
            $checked = "block";
        }
    }
}
//print_r(Yii::app()->session['categories']);
?>
<?php //echo CGallery::thumb_span($data->media_source,160,130,array('id'=>$data->id)); ?>
<span class="csubscribe" id="<?php echo $data->id?>" onclick="catSubcribe(<?php echo $data->id?>)">
    <?php echo $data->previewThumb()?>
    <div class='mytape_ok' style='display:<?php echo $checked?>'></div>
    <span class="catname"><?php echo CHtml::encode($data->getName())?></span>
</span>