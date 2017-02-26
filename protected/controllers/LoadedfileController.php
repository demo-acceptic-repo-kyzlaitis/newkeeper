<?php

class LoadedfileController extends Controller
{

	public function actionCreateme(){
		
		$cities = new City;
		$cities = $cities::model();
		$cities = $cities->findAll();
		foreach ($cities as $city){
			$location[$city->id] = $city->name_en;
		}
		foreach ($location as $field=>$value){
			$API_url = "http://api.worldweatheronline.com/free/v1/weather.ashx?q=".$location."&format=xml&num_of_days=1&key=rcsvmajxeyqsedyw69mvgzjj";
			$xml  = simplexml_load_file($API_url);
			$cities = new City;
			$cities = $cities::model();
			$city = $cities->findByPk($field);
			$city->temp = $xml->current_condition->temp_C;
			$city->save();
		}
	}
		
	public function actionDownloadUserList()
	{
		$model= User::model();
		$criteria = new CDbCriteria;
		$criteria->order = 'id';
        $model1 = $model->findAll($criteria); 
		$model = new Profile();	
		$criteria->order = 'user_id';
        $model2 = $model->findAll($criteria); 
        $this->render('users',array('model1'=>$model1, 'model2'=>$model2));
	}
	
	
	
	
}