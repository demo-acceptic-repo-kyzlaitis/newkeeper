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
class Content extends NKActiveRecord
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
		return 'content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, text_ru, text_uk', 'required'),
			//array('country_id, temp, traffic', 'numerical', 'integerOnly'=>true),
			array('title_ru, title_uk, name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, title_ru, title_uk, text_ru, text_uk', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'name' => 'Имя',
			'title_en' => 'Заголовок en',
			'title_ru' => 'Заголовок ru',
			'title_uk' => 'Заголовок ua',
			'text_en' => 'Текст en',
			'text_ru' => 'Текст ru',
			'text_uk' => 'Текст ua',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('title_ru',$this->title_ru,true);
		$criteria->compare('title_uk',$this->title_uk,true);
		$criteria->compare('text_en',$this->text_en,true);
		$criteria->compare('text_ru',$this->text_ru,true);
		$criteria->compare('text_uk',$this->text_uk,true);

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
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getText()
    {
        $current = "text_".Yii::app()->language;
        return $this->$current;
    }
    
    public function getTitle()
    {
        $current = "title_".Yii::app()->language;
        return $this->$current;
    }
    
}