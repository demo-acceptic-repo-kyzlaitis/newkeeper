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
class Setting extends NKActiveRecord
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
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category, key, value, title', 'required'),
			array('key, title', 'length', 'max'=>255),
            array('category', 'length', 'max'=>63),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category, key, value', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'category' => 'Category',
			'key' => 'Key',
			'value' => 'Value',
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('title',$this->title,true);

		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'multiSort'=>true,
            ),
            'pagination'=>array(
                'pageSize'=> 10000000,
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
    
    function beforeSave()
    {
        parent::beforeSave();
        
        if(!unserialize($this->value))
        {
            $this->value = strtr($this->value, array('http://' => ''));
            $this->value = serialize($this->value);
        }
        
        return true;
    }
    
}