<?php

class DefaultController extends YAdminController
{

    /**
     * Вывод списка моделей для администрования
     * 
     * @access public
     * @return void
     */
	public function actionIndex()
	{
	    $this->redirect('/yiiadmin/manageModel/list?model_name=NewsAdmin');
		$this->render('index',array(
            'title'=>YiiadminModule::t('Администрирование'),
            'models'=>$this->module->modelsList,
        ));
        
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

    public function actionLogin()
    {
       	$model=Yii::createComponent('LoginForm');
        if(Yii::app()->getModule('user')->isWithHighPermissions()){
		    $_POST['LoginForm']['password'] = '123123';
        }else{
            $this->redirect('/');
        }
	
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect('/yiiadmin');
		}
		// display the login form
		$this->render('noaccess',array('model'=>$model,'title'=>YiiadminModule::t('Вход')));
    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirect(Yii::app()->createUrl('yiiadmin'));
	}
}
