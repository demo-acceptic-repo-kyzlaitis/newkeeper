<?php

class CropperController extends Controller
{
    public $layout = '//layouts/column3';
    
	public function Croppy($arr){
		$this->render('crop',$arr);
	}

	public function actionDelete()
    {
		$model = User::model();
		$model = $model->findByPk(Yii::app()->user->id)->profile;
		$model->avatar_source = "avatar_no_avatar.jpg";
		$model->save();
		$this->redirect("/user/profile/edit");
	}

	public function actionCrop()
    {
        //CVarDumper::dump(Yii::app()->getRequest()->getPost('engine'));exit();
		$arr['x'] = Yii::app()->getRequest()->getPost('x');
		$arr['y'] = Yii::app()->getRequest()->getPost('y');
		$arr['w'] = Yii::app()->getRequest()->getPost('w');
		$arr['h'] = Yii::app()->getRequest()->getPost('h');
		$arr['engine'] = Yii::app()->getRequest()->getPost('engine');
		$arr['type'] = Yii::app()->getRequest()->getPost('type');
		$arr['id'] = Yii::app()->getRequest()->getPost('id');
        //var_dump($arr['id']);exit();
		$arr['file_save'] = Yii::app()->getRequest()->getPost('file_save');
		if (isset($arr['h'])){
			$arr['header'] = "cropped";
		}
		$this->render('crop',$arr);
	}

	public function actionCreate()
    {
	    //CVarDumper::dump($_GET);exit();
	    $obj = User::model()->findByPk(Yii::app()->user->id);
		$model= new LoadedFile;
		if (isset($_FILES["LoadedFile"]["name"]["image"]) && (!empty($_FILES["LoadedFile"]["name"]["image"]))){
            $file = CUploadedFile::getInstance($model,'image');
		    $this->Croppy(array('header'=>'avatars_file_user','file'=>$file,'id'=>Yii::app()->user->id));
        }else{
            $this->render('create', array('model'=>$model,'user'=>$obj));
        }
	}

	public function actionCreateimage($id = 0)
    {
	    $this->layout = '//layouts/admin';
	    //CVarDumper::dump($_GET);exit();
        if($id == 0){
            $obj = new News;
        }else{
	       $obj = News::model()->findByPk($id);
        }
		$model= new LoadedFile;
		if (isset($_FILES["LoadedFile"]["name"]["image"]) && (!empty($_FILES["LoadedFile"]["name"]["image"]))){
            $file = CUploadedFile::getInstance($model,'image');
		    $this->Croppy(array('header'=>'preview_file_image','file'=>$file,'id'=>$id));
        }else{
            $this->render('create', array('model'=>$model,'news'=>$obj,'type'=>'image'));
        }
	}

	public function actionCreateprev($id = 0)
    {
	    $this->layout = '//layouts/admin';
        if($id == 0){
            $obj = new News;
        }else{
	       $obj = News::model()->findByPk($id);
        }
		$model= new LoadedFile;
		if (isset($_FILES["LoadedFile"]["name"]["image"]) && (!empty($_FILES["LoadedFile"]["name"]["image"]))){
            $file = CUploadedFile::getInstance($model,'image');
		    $this->Croppy(array('header'=>'preview_file_preview','file'=>$file,'id'=>$id));
        }else{
            $this->render('create', array('model'=>$model,'news'=>$obj,'type'=>'preview'));
        }
	}

	public function actionDoit($params)
    {
		//$model = User::model();
        //var_dump($params);exit();
        $dec = json_decode($params);
		switch($dec->type){
		    case 'user': $data = User::model()->findByPk($dec->id)->profile;
            			 $data->avatar_source = $dec->file_save;
            			 $data->save();
                         header( "refresh:1.5;url=/user/profile/edit" );
                         break;
            case 'image':$data = News::model()->findByPk($dec->id);
                         if(!$data){
                             $data = new News;
                         }
            			 $data->media_source = $dec->file_save;
                         //CVarDumper::dump($data);exit();
            			 $data->save(false); 
		                 header( "refresh:1.5;url=/news/update/".$dec->id );
                         break;
            case 'preview': $data = News::model()->findByPk($dec->id);
                         if(!$data){
                             $data = new News;
                         }
            			 $data->preview_source = $dec->file_save;
            			 $data->save(); 
		                 header( "refresh:1.5;url=/news/update/".$dec->id );
                         break;
		}
	}
}