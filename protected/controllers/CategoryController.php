<?php

class CategoryController extends Controller
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$newsDataProvider = new CActiveDataProvider('News', array(
		  'criteria' => array(
			'condition' => 'category_id=:categoryId',
			'params' => array(':categoryId'=>$this->loadModel($id)->id),
			'order'=>'create_time DESC',
		  ),
		  /*'pagination' => array(
			'pageSize' => 5,
		  ),*/
		));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'newsDataProvider'=>$newsDataProvider,
			'cur_name' => "name_".Yii::app()->language,
			'cur_text' => "text_".Yii::app()->language,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
	    $this->layout = '//layouts/admin';
		$model=new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	    $this->layout = '//layouts/admin';
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
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
            if (Yii::app()->request->isAjaxRequest)
            {
                $dataProvider=new CActiveDataProvider('Category');
                $this->renderPartial('index', 
                    array(
                        'catDataProvider'=>$dataProvider,
                        'cur_name' => "name_".Yii::app()->language,
                    ),false,false);
                //js-code to open the dialog
                /*if (!empty($_POST['asDialog']))
                    echo CHtml::script('$.colorbox({
												top:"10%",
												opacity: 0.5,
												transition:"none",
												speed:100,
												html:$("#id_category").html(),
                                                onComplete: function(){
												    $("body").css("position","fixed");
												},
												onClosed:function(){
												    regPopup();
                                                    $("body").css("position","static");
                                                }
												});');*/
                Yii::app()->end();
            }else{
                $this->redirect('http://'.$_SERVER['HTTP_HOST']);
        		$dataProvider=new CActiveDataProvider('Category');
        		$this->render('index',array(
        			'catDataProvider'=>$dataProvider,
        			'cur_name' => "name_".Yii::app()->language,
        		));
            }
	}

	/**
	 * Lists all models.
	 */
	public function actionMythemes()
	{
        $this->pageTitle = 'Настройка тем';
		$this->layout='//layouts/column3';
		
		$catDataProvider=new CActiveDataProvider('Category',array(
            'criteria' => array(
                'join' => 'LEFT JOIN `user_category_assignment` `as` ON t.id=as.category_id',
                'distinct' => true,
            )
        ));
		$blogerDataProvider=new CActiveDataProvider('Bloger',array(
            'criteria' => array(
                'distinct' => true,
                'join' => 'LEFT JOIN `user_bloger_assignment` `as` ON t.user_id=as.bloger_id',
            )
        ));
        $summary_t = Content::model()->find(array('condition'=>'name="themes"'));
        $summary_b = Content::model()->find(array('condition'=>'name="bloggers"'));
        
		$this->render('theme',array(
			'catDataProvider'=>$catDataProvider,
            //'blogerDataProvider'=>$blogerDataProvider,
            'summary_t'=>$summary_t,
            'summary_b'=>$summary_b,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
	    $this->layout = '//layouts/admin';
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionGetids()
	{
	    $ids = array();
        $entities = Category::model()->findAll();
        foreach($entities as $item)
        {
            $ids[$item->id] = $item->name;
        }
        
	    echo json_encode($ids);
	}

	public function actionChangeid()
	{
        $model = $this->loadModel($_POST['orig_id']);
        $news = $model->news;
        
        foreach($news as $item)
        {
            $item->category_id = $_POST['target_id'];
            $item->save();
        }
        
	    echo json_encode('success');
	}

	/**
	 * Add/removes news from this category to/from users feed.
	 */
	public function actionSubscribe($id, $processOutput = false)
	{
        if (Yii::app()->request->isAjaxRequest){
            $processOutput = true;
            $model = $this->loadModel($id);
            if(Yii::app()->user->isGuest){
                if(isset(Yii::app()->session['categories']))
                    $bmarks = Yii::app()->session['categories'];
                else
                    $bmarks = array();
                if(!isset($bmarks[$model->id])){
                //if($model->isInSession('bookmarks')){
                    //$model->addToSession('bookmarks');
                    $bmarks[$model->id] = $model->id;
                    Yii::app()->session['categories'] = $bmarks;
                    echo 1;
                }else{
                    //$model->removeFromSession('bookmarks');
                    unset($bmarks[$model->id]);
                    Yii::app()->session['categories'] = $bmarks;
                    echo 0;
                }
                Yii::app()->end();
            }else{
        		if(!$model->hasUserAssigned(Yii::app()->user,'user_category_assignment','category_id')){
        			$model->assignUser(Yii::app()->user,'user_category_assignment','category_id');
                    echo 1;
        		}else{
                    $model->removeUser(Yii::app()->user,'user_category_assignment','category_id');
                    echo 0;
                }
                Yii::app()->end();
            }
        }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
