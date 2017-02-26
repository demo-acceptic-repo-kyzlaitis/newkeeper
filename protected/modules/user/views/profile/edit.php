<?php 
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/cropava.js');
/*$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);*//*
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);*/
?>

<section id="main_section" class="profile">

<ul class="photos">
<?php //CVarDumper::dump($profile->avatar_source);?>
	<a href="#" id="delete_photo"><span style="display: none;"><?php echo Yii::t('app','Вы уверены, что хотите удалить изображение?')?></span></a>
	<div class="avatar_profile"><?php echo CHtml::image($profile->getAvatarPath());?></div>
	<li class="display_thumb" id="1">
        <a href="javascript:void(0)" id="addAva" class="doing_photo">
            <?php echo Yii::t('app','Загрузить фото');?>
        </a>
        <input id="fileupload_ava" type="file" name="loadedFile" data-url="/site/uploadava" />
    </li>
</ul>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'form_settings',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data','class'=>'blocks'),
)); ?>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
	</div>
<?php endif; ?>
<!--
	<div class="personal_information">
		<?php echo $form->labelEx($model,Yii::t('app','Login*')); ?>
		<div class="input-block">
			<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20,'class'=>'text')); ?>
			<?php //echo $form->error($model,'username'); ?>
		</div>
	</div>-->

	<div class="personal_information">
		<?php echo $form->labelEx($model,Yii::t('app','email')); ?>
		<div class="input-block">
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128,'class'=>'text')); ?>
			<?php //echo $form->error($model,'email'); ?>
		</div>
	</div>

	<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			 if($field->varname != 'phone' && 
	         $field->varname != 'city' && 
	         $field->varname != 'day' && 
	         $field->varname != 'month' && 
	         $field->varname != 'year'):
	?>
	<div class="personal_information">
		<?php echo $form->labelEx($profile,Yii::t('app',$field->varname));
			if ($widgetEdit = $field->widgetEdit($profile)) {
				echo $widgetEdit;
			} elseif ($field->range) {
				echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
			} elseif ($field->field_type=="TEXT") {
				echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50,'class'=>'text'));
			} else {
				echo '<div class="input-block">'.$form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255),'class'=>'text')).'</div>';
			}
			//echo $form->error($profile,$field->varname);
		?>
	</div>	
			<?php
            endif;
			}
		}
?>
    
    <script>//помести куда угодно
   jQuery(function ($) {
        $(".datepicker").datepicker({//походу если ты в селектор запилишь что-нибудь другое то по клику сработает
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+0",
            onSelect: function(dateText, inst) { 
                        day = dateText.substr(8,2);
                        month = dateText.substr(5,2);
                        year = dateText.substr(0,4);
                        $("#day").val(day);
                        $("#month").val(month);
                        $("#year").val(year);
                        $("#full").val(dateText);                      
            }
        });
    });
    </script>
    
	<?php if(isset($model->bloger)): ?>
    <div class="personal_information pen_name">
		<label><?php echo Yii::t('app','Псевдоним');?></label>
		<div class="input-block">
			<?php echo $form->textField($model->bloger,'pen_name_ru',array('size'=>20,'class'=>'text')); ?>
			<?php //echo $form->error($model->bloger,'pen_name_ru'); ?>
        </div>
    </div>

    <?php endif; ?>

    <div class="personal_information date_birth">
    	<label><?php echo Yii::t('app','Дата рождения');?></label>
    	<div class="input-block">
	        <?php echo $form->textField($profile,'day',array('size'=>6,'maxlength'=>6,'class'=>'datepicker text','id'=>'day','readonly'=>'readonly'));?>
	        <?php echo $form->textField($profile,'month',array('size'=>6,'maxlength'=>6,'class'=>'datepicker text','id'=>'month','readonly'=>'readonly'));?>
	        <?php echo $form->textField($profile,'year',array('size'=>6,'maxlength'=>6,'class'=>'datepicker text','id'=>'year','readonly'=>'readonly'));?>
	    </div>
	</div>
	<div class="personal_information sex_select">
		<label><?php echo Yii::t('app','Пол');?></label>
		<div class="input-block">
			<li class="recommendations_radioblock" style="display: inline;">
				<span class="radio radio2 <?php print ($profile->sex == 1 ? 'active' : "");?>" id="1"><?php echo Yii::t('app','М');?></span>
				<span class="radio radio2 <?php print ($profile->sex == 2 ? 'active' : "");?>" id="2"><?php echo Yii::t('app','Ж');?></span>
				<div><input name="sex" type="hidden" id="radion" value="<?php echo $profile->sex;?>" /></div>
			</li>
		</div>
    </div>
	
    <div class="personal_information phone">
		<label for="Profile_phone"><?php echo Yii::t('app','Телефон');?></label>
		<div class="input-block">
			<?php echo $form->textField($profile,'phone',array('size'=>20,'maxlength'=>20,'class'=>'text', 'placeholder'=>'+38063XXXYYYZZ')); ?>
			<?php //echo $form->error($profile,'phone'); ?>
        </div>
    </div>

    <div class="personal_information city">
		<label for="Profile_city"><?php echo Yii::t('app','Город');?></label>
		<div class="input-block">
			<?php echo $form->textField($profile,'city',array('size'=>20,'maxlength'=>20,'class'=>'text')); ?>
			<?php //echo $form->error($profile,'city'); ?>
		</div>
    </div>
    
    <div class="profile_space"></div>

    <div class="personal_information old-pass">
		<label for="oldPass"><?php echo Yii::t('app','Предыдущий пароль');?></label>
		<div class="input-block">
			<input id="oldPass" name="oldPass" class="text" type="password" />
		</div>
	</div>

    <div class="personal_information newPass">
		<label for="newPass"><?php echo Yii::t('app','Новый пароль');?></label>
		<div class="input-block">
			<input id="newPass" name="newPass" class="text" type="password" />
		</div>
	</div>

    <div class="personal_information">
		<label for="verifyPass"><?php echo Yii::t('app','Повторить');?></label>
		<div class="input-block">
			<input id="verifyPass" name="verifyPass" class="text" type="password" />
		</div>
	</div>
    
    <div class="checkboxes checkbox_news">
    	<div class="input-block">
	        <div class="check">
			  <input type="checkbox" name="refresh_mail" />
	        </div>
			<label><?php //echo Yii::t('app','Получать обновления на почту');?><?php echo Yii::t('app','Разрешаю связываться со мной с помощью e-mail') ?></label>
		</div>
	</div>
	<div style="clear:both;"></div>
    <div class="buttom_registration">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : Yii::t('app','Сохранить данные')); ?>
	</div>

<?php $this->endWidget(); ?>

<div class="spacer"></div>
</section>
