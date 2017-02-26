<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>


<?php echo CHtml::beginForm('/user/login','post',array('id'=>'login-form')); ?>
<?php /*$form=$this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true, // javascript-валидация на клиенте
    'enableAjaxValidation' => true, // ajax-валидация на сервере
    'clientOptions' => array(
        'validateOnSubmit' => true, // валидировать форму по нажатию кнопки submit
        'validateOnChange' => false,
        'validateOnType' => false,
        //'validationUrl' => $this->createUrl('subcategory/create'), // url для валидации формы
    ),));*/
?>
	
	<?php echo CHtml::errorSummary($model); ?>
	
	<div class="reg_row">
    
		<?php //echo CHtml::activeLabel($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username',array('class'=>'mail','placeholder'=>'E-mail')) ?>
	</div>
	
	<div class="reg_row">
		<?php //echo CHtml::activeLabel($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password',array('class'=>'mail','placeholder'=>Yii::t('app','Пароль'))); ?>
	</div>
<p class="forget_password">
    <?php echo CHtml::link(Yii::t("app","Забыли пароль?"),/*Yii::app()->getModule('user')->recoveryUrl*/'javascript:void(0)',array('onclick'=>'recoverPopup()')); ?>
    <?php echo CHtml::activeCheckBox($model,'rememberMe',array('checked'=>'checked')); ?>
<span class='login_ok_close' onclick="login_ok()">OK</span></p>
<?php //echo CHtml::ajaxSubmitButton('OK','/user/login',array('class'=>'login_ok_close')); ?>
<p class="remember">
		
</p><!--
<p class="social_bottom"><a href="/user/login/oauth?provider=Facebook">Login with Facebook</a>
<a></a><a href="/user/login/oauth?provider=Twitter" class"twitter">Login with Twitter</a><a></a></p>-->
<?php echo CHtml::endForm(); ?>



<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>

<div class="social_bottom"><!--<a style="top: 120px;" href="https://www.facebook.com/dialog/oauth?client_id=589294821132211&redirect_uri=http://<?=$_SERVER['HTTP_HOST']."/user/user/login_fb"?>" class="facebook"><?=Yii::t("app","Войти через Facebook")?><span></span></a>-->
	<a href="/user/login/facebook" class="facebook"><span></span><?=Yii::t("app","Войти")." ".Yii::t("app","через")." Facebook"?></a>
	<a href="/user/login/twitter" class="twitter"><span></span><?=Yii::t("app","Войти")." ".Yii::t("app","через")." Twitter"?></a>
</div>
<script>
$(document).keypress(function(e) {
    if(e.which == 13) {
        login_ok()
    }
});
</script>