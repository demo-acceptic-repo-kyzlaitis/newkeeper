<section id="main_section" class="request">
<?php
/* @var $this BlogerController */
/* @var $model Bloger */
if(Yii::app()->user->isGuest):?>
<p><?php echo $summary_r->getText()?></p>
<?php else: ?>
    <?php
    if($model->status == Bloger::STATUS_PROCESSING):
    ?>
    <div class="application_accepted">
        <p><?php echo $summary_s->getText()?></p>
        <div class="buttom_registration">
            <input type="submit" value="<?php echo Yii::t('app', 'Отозвать заявку')?>" onclick="window.location = '/bloger/unrequest'" />
        </div>
    </div>
    
    <?php else: ?>
    
    <?php echo $this->renderPartial('_form', array('model'=>$model,'summary'=>$summary,)); ?>
    
    <?php endif; ?>
<?php endif; ?>
</section>