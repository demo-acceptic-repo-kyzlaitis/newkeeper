<?php

class RecoveryController extends Controller
{
	public $defaultAction = 'recovery';
	
	/**
	 * Recovery password
	 */
	public function actionIndex () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->returnUrl);
		    } else {
				$email = ((isset($_GET['email'])) ? $_GET['email'] : '');
				$activkey = ((isset($_GET['activkey'])) ? $_GET['activkey'] : '');
				if ($email&&$activkey) {
                //var_dump($_POST);
                //var_dump($_GET);
                //exit;
					$form2 = new UserChangePassword;
		    		$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
		    		if(isset($find)&&$find->activkey==$activkey) {
			    		if(isset($_POST['UserChangePassword'])) {
							$form2->attributes=$_POST['UserChangePassword'];
							if($form2->validate()) {
								$find->password = Yii::app()->controller->module->encrypting($form2->password);
								$find->activkey=Yii::app()->controller->module->encrypting(microtime().$form2->password);
								if ($find->status==0) {
									$find->status = 1;
								}
								$find->save();
								Yii::app()->user->setFlash('recoveryMessage',UserModule::t("New password is saved."));
								$this->redirect(Yii::app()->controller->module->recoveryUrl);
							}
						}
						$this->render('changepassword',array('form'=>$form2));
		    		} else {
		    			Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
						$this->redirect(Yii::app()->controller->module->recoveryUrl);
		    		}
		    	} else {
			    	if(isset($_POST['UserRecoveryForm'])) {
			    	    $rec_data = $_POST['UserRecoveryForm'];
			    		$form->attributes=$_POST['UserRecoveryForm'];
                        
	   //CVarDumper::dump($_POST);exit();
			    		if($form->validate()) {
                            if(Yii::app()->request->isAjaxRequest){
                                echo json_encode(array(1, 'Пароль отправлен на Ваш почтовый ящик'));
                            }
                            Yii::app()->end();
			    			$user = User::model()->notsafe()->findbyPk($form->user_id);
							$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl(implode(Yii::app()->controller->module->recoveryUrl),array("activkey" => $user->activkey, "email" => $user->email));
							
							$subject = UserModule::t("You have requested the password recovery site {site_name}",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    					));
			    			$message = UserModule::t("You have requested the password recovery site {site_name}. To receive a new password, go to {activation_url}.",
			    					array(
			    						'{site_name}'=>Yii::app()->name,
			    						'{activation_url}'=>$activation_url,
			    					));
							
			    			UserModule::sendMail($user->email,$subject,$message);
			    			
							Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Password has been sent to your email."));
			    			$this->refresh();
			    		}else{
                            if (Yii::app()->request->isAjaxRequest)
                            {
                                echo json_encode(array(0, 'Введенный e-mail не найден в базе данных, повторите попытку еще раз'));
                                Yii::app()->end();
                            }
                        }
			    	}
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        $this->renderPartial('recovery',array('form'=>$form),false,false);
                        //CVarDumper::dump(Yii::app()->clientScript->scripts[CClientScript::POS_READY]['CActiveForm#team-form']);
                        //if (!empty($_POST['asDialog']))
                        echo CHtml::script('jQuery.colorbox({top:"10%",height:300,transition:"fade",speed:100,html:$("#registration").html()});
                            $(".login_registration").css("height","400px");
                        ');
                        //echo CHtml::script('js:bootbox.modal($("#registration").html());');
                    }else{
		    		    $this->render('recovery',array('form'=>$form));
                    }
                    Yii::app()->end();
		    	}
		    }
	}

}