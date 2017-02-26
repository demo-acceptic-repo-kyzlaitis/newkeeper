<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column3';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionMale()
	{
		if (isset($_POST['male']) && !empty($_POST['male'])){
			$profile = User::model()->findByPk(Yii::app()->user->id)->profile;
			$profile->sex = $_POST['male'];
			$profile->save();
			die("have male: ".$profile->sex);
		}
	}
	
	public function actionEdit()
	{
        $this->pageTitle = 'Редактирование профиля';
		//die(var_dump($_POST));
		$model = $this->loadUser();
		$profile=$model->profile;
        $find = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->bloger->attributes=$_POST['Bloger'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate() && $profile->validate()) {
				$model->save();
				$profile->save();
				if($model->bloger && $model->bloger->validate())
                	$model->bloger->save();
                //Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',Yii::t("app","Изменения внесены"));
				//$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}
        
        if(isset($_POST['oldPass']) && !empty($_POST['oldPass'])) {
            $oldMd = Yii::app()->controller->module->encrypting($_POST['oldPass']);
            //var_dump($_POST['oldPass'], $find->password, $oldMd);exit;
            if($find->password == $oldMd) {
                if(!empty($_POST['newPass']) && strlen($_POST['newPass'])>=4){
                    if($_POST['newPass'] == $_POST['verifyPass']){
                        $newMd = Yii::app()->controller->module->encrypting($_POST['newPass']);
                        $find->password = $newMd;
        				$find->activkey = Yii::app()->controller->module->encrypting(microtime().$newMd);
        				if ($find->status==0) {
        					$find->status = 1;
        				}
        				if($find->save())
            				Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Новый пароль сохранен"));
                    }else{
                        Yii::app()->user->setFlash('profileMessage',UserModule::t("Пароли не совпадают"));
                    }
                }else{
                    Yii::app()->user->setFlash('profileMessage',Yii::t("app","Пароль должен состоять хотя бы из 4 символов"));
                }
			}else{
			    Yii::app()->user->setFlash('profileMessage',Yii::t("app","Старый пароль неверный"));
			}
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		
		return $this->_model;
	}
	
    public function actionUpload()
    {
        $file_save = CGallery::upload(News::PREVIEW_PATH);
        
        echo $file_save;
    }
	
    public function actionCrop()
    {
        $data = CGallery::crop(User::PREVIEW_PATH, User::PREVIEW_SIZE);
        
        $model = $this->loadUser();
        $model->profile->avatar_source = $data['previewname'];
        $model->profile->save();
        
        CGallery::moveAfterCrop($data['previewname'], User::PREVIEW_PATH);
        
		echo json_encode($data);
    }
    
    function actionFileupload()
    {
        $this->renderPartial('_ava_upload_popup');
    }
}