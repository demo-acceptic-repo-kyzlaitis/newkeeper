<?php

class UserController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
    //public $layout = '//layouts/admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
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
				'actions'=>array('index','view','confirm_fb','font','getfriends', 'checklogged'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	    $this->layout='//layouts/column3';
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANNED,
		    ),
				
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	public function actionChecklogged()
	{
		echo (int)!Yii::app()->user->isGuest;
        Yii::app()->end();
	}
    
    public function actionFont($sign)
	{
	    if(Yii::app()->user->isGuest){
	        if(!isset(Yii::app()->session['font'])){
	           Yii::app()->session['font'] = 16;
	        }
            $size = Yii::app()->session['font'];
            switch($sign){
                case '1': if($size<19)$size++;break;
                case '0': if($size>13)$size--;break;
            }
            Yii::app()->session['font'] = $size;
            echo Yii::app()->session['font'];
	    }else{
	        $model = UserPreferences::model()->findbyPk(Yii::app()->user->id);
            $size = $model->font_size;
            switch($sign){
                case '1': if($size<19)$size++;break;
                case '0': if($size>13)$size--;break;
            }
            $model->font_size = $size;
            $model->save();
            echo $model->font_size;
	    }
	}
	
	public function actionGetFriends()
	{
		if( $curl = curl_init() ) {
			curl_setopt($curl, CURLOPT_URL, 'http://facebook.com/100003244043082/friendlists');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "100003244043082");
			$out = curl_exec($curl);
			echo var_dump($out);
			curl_close($curl);
		}
	}
}