<?php

class Traffic extends CWidget {

    public function run()
    {
        $city_id = Yii::app()->db->createCommand()
            ->select('id')
            ->from('city')
            ->order('name_'.Yii::app()->language)
            ->queryScalar();
        if(!Yii::app()->user->isGuest){
            $user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
            if(!is_null($user_prefs) && $user_prefs->traffic_city_id != 0){
		$city_id = $user_prefs->traffic_city_id;
            }
	}else{
            if(!isset(Yii::app()->session["traffic_city_id"])){
		Yii::app()->session["traffic_city_id"] = $city_id;
            }
            $city_id = Yii::app()->session["traffic_city_id"];
        }
        $model = City::model()->findByPk($city_id);

        echo $model->getTraffic();
    }
}