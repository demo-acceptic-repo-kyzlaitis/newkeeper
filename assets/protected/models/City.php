<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_uk
 * @property integer $country_id
 * temp
 * traffic
 */
class City extends NKActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'city';
	}
	
	public function defaultScope()
	{
        $parent = parent::scopes();
        
		$scopes = array(
			'order' => 'name_' . Yii::app()->language . ' ASC',
		);
		
		return array_merge($parent, $scopes);
	}
    
    function scopes()
    {
        $parent = parent::scopes();
        
        $scopes = array(
            'active'=>array(
                'condition' => 'status = 1',
            ),
            'traffic'=>array(
                'condition' => 'LENGTH(traffic) > 0',
            ),
        );
		
		return array_merge($parent, $scopes);
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_en, name_ru, name_uk, country_id, code_yahoo', 'required'),
			array('country_id, temp, traffic, status', 'numerical', 'integerOnly'=>true),
			array('lat, lng', 'match', 'pattern'=>'/^[0-9]+(.[0-9]+)*$/'),
			array('name_en, name_ru, name_uk', 'length', 'max'=>255),
			//array('text_temp', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name_en, name_ru, name_uk, country_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'country' => array(self::BELONGS_TO, 'NetCountry', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name_en' => 'Имя en',
			'name_ru' => 'Имя ru',
			'name_uk' => 'Имя uk',
			'country_id' => 'Страна',
			'temp' => 'Температура',
			'traffic' => 'Трафик',
			'status' => 'Статус',
			'code_yahoo' => 'Code Yahoo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_uk',$this->name_uk,true);
		$criteria->compare('country_id',$this->country_id);

		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'multiSort'=>true,
            ),
            'pagination'=>array(
                'pageSize'=> 1000000000000,
            ),
		));
        
		$_SESSION['dataprovider'] = $dataprovider;
        
		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'multiSort'=>true,
            ),
            'pagination'=>array(
                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
            ),
		));
        
        return $dataprovider;
	}
        
        public function getName()
        {
            $cur_name = "name_".Yii::app()->language;
            return $this->$cur_name;
        }
        
        public function getTemperature()
        {
            $this->assignTemperature();
            $sign = ($this->temp < 0 ? "" : "+");
            return $sign.$this->temp."&deg;";
        }
        
        public function getTraffic()
        {
            $this->assignTraffic();
            return $this->traffic;
        }
        
        public function assignTemperature()
        {
            if(Yii::app()->user->isGuest){
                Yii::app()->session["weather_city_id"] = $this->id;
            }else{
                $user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
                if(is_null($user_prefs)){
                    $user_prefs = new UserPreferences;
                    //$user_prefs = $prefs::model();
                    $user_prefs->user_id = Yii::app()->user->id;
                }
                $user_prefs->weather_city_id = $this->id;
                $user_prefs->save();
            }
        }
        
        public function assignTraffic()
        {
            if(Yii::app()->user->isGuest){
                Yii::app()->session["traffic_city_id"] = $this->id;
            }else{
                $user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
                if(is_null($user_prefs)){
                    $user_prefs = new UserPreferences;
                    //$user_prefs = $prefs::model();
                    $user_prefs->user_id = Yii::app()->user->id;
                }
                $user_prefs->traffic_city_id = $this->id;
                $user_prefs->save();
            }
        }
        
        public function getCountries()
        {
            return NetCountry::model()->findAll(array("order"=>"name_ru"));
        }
		
		public function setWeather($value, $city_id)
		{
			$city = City::model()->findByPk($city_id);
			if ((isset($city->temp)) && (!empty($city->temp))){
				$city->temp = $value;
				$city->save();
			}
		}
		
		public function setTraffic($value, $city_id)
		{
			$city = City::model()->findByPk($city_id);
			if ((isset($city->traffic)) && (!empty($city->traffic))){
				$city->traffic = $value;
				$city->save();
			}
		}

	static public function getStatuses()
	{
        return array(
		//  self::STATUS_PUBLISHED => 'Активен',
		//  self::STATUS_DISABLED => 'Неактивен',
        );
	}

	public function getStatus()
	{
	    $statuses = self::getStatuses();
        return $statuses[$this->status];
	}
}