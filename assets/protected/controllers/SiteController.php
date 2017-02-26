<?php

class SiteController extends Controller
{
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
            'upload'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
            ),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
    {
        Yii::import("xupload.models.XUploadForm");
        $model = new XUploadForm;
        $this -> render('index', array('model' => $model, ));
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    $this->layout = "//layouts/column2";
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else{
			    if($error['code'] == '404')
                {
				    $this->render('error_404', $error);
                }else{
				    $this->render('error', $error);
                }
			}
            
		}
	}

	
		
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
        $this->pageTitle = 'Про нас';
        
	    $this->layout = "//layouts/column2";
		$model = Content::model()->find(array('condition'=>'name="contact"'));
        //CVarDumper::dump($model);exit();
		
        /*if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}*/
		$this->render('contact',array('content'=>$model));
	}
	public function actionTerms()
	{
	    $this->layout = "//layouts/column2";
		$model = Content::model()->find(array('condition'=>'name="terms"'));
        
		$this->render('contact',array('content'=>$model));
	}
    
	public function actionPage_with_blog_rules()
	{
	    $this->layout = "//layouts/column2";
		$model = Content::model()->find(array('condition'=>'name="page_with_blog_rules"'));
        
		$this->render('contact',array('content'=>$model));
	}
    

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionPopup($slug)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial($slug,array("0"=>'0'));
        }
        Yii::app()->end();
    }
	
	public function actionFriends()
    {
        $this->render("friends");
    }

    public function actionLater()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $field = Yii::app()->request->getPost('name')."_later";
            if(Yii::app()->user->isGuest)
            {
                Yii::app()->session[$field] = Yii::app()->request->getPost('is_later');
            }else{
                $pref = UserPreferences::model()->findByPk(Yii::app()->user->id);
                $pref->$field = Yii::app()->request->getPost('is_later');
                $pref->save();
            }
            //echo $_SERVER['HTTP_REFERER'];
        }
        //Yii::app()->end();
    }

    public function actionZoom()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $field = 'zoom';
            if(Yii::app()->user->isGuest)
            {
                Yii::app()->session[$field] = Yii::app()->request->getPost($field);
            }else{
                $pref = UserPreferences::model()->findByPk(Yii::app()->user->id);
                $pref->$field = Yii::app()->request->getPost($field);
                $pref->save();
            }
            //echo $_SERVER['HTTP_REFERER'];
        }
        //Yii::app()->end();
    }
	
    public function actionUploadava()
    {	
        $data = CGallery::uploadAva(User::PREVIEW_PATH);
        
        echo json_encode($data);
        Yii::app()->end();
    }

    public function actionClosewindow()
    {
        echo '<html><body><script>window.close()</script></body></html>';
    }
}