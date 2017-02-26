<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionIndex()
        {
            //CVarDumper::dump($_POST);exit();
            $mobile = false;
            if(isset($_POST['params'])){
                $mobile = true;
                $jobj = json_decode($_POST['params']);
				
                $_POST = (array)$jobj;
                foreach($_POST as $k=>$it){
                    $_POST[$k] = (array)$it;
                }
            }
            $model = new RegistrationForm;
            $profile=new Profile;
            $profile->regMode = true;
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end();
			}
			
		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm']))
                {
                	$_POST['RegistrationForm']['username'] = current(explode('@', $_POST['RegistrationForm']['email']));
                    $reg_data = $_POST['RegistrationForm'];
					$model->attributes=$_POST['RegistrationForm'];
                    $model->username = str_replace(array('.',','), '', $model->username);
                    //echo json_encode($model->username);exit;
                    $model->setToken();
					$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
					//var_dump($model);exit();
					if($model->validate() && $profile->validate())
					{
						$soucePassword = $model->password;
						$model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0;
						$model->status=((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
						
						if ($model->save()) {
							$profile->user_id=$model->id;
							$profile->save();
							if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
								Mail::send(
                                    $model->email,
                                    UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),
                                    UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url))
                                );
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for registration. Please check your e-mail to ensure that the registration process was successful."));
								}
                            if(Yii::app()->request->isAjaxRequest){
        				        echo json_encode(array(1,Yii::t("app", "Для продолжения пройдите по ссылке, которая была отправлена на Ваш имейл. Благодарим за регистрацию!")));
                                Yii::app()->end();
        				    }
                            if(isset($mobile) && $mobile == true){
                                echo "1";
                                Yii::app()->end();
                            }
								$this->refresh();                                
							}
						}
                    }else{
                        if(isset($mobile) && $mobile == true){
							print "0";
							Yii::app()->end();
                        }
                        if(Yii::app()->request->isAjaxRequest){
                            if(empty($reg_data['password']) || empty($reg_data['verifyPassword']) || empty($reg_data['email'])){
                                echo json_encode(array(0,Yii::t('app',"Необходимо заполнить все поля")));
                                Yii::app()->end();
                            }
                            if($reg_data['password'] != $reg_data['verifyPassword']){
                                echo json_encode(array(0,Yii::t('app',"Пароли не совпадают")));
                                Yii::app()->end();
                            }
                            if(strlen($reg_data['password']) < 4){
                                echo json_encode(array(0,Yii::t("app","Пароль должен состоять хотя бы из 4 символов")));
                                Yii::app()->end();
                            }
                            //echo json_encode($model->errors);exit;
        				    echo json_encode(array(0,Yii::t('app',"Такой логин или имейл уже кем-то используется")));
                            Yii::app()->end();
        				}
                        $model->validate();
                        $profile->validate();
                    }
				}else{
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        $this->renderPartial('/user/registration',array('model'=>$model),false,false);
                        //CVarDumper::dump(Yii::app()->clientScript->scripts[CClientScript::POS_READY]['CActiveForm#team-form']); 
                        //if (!empty($_POST['asDialog']))
                        /*echo CHtml::script('jQuery.colorbox({
                                                        fixed:true,
														top:"10%",
														opacity: 0.5,
														height:"450px",
														transition:"none",
														speed:100,
														onComplete: function(){
															$("#cboxOverlay").css("opacity","0.5");
                                                            $("body").css("position","fixed");
														},
														onClosed: function(){
															$("#cboxOverlay").css("opacity","1");
                                                            $("body").css("position","static");
														},
														html:$("#registration").html()});');*/
                            //echo CHtml::script('js:bootbox.modal($("#registration").html());');
                    }else{
                        //$this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
                    }
                    Yii::app()->end();
                }
		    }// end if isGuest
	}
	public function actionSuccess()
    {
        //header("refresh: 3; url=http://".$_SERVER['HTTP_HOST']);
        //$this->layout = '//layouts/main';
        //echo "Благодарим Вас за регистрацию. Проверьте свой e-mail, чтобы убедиться что регистрация прошла успешно";
        echo Yii::t("app", "Благодарим Вас за регистрацию. Проверьте свой e-mail, чтобы убедиться что регистрация прошла успешно");
    }
}