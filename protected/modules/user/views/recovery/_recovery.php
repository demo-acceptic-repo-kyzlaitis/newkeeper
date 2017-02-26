<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
<?php else: ?>
<div class="recovery">
    <div class="entry"><?php echo Yii::t('app',"Восстановление пароля"); ?></div>

    <!-- <span class="error_msg"></span> -->
    <div class="">
        <div class="form" id="recover-form">
            <?php echo CHtml::beginForm(); ?>

            <?php echo CHtml::errorSummary($form); ?>

            <div class="reg_row">
                <?php // echo CHtml::activeLabel($form,'login_or_email',array('class'=>'mail_recov')); ?>

                <div class="rec_text"><?php echo UserModule::t("Пожалуйста, введите ваш e-mail"); ?></div>

                <?php echo CHtml::activeTextField($form,'login_or_email',array('class'=>'mail', 'placeholder' => Yii::t('app','e-mail'))) ?>

            </div>

            <div class="forget_password">
                <span class='login_ok_close' onclick="recover_ok()"><?php echo Yii::t('app',"OK"); ?></span>
                <span class='recover_cancel' onclick="recoverBack()"><?php echo Yii::t('app',"Cancel"); ?></span>
            </div>

            <?php echo CHtml::endForm(); ?>
        </div><!-- form -->
    </div><!-- box -->
    <?php endif; ?>
</div><!-- recovery -->