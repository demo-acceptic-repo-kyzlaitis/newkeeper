<?php

class NewsController extends Controller
{
	public static $searchRes = array();
	public static $searchInd;
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	private $_category = null;/*
    
	public function actions()
	{
		return array(
	        'upload'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
            ),
            'connector' => array(
                'class' => 'elfinder.ElFinderConnectorAction',
                'settings' => array(
                    'root' => Yii::getPathOfAlias('webroot') . '/uploads/',
                    'URL' => Yii::app()->baseUrl . '/uploads/',
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none'
                )
            ),
		);
	}*/

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
		//	'accessControl', // perform access control for CRUD operations
        	'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	    /*$all = Category::model()->findAll();
        foreach($all as $item)
        {
            $item->save();
        }*/

        if (isset($_GET['news_popup'])) {
            $this->redirect(array(
                '/#' . $_GET['news_popup']
            ));
        }


        $this->pageTitle = 'Лента новостей';
	    $this->processPageRequest('page');
       
		$dataProvider = new CActiveDataProvider('News',array(
            'criteria'=>array(
                'limit'=>'0',
                'order'=>'create_time DESC',
                'condition'=>'status=1',
            ),
            'pagination'=>array(
                'pageSize'=>9,
                'pageVar' =>'page',
            ),
        ));
        
        $this->processPageResponse(array(
    	    'dataProvider'=>$dataProvider,
   		));
	}
    
    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param])) {
			$_GET[$param] = Yii::app()->request->getPost($param);

			//dd($_GET);
		}
    }
    
    protected function processPageResponse($params = array())
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_loopAjax', $params);
            Yii::app()->end();
        } else {
    		$this->render('index',$params);
        }
    }
	
	public function actionFreeSearch()
    {
        $model = new News('search');
        $this->render('freeSearch',array('model'=>$model));
    }

	public function actionSendFile()
	{
        $model = $this->loadModel($_GET['id']);
        $image_path = NKHelper::createTextImg($model);

		//$image_path = 'http://' . $_SERVER['HTTP_HOST'] . '/' . News::DOWNLOADPATH . $model->slug . '.png';

        Yii::app()->getRequest()->sendFile($model->slug . '.png', file_get_contents($image_path));
	}

    public function actionSendshow($id)
    {
        $this->layout = '//layouts/plain';
        $model = $this->loadModel($_GET['id']);
        $image_path = NKHelper::createTextImg($model);

        //$image_path = 'http://' . $_SERVER['HTTP_HOST'] . '/' . News::DOWNLOADPATH . $model->slug . '.png';

        $this->render('sendfile', array('image_path'=>$image_path));
    }

    public function actionSearchEngine()
    {
		if (isset($_POST['keyword'])) {
			$keyword = $_POST['keyword'];
            $page = isset($_POST['page'])?$_POST['page']:0;
            $model = new News();
            $model->unsetAttributes();  // clear any default values
            $results = $model->freeSearch($keyword, $page);
    //dd($results->getData());
            if ($results->getData() != array()){
                $this->renderPartial("_loopAjax",array("dataProvider" => $results,"search"=>"search"));
            } else {
                echo '';
            }

            /*else
                switch (Yii::app()->language){
                    case "en": print json_encode(array("0"=>"Search have no results")); break;
                    case "ru": print json_encode(array("1"=>"Поиск не дал результатов")); break;
                    case "uk": print json_encode(array("2"=>"Пошук не дав результатів")); break;
                }*/
        }
	}

	public function actionMynews()
	{
        $this->pageTitle = 'Мой набор новостей';
	    $this->processPageRequest('page');

        $dataProvider = NKHelper::getMynewsProvider();
        
        $this->processPageResponse(array(
    	    'dataProvider'=>$dataProvider,
   		));
	}

	/**
	 * Lists news bookmarked by user.
	 */
	public function actionBookmarks()
	{
        $this->pageTitle = 'Закладки';
	    $this->processPageRequest('page');
        $this->layout='//layouts/column3';
        $dataProvider = NKHelper::getBkmrkProvider();
        $content = Content::model()->find('name="empty_bookmark"');        
        
        $this->processPageResponse(array(
    	    'dataProvider' => $dataProvider,
            'empty_text' =>  '<div class="empty_bookmark_title">' . $content->getTitle() . '</div>' . $content->getText(),
   		));
	}

	/**
	 * Lists news added by bloger.
	 */
	public function actionBlog($slug)
	{
        $this->pageTitle = 'Блог';
	    $this->layout='//layouts/column2';
	    $this->processPageRequest('page');
        
	    $alien = true;// if it isn't current user's blog
        $bloger = Bloger::model()->findByAttributes(array('slug'=>$slug));
        if($bloger->id == Yii::app()->user->id && $bloger->status == 1){
            $this->layout='//layouts/column3';
            $alien = false;
        }
        $dataProvider = NKHelper::getBlogProvider($bloger->id);
        
        $this->processPageResponse(array(
    	    'dataProvider'=>$dataProvider,
            'bloger'=>$bloger,
            'blog'=>true,
            'alien'=>$alien,
   		));
	}

	/**
	 * Lists news from category.
	 */
	public function actionCategory($slug)
	{
        $this->processPageRequest('page');

        $cat = Category::model()->findByAttributes(array('slug' => $slug));
        $this->pageTitle = $cat->getName();
		$dataProvider=new CActiveDataProvider('News', array(
			'criteria' => array(
                'join' => 'LEFT JOIN news_category_assignment nca ON t.id = nca.news_id',
				'condition' => 'nca.category_id=:categoryId',
				'params' => array(':categoryId' => $cat->id),
				'order'=>'create_time DESC',
			),
			'pagination'=>array(
				'pageSize'=>9,
				'pageVar' =>'page',
			),
		));
        
        $this->processPageResponse(array(
    	    'dataProvider'=>$dataProvider,
   		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($slug)
	{
	    $model = News::model()->findByAttributes(array('slug'=>substr($slug,5)));
        NKHelper::viewStatistics($model->id);

        if(!is_object(Yii::app()->user) || Yii::app()->user->isGuest){
            $size = (isset(Yii::app()->session['font']) ? Yii::app()->session['font'] : 16);
        }else{
    	    $model_userpref = UserPreferences::model()->findbyPk(Yii::app()->user->id);
            $size = $model_userpref->font_size;
        }
        
        $model->renewContentIfNotFixed();
        
        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('view',
                array(
                    'model'=>$model,
                    'font_size'=>$size,
                ));
			//echo NKHelper::newsPopupScript(); // open in colorbox
        }else{
            $dataProvider = new CActiveDataProvider('News');
            $this->render('index',array(
		        'dataProvider'=>$dataProvider,
    		    'popup_id'=>$model->id,
            ));
	    }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $this->pageTitle = 'Создание новости';
	    //if(isset($_GET['blog'])){
            $blog = 1;
            $this->layout = '//layouts/column3';
        //}else{
        //    $blog = 0;
            //$this->layout = '//layouts/admin';
        //}
    	    
		$model=new News;
        $categories = Category::model()->findAll();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
			$model->attributes=$_POST['News'];
            $model->blog = $blog;
			if($model->save())
                if($blog)
                {
                    $slug = User::model()->findByPk($model->author_id)->bloger->slug;
                    $this->redirect(array(
                        'news/blog/' . $slug
                    ));
                }
                else
                    $this->redirect(array('update','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
            'categories' => $categories,
            'blog' => $blog,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
	    if(isset($_GET['blog'])){
            $blog = 1;
        }else{
            $blog = 0;
        }
        
	    if(!$blog)
    	    $this->layout = '//layouts/admin';
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['News']))
		{		 
			$model->attributes=$_POST['News'];
            $model->blog = $blog;
			if($model->save()){
                if($blog)
                    $this->redirect(array('news/update/blog','id'=>$model->id));
                else
                    $this->redirect(array('update','id'=>$model->id));
            }
            
		}

		$this->render('update',array(
			'model' => $model,
            'blog' => $blog,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        //var_dump('adsfasd');exit;
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
	    $this->layout = '//layouts/admin';
		$model = new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
            'status'=>News::STATUS_PUBLISHED,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdminblog()
	{
	    $this->layout = '//layouts/admin';
		$model = new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];
            
        //CVarDumper::dump($model->attributes);exit;

		$this->render('admin',array(
			'model'=>$model,
            'status'=>News::STATUS_NOT_APPROVED,
		));
	}

	public function actionAdminhide()
	{
	    $this->layout = '//layouts/admin';
		$model = new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];
            
        //CVarDumper::dump($model->attributes);exit;

		$this->render('admin',array(
			'model'=>$model,
            'status'=>News::STATUS_DISABLED,
		));
	}

	public function actionBookmark($id)
	{
		$model = $this->loadModel($id);
        if(Yii::app()->user->isGuest){
            echo $model->getBkmrkResponse($id);
		}else{
            echo $model->getBkmrkResponseAuth($id);
		}
		NKHelper::bookmarkStat($id);
	}

    public function actionSharecount($id)
    {
        $model = $this->loadModel($id);
        if (!$model->statistic) {
            $stat = new StatisticsOperation();
            $stat->new_id = $id;
            $stat->save();
            $model->statistic = $stat;
        }
        echo $model->statistic->getSharesCount();
    }

    public function actionRss($network = 'fb')
    {
		$this->layout = '';
        FeedHelper::getFeed($network);
        Yii::app()->end;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return News the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param News $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionShareStat()
	{
		echo NKHelper::shareStat($_POST['id'], $_POST['soc']);
	}

	public function actionDownloadStat()
	{
	    echo NKHelper::downloadStat($_POST['id']);
	}
	
    public function actionUpload()
    {	
        $data = CGallery::uploadNews(News::PREVIEW_PATH);
        
        echo json_encode($data);
        Yii::app()->end();
    }
	
    public function actionCrop()
    {
        //var_dump($_POST);exit;
        $data = CGallery::crop(News::PREVIEW_PATH, News::PREVIEW_SIZE);
        //$previewname = Thumb::crop('/' . News::PREVIEW_PATH . $_POST['file_name']);
        CGallery::moveAfterCrop($data['previewname'], News::PREVIEW_PATH);
        
        echo json_encode($data);
    }
    
    public function actionFileupload()
    {
        switch($_POST['blog']){
            case 1: $this->renderPartial('_blog_upload_popup');break;
            case 0: $this->renderPartial('_adm_upload_popup');break;
        }
    }
    
    public function actionTmpremove()
    {
        //$file = str_replace('thumb','tmp',$this->preview_source);
        $tmppath = substr($_POST['path'],1);//News::PREVIEW_PATH.$file;
        
        if(file_exists($tmppath)){
            unlink($tmppath);
        }
    }
    
    public function actionTranslite()
    {
        $str = Yii::app()->request->getParam('str');
        echo CGallery::ruslat($str);
    }
    
    public function actionPublish()
    {
	    if (Yii::app()->request->isAjaxRequest)
        {
            $ids = Yii::app()->request->getPost('ids');
            
            News::model()->updateByPk($ids,array('status'=>News::STATUS_PUBLISHED));
            
            Yii::app()->end();
        }
    }
    
    public function actionUnpublish()
    {
	    if (Yii::app()->request->isAjaxRequest)
        {
            $ids = Yii::app()->request->getPost('ids');
            
            News::model()->updateByPk($ids,array('status'=>News::STATUS_DISABLED));
            
            Yii::app()->end();
        }
    }
    
    public function actionProcessing()
    {
	    if (Yii::app()->request->isAjaxRequest)
        {
            $ids = Yii::app()->request->getPost('ids');
            
            News::model()->updateByPk($ids,array('status'=>News::STATUS_NOT_APPROVED));
            
            Yii::app()->end();
        }
    }
    
    public function actionImgpath()
    {
        $id = substr($_POST['id'],2);
        //$model = News::model()->findByPk($id);
        $model = $this->loadModel((int)$id);
        echo $model->preview_source;
    }
    
    public function actionReadFromSource()
    {
    	$src = Yii::app()->request->getPost('source');
    	$article = NKHelper::readability($src);
            
        echo json_encode(array(
        	'title' => $article['title'],
        	'text' => $article['text'],
        ));
        exit;
    }
}