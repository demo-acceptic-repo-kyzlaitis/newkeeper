<div class="login_registration">
<div class="login_registration_inner">
    <div class="login_registration_tab">
    <ul class="tabs entry">
		<li class="current"><?php echo Yii::t('app','Вход'); ?></li> &nbsp;/&nbsp;
		<li><?php echo Yii::t('app','Регистрация'); ?></li>
    </ul> 
    <span class="error_msg"></span>
<div class="box visible">
<?php $model=new UserLogin;
$this->renderPartial('/user/login',array('model'=>$model),false,false); ?>
</div>

<div class="box box_reg">
<!--<span class="reg_text"><?php echo Yii::t('app','Рекомендуем пройти быструю регистрацию, чтобы Newskeeper запоминал Ваши интересы'); ?></span>-->
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>
	
	<?php if(isset($profile))
    echo $form->errorSummary(array($model,$profile));
    else
    echo $form->errorSummary(array($model));
     ?><!--
<div class="reg_row">
    <?php //echo $form->label($model,'username'); ?>
	<?php echo $form->textField($model,'username',array('class'=>'mail','placeholder'=>'Login',/*Yii::t('app','Имя пользователя')*/));
    //"onfocus"=>"if (this.value == 'Username') {this.value = ''; this.style.color = '#000';}",					"onblur"=>"if (this.value == '') {this.value = 'Username'; this.style.color = '#999';}")); ?>
	<?php echo $form->error($model,'username'); ?>
</div>-->
<div class="reg_row">
    <?php //echo $form->label($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('class'=>'mail',"value"=>'','placeholder'=>'E-mail'));
    //"onfocus"=>"if (this.value == 'E-mail') {this.value = ''; this.style.color = '#000';}","onblur"=>"if (this.value == '') {this.value = 'E-mail'; this.style.color = '#999';}")); ?>
	<?php echo $form->error($model,'email'); ?>
</div>
<div class="reg_row">
    <?php //echo $form->label($model,'password'); ?>
	<?php echo $form->passwordField($model,'password',array('class'=>'mail','placeholder'=>Yii::t('app','Пароль')));
    //"onfocus"=>"if (this.value == '') {this.value = ''; this.style.color = '#000';}",	"onblur"=>"if (this.value == '') {this.value = ''; this.style.color = '#999';}")); ?>
	<?php echo $form->error($model,'password'); ?>
	<!--<p class="hint">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>-->
</div>
<div class="reg_row">
    <?php //echo $form->label($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword',array('class'=>'mail',"value"=>'','placeholder'=>Yii::t('app','Подтверждение пароля')));
    //"onfocus"=>"if (this.value == '') {this.value = ''; this.style.color = '#000';}",					"onblur"=>"if (this.value == '') {this.value = ''; this.style.color = '#999';}")); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
</div>

<?php 
		if(isset($profile)) $profileFields=$profile->getFields();
		if (isset($profileFields)) {
			foreach($profileFields as $field) {
			?>
	<div class="row">
		<?php echo $form->labelEx($profile,$field->varname); ?>
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>	
			<?php
			}
		}
?>
<!--	<?php //if (UserModule::doCaptcha('registration')): ?>
	<div class="row">
		<?php //echo $form->labelEx($model,'verifyCode'); ?>
		
		<?php //$this->widget('CCaptcha'); ?>
		<?php //echo $form->textField($model,'verifyCode'); ?>
		<?php //echo $form->error($model,'verifyCode'); ?>
		
		<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
	</div>
	<?php //endif; ?>

<a class="termsPage" href="javascript:void(0);"><?php echo Yii::t('app', 'Пользовательское соглашение'); ?></a>-->
<p class="forget_password">
<span class='reg_ok_close' onclick="reg_ok()">OK</span>
</p>

<?php $this->endWidget(); ?>
</div><!-- box reg -->

<div class="btn-close"></div>
<?php //$this->widget('ext.hoauth.widgets.HOAuth'); ?>
</div>
<div class="recovery_tab">
    <?php $this->renderPartial('/recovery/_recovery',array('form'=>new UserRecoveryForm),false,false); ?>
</div>
</div><!-- login_registration inner -->
</div><!-- login_registration -->
<?php //echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'okbutton')); ?>
