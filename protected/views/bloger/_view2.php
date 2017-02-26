<?php
/* @var $this BlogerController */
/* @var $data Bloger */
            $active = "";
            $checked = "";
if(Yii::app()->user->isGuest && Yii::app()->session['blogers']){
    foreach(Yii::app()->session['blogers'] as $bkmrk){
        if($bkmrk == $data->user_id){
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
?>

<div class="checkboxes checkbox_registration setting_block blogcheck">
    <?php echo CHtml::link($data->user->getAvatar(44,'theme_bloger'),'/news/blog/'.$data->slug,array('class'=>'ava_link')); ?>
	<p><?php echo CHtml::link(CHtml::encode($data->getPenName()),'/news/blog/'.$data->slug); ?></p><span class="setting_border"></span>
    <div id="<?php echo CHtml::encode($data->user_id); ?>" class="check <?php echo $active; ?>">
        <input type="checkbox" value="" <?php echo $checked; ?> />
    </div>
</div>