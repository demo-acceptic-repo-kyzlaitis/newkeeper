<?php
/* @var $this CategoryController */
/* @var $data Category */

            $active = "";
            $checked = "";
if(Yii::app()->user->isGuest && isset(Yii::app()->session['categories'])){
    foreach(Yii::app()->session['categories'] as $bkmrk){
        if($bkmrk == $data->id){
            $active = "active";
            $checked = "checked=''";
        }
    }
}else{
    foreach($data->readers as $reader){
        if($reader->id == Yii::app()->user->id){
            $active = "active";
            $checked = "checked=''";
        }
    }
}
//print_r(Yii::app()->session['categories']);
?>
<?php //echo CGallery::thumb_span($data->media_source,160,130,array('id'=>$data->id)); ?>
<div class="checkboxes checkbox_registration setting_block catcheck">
	<span class="setting_border"></span>
    <p><?php echo CHtml::link(CHtml::encode($data->getName()),'/news/category/'.$data->slug); ?></p>
	<div id="<?php echo CHtml::encode($data->id); ?>" class="check <?php echo $active; ?>">
	<input type='checkbox' value='' <?php echo $checked; ?> />
	</div>
</div>