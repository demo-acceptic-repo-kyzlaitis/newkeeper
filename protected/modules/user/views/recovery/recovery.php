<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Restore");
$this->breadcrumbs = array(
    UserModule::t("Login") => array('/user/login'),
    UserModule::t("Restore"),
);
?>
<?php if (Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
<?php else: ?>
<div class="popup1 login_registration recovery">
    <div class="title"><?php echo Yii::t('app', "Восстановление пароля"); ?></div>

    <!-- <span class="error_msg"></span> -->
    <div class="box visible">
        <div class="form" id="recover-form">
            <?php echo CHtml::beginForm(); ?>

            <?php echo CHtml::errorSummary($form); ?>

            <div class="rec_row">

                <?php echo CHtml::activeTextField($form, 'login_or_email',
                    array('class' => 'mail', 'placeholder' => Yii::t('app', 'Пожалуйста, введите ваш логин или e-mail'))) ?>

            </div>

            <div class="row submit">
                <span class='login_ok_close' onclick="recover_ok()"><?php echo Yii::t('app', "OK"); ?></span>
            </div>

            <?php echo CHtml::endForm(); ?>
        </div>
        <!-- form -->
    </div>
    <!-- box -->
    <div class="btn-close" onclick="$.colorbox.close()"></div>
    <?php endif; ?>
</div><!-- login_registration -->