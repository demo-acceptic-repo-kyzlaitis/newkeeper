<?php
/* @var $this BlogerController */
/* @var $data Bloger */
            $checked = "Подписаться";
if(Yii::app()->user->isGuest && Yii::app()->session['blogers']){
    foreach(Yii::app()->session['blogers'] as $bkmrk){
        if($bkmrk == $data->user_id){
            $checked = "Отписаться";
        }
    }
}else{
    foreach($data->readers as $reader){
        if($reader->id == Yii::app()->user->id){
            $checked = "Отписаться";
        }
    }
}
?>

<li id="<?php echo $data->user_id; ?>">
    <div class="bloger_short">
        <?php echo $data->user->getAvatar(44,'theme_bloger') ?>
    
    	<div class="bloger_name">
    		<?php echo CHtml::encode($data->getPenName()); ?>
    	</div>
            
            <?php /*echo CHtml::ajaxLink($checked, CController::createUrl('bloger/subscribe', array('id'=>$data->user_id)),  
                  array('type' => 'POST',
                      'success'=>new CJavaScriptExpression("function(html){jQuery('.subscribe".$data->user_id."').text(html)}"),
                  ),
                  array(
                      'class'=>'subscribe'.$data->user_id,
                  )); */?>
          
    	<?php echo CHtml::link(CHtml::encode("Читать"), Yii::app()->createUrl('news/blog/'.$data->slug), array(
    		'class' => 'read_bloger'
    	)); ?>
    </div>
    
    <div class="bloger_desc">
        <?php echo $data->getDescription(); ?>
    </div>
</li>