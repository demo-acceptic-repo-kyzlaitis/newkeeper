<?php
$active = "";
$checked = "";
if(Yii::app()->user->isGuest && Yii::app()->session['blogers'])
{
    foreach(Yii::app()->session['blogers'] as $bkmrk){
        if($bkmrk == $bloger->user_id){
            $active = "active";
            $checked = "checked=''";
        }
    }
}else{
    foreach($bloger->readers as $reader){
        if($reader->id == Yii::app()->user->id){
            $active = "active";
            $checked = "checked=''";
        }
    }
}
?>

<div class="image_news subscription">
    <?php echo $bloger->user->getAvatar(User::AVA_BLOGER_SIZE);?>
    <div class="bloger-name">
        <?php
            $p_name = $bloger->getPenName();
            $p_name_pices = explode(" ", $p_name);
            $p_name = $p_name_pices[0] . "<br />" . $p_name_pices[1];
        ?>
        <?php echo CHtml::link($p_name, Yii::app()->createUrl('/bloger/info/'.$bloger->slug)); ?>
    </div>

	<div class="checkboxes checkbox_registration">        
	    <div>
            <div class="check <?php echo $active; ?>" id="<?php echo $bloger->user_id; ?>">
                <input type="checkbox" value="" <?php echo $checked?> />
            </div>             
            <?php echo Yii::t('app','Подписаться'); ?>
        </div>
	</div>
</div>


