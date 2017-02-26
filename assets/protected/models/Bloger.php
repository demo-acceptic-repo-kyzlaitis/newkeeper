<?php

/**
 * This is the model class for table "bloger".
 *
 * The followings are the available columns in table 'bloger':
 * @property integer $user_id
 * @property string $pen_name_en
 * @property string $pen_name_ru
 * @property string $pen_name_uk
 * @property string $phone
 * @property string $description_en
 * @property string $description_ru
 * @property string $description_uk
 * @property string $tried
 * @property string $journalist
 * @property string $status
 */
class Bloger extends NKActiveRecord
{
	const STATUS_ACTIVE = 1;
    const STATUS_UNACTIVE = 0;
	const STATUS_PROCESSING = 2;
    
    public $adminka = 0;
    
    public function behaviors()
    {
        $cols = array('pen_name_en');
        
        return array(
            'sluggable' => array(
                'class'=>'application.components.behaviors.SluggableBehavior',
                'columns' => $cols,
                'unique' => true,
                'update' => true,
            ),
        );
    }

    protected function beforeSave()
    {
        parent::beforeSave();
        if(empty($this->pen_name_en))
            $this->pen_name_en = $this->transliterate($this->getPenName());
        
        return true;
    }

	static public function getStatuses()
	{
      return array(
		self::STATUS_ACTIVE => 'Активен',
		self::STATUS_UNACTIVE => 'Неактивен',
		self::STATUS_PROCESSING => 'В процессе обработки',
      );
	}

	static public function getStatusTitles()
	{
      return array(
		self::STATUS_ACTIVE => 'Активные блоггеры',
		self::STATUS_UNACTIVE => 'Неактивные блоггеры',
		self::STATUS_PROCESSING => 'Неподтвержденные блоггеры',
      );
	}
    
    public function getId()
	{
        return $this->user_id;
	}
    
    public function getStatusTitle()
	{
	    $titles = self::getStatuses();
        return $titles[$this->status];
	}
        
    public function getPenName()
    {
        $cur_pname = "pen_name_".Yii::app()->language;
        $pname = $this->$cur_pname;   
        if(empty($pname))
            $pname = $this->user->getFullName();
            
        return $pname;
    }
        
    public function getDescription($lang = false)
    {
        $i18n = array(
            'en'=>'en',
            'ru'=>'ru',
            'ua'=>'uk',
        );
        if(isset($i18n[$lang])){
            $current = "description_".$i18n[$lang];
        }else{
            $current = "description_".Yii::app()->language;
        }
        return $this->$current;
    }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bloger the static model class
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
		return 'bloger';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, phone', 'required'),
			array('user_id, tried, journalist, status, adminka', 'numerical', 'integerOnly'=>true),
			array('pen_name_en, pen_name_ru, pen_name_uk, phone, slug', 'length', 'max'=>255),
			array('description_en, description_ru, description_uk', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, pen_name_en, pen_name_ru, pen_name_uk, slug, phone, description_en, description_ru, description_uk, tried, journalist, status, news_count', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, "User", "user_id"),
            'readers' => array(self::MANY_MANY, 'User', 'user_bloger_assignment(bloger_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'Пользователь',
			'pen_name_en' => Yii::t('app','Имя / Псевдоним'),
			'pen_name_ru' => Yii::t('app','Псевдоним')." [ru]",
			'pen_name_uk' => Yii::t('app','Псевдоним')." [ua]",
			'phone' => Yii::t('app','Телефон'),
			'description_en' => Yii::t('app','Резюме'),
			'description_ru' => Yii::t('app','Описание').' [ru]',
			'description_uk' => Yii::t('app','Описание').' [ua]',
			'tried' => Yii::t('app','Проверенный'),
			'journalist' => 'Пишущий журналист',
			'status' => 'Статус',/*
            'news_count' => 'Количество публикаций',
            'bookmarks_count' => 'Количество закладок',
            'downloads_count' => 'Количество скачек',
            'shares_gp_count' => 'google+ шары',
            'shares_vk_count' => 'vk шары',
            'shares_tw_count' => 'twitter шары',
            'shares_fb_count' => 'facebook шары',
            'shares_total_count' => 'Общее количество шар',*/
		);
	}

    public function getAttributeLabel($name)
    {
        $labels = $this->attributeLabels();
        if(array_key_exists($name."_".Yii::app()->language, $labels))
            return $labels[$name."_".Yii::app()->language];
        else
            return $labels[$name];
    }
    
    public function countSqlStr($field)
	{
        $news_table = News::model()->tableName();
        $operstat_table = StatisticsOperation::model()->tableName();
        
	    return "(SELECT SUM(os." . $field . ") FROM " . $news_table . " n LEFT JOIN " . $operstat_table . " os ON n.id = os.new_id WHERE n.author_id = t.user_id)";
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($status = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        
        if($status !== false)
            $criteria->condition = 'status='.$status;
        
        $news_table = News::model()->tableName();
        $news_count_sql = "(SELECT COUNT(*) FROM " . $news_table . " n WHERE n.author_id = t.user_id)";
        
        $criteria->select = array(
            '*',
            $news_count_sql . " as news_count",
            $this->countSqlStr('views_count') . " as views_count",
            $this->countSqlStr('bookmarks_count') . " as bookmarks_count",
            $this->countSqlStr('downloads_count') . " as downloads_count",
            $this->countSqlStr('shares_gp_count') . " as shares_gp_count",
            $this->countSqlStr('shares_vk_count') . " as shares_vk_count",
            $this->countSqlStr('shares_tw_count') . " as shares_tw_count",
            $this->countSqlStr('shares_fb_count') . " as shares_fb_count",
            $this->countSqlStr('shares_gp_count + os.shares_vk_count + os.shares_tw_count + os.shares_fb_count') . " as shares_total_count",
        );
        
        $criteria->compare($news_count_sql, $this->news_count);
        $criteria->compare($this->countSqlStr('views_count'), $this->views_count);
        $criteria->compare($this->countSqlStr('bookmarks_count'), $this->bookmarks_count);
        $criteria->compare($this->countSqlStr('downloads_count'), $this->downloads_count);
        $criteria->compare($this->countSqlStr('shares_gp_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_vk_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_tw_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_fb_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_gp_count + os.shares_vk_count + os.shares_tw_count + os.shares_fb_count'), $this->shares_total_count);

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('pen_name_en',$this->pen_name_en,true);
		$criteria->compare('pen_name_ru',$this->pen_name_ru,true);
		$criteria->compare('pen_name_uk',$this->pen_name_uk,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('description_en',$this->description_en,true);
		$criteria->compare('description_ru',$this->description_ru,true);
		$criteria->compare('description_uk',$this->description_uk,true);
		$criteria->compare('tried',$this->tried,true);
		$criteria->compare('status',$this->status,true);
        
        $sort = array(
                'multiSort'=>true,
                'defaultOrder' => 't.pen_name_ru',
                'attributes' => array(
                    //...
                    // order by
                    'news_count' => array(
                        'asc' => 'news_count ASC',
                        'desc' => 'news_count DESC',
                    ),
                    'views_count' => array(
                        'asc' => 'views_count ASC',
                        'desc' => 'views_count DESC',
                    ),
                    'bookmarks_count' => array(
                        'asc' => 'bookmarks_count ASC',
                        'desc' => 'bookmarks_count DESC',
                    ),
                    'downloads_count' => array(
                        'asc' => 'downloads_count ASC',
                        'desc' => 'downloads_count DESC',
                    ),
                    'shares_gp_count' => array(
                        'asc' => 'shares_gp_count ASC',
                        'desc' => 'shares_gp_count DESC',
                    ),
                    'shares_vk_count' => array(
                        'asc' => 'shares_gp_count ASC',
                        'desc' => 'shares_gp_count DESC',
                    ),
                    'shares_tw_count' => array(
                        'asc' => 'shares_gp_count ASC',
                        'desc' => 'shares_gp_count DESC',
                    ),
                    'shares_fb_count' => array(
                        'asc' => 'shares_gp_count ASC',
                        'desc' => 'shares_gp_count DESC',
                    ),
                    'shares_total_count' => array(
                        'asc' => 'shares_total_count ASC',
                        'desc' => 'shares_total_count DESC',
                    ),
                ),
            );

		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => $sort,
            'pagination'=>array(
                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
            ),            
		));
        
        $_SESSION['dataprovider'] = $dataprovider;
        
        return $dataprovider;
	}

    protected function beforeValidate()
    {
        if(empty($this->user_id) && $this->adminka != 1)
            $this->user_id = Yii::app()->user->id;
        
        return true;
    }

    protected function afterSave()
    {
        $authorizer = Yii::app()->getModule("rights")->getAuthorizer();
        if($this->status == self::STATUS_ACTIVE){
            $authorizer->authManager->assign('bloger', $this->user_id);
        }else{
            $authorizer->authManager->revoke('bloger', $this->user_id);
        }
        
        return true;
    }
    
    function transliterate($st)
    {
      $st = strtr($st, 
    
        "абвгдежзийклмнопрстуфыэАБВГДЕЖЗИЙКЛМНОПРСТУФЫЭ",
    
        "abvgdegziyklmnoprstufieABVGDEGZIYKLMNOPRSTUFIE"
    
      );
    
      $st = strtr($st, array(
    
        'ё'=>"yo",    'х'=>"h",  'ц'=>"ts",  'ч'=>"ch", 'ш'=>"sh",  
    
        'щ'=>"shch",  'ъ'=>'',   'ь'=>'',    'ю'=>"yu", 'я'=>"ya",
    
        'Ё'=>"Yo",    'Х'=>"H",  'Ц'=>"Ts",  'Ч'=>"Ch", 'Ш'=>"Sh",
    
        'Щ'=>"Shch",  'Ъ'=>'',   'Ь'=>'',    'Ю'=>"Yu", 'Я'=>"Ya",
    
      ));
    
      return $st;
    
    }
}