<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 */
class Category extends NKActiveRecord
{
    const PREVIEW_SIZE = 135;    
    public $image;
    
    public function behaviors()
    {
        $cols = array('name_ru');
        
        return array(
            'sluggable' => array(
                'class'=>'application.components.behaviors.SluggableBehavior',
                'columns' => $cols,
                'unique' => true,
                'update' => true,
            ),
        );
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_ru, name_uk', 'required'),
			array('name_ru, name_uk, media_source', 'length', 'max'=>255),
            //array('image', 'file', 'allowEmpty' => true,'types'=>'jpg, jpeg, gif, png','on'=>'insert'),
            //array('image', 'file', 'allowEmpty' => true,'types'=>'jpg, jpeg, gif, png','on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name_en, name_ru, name_uk, media_source, news_count', 'safe', 'on'=>'search'),
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
			'news' => array(self::HAS_MANY, 'News', 'category_id'),
			'readers' => array(self::MANY_MANY, 'User', 'user_category_assignment(category_id, user_id)'),
            'newsCount' => array(self::STAT, 'News','category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name_en' => 'Name en',
			'name_ru' => 'Название ru',
			'name_uk' => 'Название ua',
            'media_source' => 'Изображение',
		);
	}
    
    public function countSqlStr($field)
	{
        $news_table = News::model()->tableName();
        $operstat_table = StatisticsOperation::model()->tableName();
        
	    return "(SELECT SUM(os." . $field . ") FROM " . $news_table . " n LEFT JOIN " . $operstat_table . " os ON n.id = os.new_id WHERE n.category_id = t.id)";
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
        
        $news_table = News::model()->tableName();
        $news_count_sql = "(SELECT COUNT(*) FROM " . $news_table . " n where n.category_id = t.id)";
        
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

		$criteria->compare('id',$this->id);
		//$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_uk',$this->name_uk,true);
		$criteria->compare('media_source',$this->media_source,true);
        
        $sort = array(
                'multiSort'=>true,
                'defaultOrder' => 't.name_ru',
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
                    '*',
                ),
            );                

		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => $sort,
            'pagination'=>array(
                'pageSize'=> self::model()->count(),
            ),
		));
        
        $_SESSION['dataprovider'] = $dataprovider;

		$dataprovider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => $sort,
            'pagination'=>array(
                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
            ),
		));
                        
        return $dataprovider;
	}
        
    protected function beforeValidate()
    {
        $this->image = CUploadedFile::getInstance($this, 'image');
        if($this->image || empty($this->media_source)){
            $this->media_source = $this->image->name;
        }
        
        return true;
    }
    
    protected function afterSave()
    {
        parent::afterSave();
        $path = dirname(Yii::app()->request->scriptFile).'/uploads/preview/'.$this->image->name;
        if(!file_exists($path))
            $this->image->saveAs($path);
            
        if(strpos($this->media_source,'thumb') !== false){
            $file = str_replace('thumb','tmp',$this->media_source); 
        }else{
            $file = 'tmp/'.$this->media_source;
        }
        $tmppath = News::PREVIEW_PATH.$file;
        //var_dump($tmppath);exit;
        
        if(file_exists($tmppath) && !is_dir($tmppath)){
            if (!copy($tmppath, News::PREVIEW_PATH.$this->media_source)) {
                echo "не удалось скопировать $tmppath...\n";
            }
            unlink($tmppath);
        }
    }
    
    public function getName($lang=false)
    {
        $current = "name_".Yii::app()->language;
        if($lang)
            $current = "name_ru";
        return $this->$current;
    }

    public function previewThumb($size = self::PREVIEW_SIZE)
	{
	   return CGallery::thumb_span($this->media_source,'uploads/preview',$size,$size,array(),true);
    }

    public function adminThumb($size = self::PREVIEW_SIZE)
	{
	   return CGallery::thumb_span($this->media_source,'uploads/preview',$size,$size,array('style'=>'display: block;'),true);
    }

    public function getGalleryCount()
	{
	   return $this->news;
    }
    
    function __toString()
    {
        return $this->getName();
    }
}