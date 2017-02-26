<?php

/**
 * This is the model class for table "usr_preferences".
 *
 * The followings are the available columns in table 'usr_preferences':
 * @property integer $user_id
 * @property string $lang
 * @property integer $weather_city_id
 * @property integer $traffic_city_id
 * @property integer $currency_id
 * @property integer $font_size
 * @property integer $follow_later
 */
class UserPreferences extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPreferences the static model class
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
		return 'usr_preferences';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lang, weather_city_id, traffic_city_id, currency_id, font_size, follow_later, friends_later, mobile_later', 'required'),
			array('user_id, weather_city_id, traffic_city_id, currency_id, font_size, follow_later, receive_news', 'numerical', 'integerOnly'=>true),
			array('lang', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, lang, weather_city_id, traffic_city_id, currency_id, font_size, follow_later, friends_later, mobile_later, receive_news', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'lang' => 'Lang',
			'weather_city_id' => 'Weather City',
			'traffic_city_id' => 'Traffic City',
			'currency_id' => 'Currency',
			'font_size' => 'Font Size',
			'follow_later' => 'Follow Later',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('weather_city_id',$this->weather_city_id);
		$criteria->compare('traffic_city_id',$this->traffic_city_id);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('font_size',$this->font_size);
		$criteria->compare('follow_later',$this->follow_later);
		$criteria->compare('receive_news',$this->receive_news);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}