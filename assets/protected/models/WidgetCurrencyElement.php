<?php

/**
 * This is the model class for table "widget_currency_element".
 *
 * The followings are the available columns in table 'widget_currency_element':
 * @property integer $id
 * @property string $name
 * @property string $buy
 * @property string $sale
 * @property string $symbol
 */
class WidgetCurrencyElement extends NKActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WidgetCurrencyElement the static model class
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
		return 'widget_currency_element';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, buy, sale', 'required'),
			array('name, symbol', 'length', 'max'=>255),
			array('buy, sale', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, buy, sale', 'safe', 'on'=>'search'),
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
			'name' => 'Наименование',
			'buy' => 'Покупка',
			'sale' => 'Продажа',
			'symbol' => 'Символ',
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
		$criteria->compare('buy',$this->buy,true);
		$criteria->compare('sale',$this->sale,true);
		$criteria->compare('symbol',$this->symbol,true);

		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        
        $_SESSION['dataprovider'] = $dataprovider;
        return $dataprovider;
	}
        
        public function getCurrency()
        {
            $this->assignCurrency();
            return $out = array($this->symbol.$this->buy,$this->symbol.$this->sale);
        }
        
        private function assignCurrency()
        {
            if(Yii::app()->user->isGuest){
                Yii::app()->session["currency_id"] = $this->id;
            }else{
                $user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
                if(is_null($user_prefs)){
                    $user_prefs = new UserPreferences;
                    //$user_prefs = $prefs::model();
                    $user_prefs->user_id = Yii::app()->user->id;
                }
                $user_prefs->currency_id = $this->id;
                $user_prefs->save();
            }
        }
        
        public static function getAssignedCurrencyId()
        {
            $currency_id = Yii::app()->db->createCommand()
                ->select('id')
                ->from('widget_currency_element')
                //->order('showorder')
                ->queryScalar();
            if(!Yii::app()->user->isGuest){
                $user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
                if(!is_null($user_prefs) && $user_prefs->currency_id != 0){
                    $currency_id = $user_prefs->currency_id;
                }
            }else{
                if(!isset(Yii::app()->session["currency_id"])){
                    Yii::app()->session["currency_id"] = $currency_id;
                }
                $currency_id = Yii::app()->session["currency_id"];
            }
            return $currency_id;
        }
}