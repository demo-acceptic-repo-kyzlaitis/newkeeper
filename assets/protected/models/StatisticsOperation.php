<?php

/**
 * This is the model class for table "statistics_operation".
 *
 * The followings are the available columns in table 'statistics_operation':
 * @property integer $new_id
 * @property integer $
 * @property integer $
 * @property integer $views_count
 */
class StatisticsOperation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatisticsOperation the static model class
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
		return 'statistics_operation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	
	function AfterSave(){
		$data = new StatisticsDay;
		$data = StatisticsDay::model()->findByPk($this->new_id);
		if ($data){
			if($data->today != date("d-m-Y")){
				$data->views_count = 1;
				$data->today = date("d-m-Y");
				$data->save();
			}else{
				$data->views_count++;
				$data->save();
			}
		}else{
			$data = new StatisticsDay;
			$data->new_id = $this->new_id;
			$data->views_count++;
			$data->today = date("d-m-Y");
			$data->save();
		}
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('new_id,  views_count', 'required'),
			array('new_id,  views_count', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('new_id,  views_count', 'safe', 'on'=>'search'),
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
			'new_id' => 'New',
			'views_count' => 'Views',
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

		$criteria->compare('new_id',$this->new_id);
		$criteria->compare('views_count',$this->views_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getSharesCount()
    {
        return $this->shares_gp_count + $this->shares_vk_count + $this->shares_tw_count + $this->shares_fb_count;
    }
}