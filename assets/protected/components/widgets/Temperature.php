<?php

class Temperature extends CWidget {

    public function run()
    {
        $city_id = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('city')
                    ->order('name_'.Yii::app()->language)
                    ->queryScalar();
        if(!Yii::app()->user->isGuest){
            $user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
            if(!is_null($user_prefs)){
                $city_id = $user_prefs->weather_city_id;
            }else{
                $user_prefs = new UserPreferences();
                $user_prefs->weather_city_id = $city_id;
                $user_prefs->user_id = Yii::app()->user->id;
                $user_prefs->save();
            }
	   }else{
            if(!isset(Yii::app()->session["weather_city_id"])){
		      Yii::app()->session["weather_city_id"] = $city_id;
            }
            $city_id = Yii::app()->session["weather_city_id"];
        }
        //var_dump($city);exit;
        $model = City::model()->findByPk($city_id);

        echo $model->getTemperature();
    }
}