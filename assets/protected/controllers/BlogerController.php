<?php

class BlogerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            'rights',
//			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','subscribe','blogerdesc','request'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($slug)
	{
		$this->render('view',array(
			'model' => Bloger::model()->findByAttributes(array('slug'=>$slug)),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	    $this->layout='//layouts/admin';
		$model = new Bloger;
            $users = User::model()->findAll(array(
                'select' => 'id, username',
				'condition' => 'user.id NOT IN (SELECT user_id FROM bloger)',
            ));
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bloger']))
		{
			$model->attributes=$_POST['Bloger'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->user_id));
		}
		$this->render('create',array(
			'model'=>$model,
            'users'=>$users,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRequest()
	{
        $this->layout='//layouts/column3';
        $model = Bloger::model()->findByPk(Yii::app()->user->id);
		if(is_null($model)){
            $model = new Bloger;
        }else if(!is_null($model) && $model->status == Bloger::STATUS_ACTIVE){
            $this->redirect(array('news/blog/' . $model->slug));
        }
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bloger']))
		{
			$model->attributes=$_POST['Bloger'];
            $model->status = Bloger::STATUS_PROCESSING;
			if($model->save()){
				$usr = User::model()->findByPk(Yii::app()->user->id);
				$blg_login = $usr->username;
				$usr = Profile::model()->findByPk(Yii::app()->user->id);
				$blg_name = $usr->first_name_ru;
				$blg_lastname = $usr->last_name_ru;
				UserModule::sendMail(Yii::app()->params['adminEmail'],"Новый блоггер News Keeper","Пользователь подал заявку в блоггеры: <br>Логин: $blg_login<br>Имя: $blg_name<br>Фамилия: $blg_lastname");
				$this->redirect(array('request'));
			}
		}
        $summary = Content::model()->find(array('condition'=>'name="blogger_request"'));
        $summary_s = Content::model()->find(array('condition'=>'name="request_success"'));
        $summary_r = Content::model()->find(array('condition'=>'name="blogger_register"'));

		$this->render('request',array(
			'model'=>$model,
            'summary'=>$summary,
            'summary_s'=>$summary_s,
            'summary_r'=>$summary_r,
		));
	}
    
    public function actionUnrequest()
    {
        $model = Bloger::model()->findByPk(Yii::app()->user->id);
        $model->status = Bloger::STATUS_UNACTIVE;
        $model->save();
        $this->redirect(array('request'));
    }
        
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	    $this->layout='//layouts/admin';
		$model=$this->loadModel($id);
        $users = User::model()->findAll(array(
            'select' => 'id, username',
            'condition' => 'user.id NOT IN (SELECT user_id FROM bloger)',
        ));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bloger']))
		{
			$model->attributes=$_POST['Bloger'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->user_id));
		}

		$this->render('update',array(
			'model'=>$model,
            'users'=>$users,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $this->pageTitle = 'Блогеры';

	    $this->layout = '//layouts/column1';
		$dataProvider = new CActiveDataProvider('Bloger');/*, array(
			'criteria' => array(
                                'distinct' => true,
				'join' => ' LEFT JOIN `usr_user` `usr` ON t.category_id=as1.category_id LEFT JOIN `user_bloger_assignment` `as2` ON t.author_id=as2.user_id',
				'condition' => 'as1.user_id=:userId OR as2.user_id=:userId',
				'params' => array(':userId' => Yii::app()->user->id),
			),
                )*///);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'cur_pname' => "pen_name_".Yii::app()->language,
			'cur_description' => "description_".Yii::app()->language,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionInfo($slug)
	{
	    $this->layout = '//layouts/column1';
		$dataProvider = new CActiveDataProvider('Bloger');
		$model = Bloger::model()->findByAttributes(array('slug'=>$slug));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'cur_pname' => "pen_name_".Yii::app()->language,
			'cur_description' => "description_".Yii::app()->language,
			'id' => $model->user_id,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
	    $this->layout = '//layouts/admin';
		$model=new Bloger('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bloger']))
			$model->attributes=$_GET['Bloger'];

		$this->render('admin',array(
			'model'=>$model,
            'status'=>Bloger::STATUS_ACTIVE,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdminrequest()
	{
	    $this->layout = '//layouts/admin';
		$model=new Bloger('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bloger']))
			$model->attributes=$_GET['Bloger'];

		$this->render('admin',array(
			'model'=>$model,
            'status'=>Bloger::STATUS_PROCESSING,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdminunactive()
	{
	    $this->layout = '//layouts/admin';
		$model=new Bloger('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bloger']))
			$model->attributes=$_GET['Bloger'];

		$this->render('admin',array(
			'model'=>$model,
            'status'=>Bloger::STATUS_UNACTIVE,
		));
	}

	/**
	 * Adds/removes news of this bloger to/from users feed.
	 */
	public function actionSubscribe($id)
	{
            $model = $this->loadModel($id);
            if(Yii::app()->user->isGuest){
                if(!($bmarks = Yii::app()->session['blogers']))
                    $bmarks = array();
                if(!isset($bmarks[$model->user_id])){
                //if($model->isInSession('bookmarks')){
                    //$model->addToSession('bookmarks');
                    $bmarks[$model->user_id] = $model->user_id;
                    Yii::app()->session['blogers'] = $bmarks;
                    echo "Отписаться";
                }else{
                    //$model->removeFromSession('bookmarks');
                    unset($bmarks[$model->user_id]);
                    Yii::app()->session['blogers'] = $bmarks;
                    echo "Подписаться";
                }
            }else{
		if(!$model->hasUserAssigned(Yii::app()->user,'user_bloger_assignment','bloger_id','user_id')){
			$model->assignUser(Yii::app()->user,'user_bloger_assignment','bloger_id','user_id');
                        echo "Отписаться";
		}else{
                    $model->removeUser(Yii::app()->user,'user_bloger_assignment','bloger_id','user_id');
                        echo "Подписаться";
                }
            }
	}
	public function actionBlogerdesc($id)
	{
            $model = $this->loadModel($id);
            echo $model->getDescription($_POST['lang']);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bloger the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bloger::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bloger $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bloger-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionActivate()
    {
	    if (Yii::app()->request->isAjaxRequest)
        {
            $ids = Yii::app()->request->getPost('ids');
            
            Bloger::model()->updateByPk($ids,array('status'=>Bloger::STATUS_ACTIVE));
            
            Yii::app()->end();
        }
    }
    
    public function actionDeactivate()
    {
	    if (Yii::app()->request->isAjaxRequest)
        {
            $ids = Yii::app()->request->getPost('ids');
            
            Bloger::model()->updateByPk($ids,array('status'=>Bloger::STATUS_UNACTIVE));
            
            Yii::app()->end();
        }
    }
    
    public function actionProcessing()
    {
	    if (Yii::app()->request->isAjaxRequest)
        {
            $ids = Yii::app()->request->getPost('ids');
            
            Bloger::model()->updateByPk($ids,array('status'=>Bloger::STATUS_PROCESSING));
            
            Yii::app()->end();
        }
    }
}
