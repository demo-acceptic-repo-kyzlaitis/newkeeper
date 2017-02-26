<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $lang
 * @property string $name_ru
 * @property string $name_en
 * @property string $name_uk
 * @property string $slug
 * @property integer $author_id
 * @property integer $category_id
 * @property integer $type_id
 * @property string $source
 * @property string $media_source
 * @property string $video_src
 * @property string $preview_source
 * @property string $teaser_ru
 * @property string $teaser_en
 * @property string $teaser_uk
 * @property string $text_ru
 * @property string $text_en
 * @property string $text_uk
 * @property integer $fb_pub
 * @property integer $tw_pub
 * @property integer $vk_pub
 * @property integer $gp_pub
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $hot
 * @property integer $blog
 * @property integer $fixed
 * @property integer $status
 */
class News extends NKActiveRecord
{
	const TYPE_PHOTO = 0;
	const TYPE_VIDEO = 1;
    
	const STATUS_DISABLED = 0;
	const STATUS_PUBLISHED = 1;
	const STATUS_NOT_APPROVED = 2;
        
    const UNBMARKED = 0;
    const BMARKED = 1;
        
    const MARK_TAG = "<span class='news_bookmark'></span>";
    const ADDED_STR = "Новость отмечена как непрочитанная и занесена в соответствующий раздел";
//Новость занесена<br />в список непрочитанных<br />новостей;
    const DEL_STR = "Новость удалена из списка непрочитанных новостей";//"Новость отмечена<br />как прочитанная и убрана<br />из соответствующего раздела";
    
    const PREVIEW_SIZE = 612;
    const PREVIEW_PATH = "uploads/preview/";
	const DOWNLOADPATH = 'uploads/preview/thumb2/';
    const PREVIEW_WEIGHT = 20000000;
    //const PREVIEW_FORM_SIZE = 282;
        
    public $image;
    public $preview;
    public $blog;
    public $categories_id = array();
    
    public function behaviors()
    {
        $name = 'name_ru';
        if(!strlen(trim($this->$name)))
            $name = 'name_en';
        if(!strlen(trim($this->$name)))
            $name = 'name_uk';
        //dd($this->attributes);
        return array(
            'sluggable' => array(
                'class'=>'application.components.behaviors.SluggableBehavior',
                'columns' => array($name),
                'unique' => true,
                'update' => true,
            ),
        );
    }
    
    public function countSqlStr($field)
	{
        $news_table = News::model()->tableName();
        $operstat_table = StatisticsOperation::model()->tableName();
        
	    return "(SELECT os." . $field . " FROM " . $news_table . " n LEFT JOIN " . $operstat_table . " os ON n.id = os.new_id WHERE n.id = t.id)";
    }
    
    public function countDaySqlStr($field)
	{
        $news_table = News::model()->tableName();
        $operstat_table = StatisticsDay::model()->tableName();
        
	    return "(SELECT os." . $field . " 
        FROM " . $news_table . " n 
        LEFT JOIN " . $operstat_table . " os ON n.id = os.new_id 
        WHERE n.id = t.id AND today = '" . date('d-m-Y') . "')";
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	
    public function search($status = false)
	{
	    //CVarDumper::dump($this->statistic);exit();
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
        
        if($status !== false)
            $criteria->condition = 'status='.$status;
        
        $criteria->select = array(
            '*',
            $this->countDaySqlStr('views_count') . " as day_views_count",
            $this->countSqlStr('views_count') . " as views_count",
            $this->countSqlStr('bookmarks_count') . " as bookmarks_count",
            $this->countSqlStr('downloads_count') . " as downloads_count",
            $this->countSqlStr('shares_gp_count') . " as shares_gp_count",
            $this->countSqlStr('shares_vk_count') . " as shares_vk_count",
            $this->countSqlStr('shares_tw_count') . " as shares_tw_count",
            $this->countSqlStr('shares_fb_count') . " as shares_fb_count",
            $this->countSqlStr('shares_gp_count + os.shares_vk_count + os.shares_tw_count + os.shares_fb_count') . " as shares_total_count",
        );
        $criteria->compare($this->countSqlStr('day_views_count'), $this->day_views_count);
        $criteria->compare($this->countSqlStr('views_count'), $this->views_count);
        $criteria->compare($this->countSqlStr('bookmarks_count'), $this->bookmarks_count);
        $criteria->compare($this->countSqlStr('downloads_count'), $this->downloads_count);
        $criteria->compare($this->countSqlStr('shares_gp_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_vk_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_tw_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_fb_count'), $this->shares_gp_count);
        $criteria->compare($this->countSqlStr('shares_gp_count + os.shares_vk_count + os.shares_tw_count + os.shares_fb_count'), $this->shares_total_count);
        
		$criteria->compare('id',$this->id);
		$criteria->compare('lang',$this->lang);
		$criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_uk',$this->name_uk,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('category_id',$this->category_id/*,true*/);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('media_source',$this->media_source,true);
		$criteria->compare('video_src',$this->video_src,true);
		$criteria->compare('preview_source',$this->preview_source,true);
		$criteria->compare('teaser_ru',$this->teaser_ru,true);
		$criteria->compare('teaser_en',$this->teaser_uk,true);
		$criteria->compare('teaser_uk',$this->teaser_uk,true);
		$criteria->compare('text_ru',$this->text_ru,true);
		$criteria->compare('text_en',$this->text_en,true);
		$criteria->compare('text_uk',$this->text_uk,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('hot',$this->hot,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('blog',$this->blog,true);
        
        $sort = array(
                'multiSort'=>true,
                'defaultOrder' => 't.create_time DESC',
                'attributes' => array(
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
                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
            ),
		));
        
		$_SESSION['dataprovider'] = $dataprovider;
        
        return $dataprovider;
	}
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('', 'required'),
			array('author_id, hot, lang, fixed, status', 'numerical', 'integerOnly'=>true),
			array('name_en, name_ru, name_uk, teaser_en, teaser_ru, teaser_uk, source, media_source, video_src, preview_source, slug', 'length', 'max'=>255),
			array('hot, lang, blog, fixed, status, ru, en, uk', 'length', 'max'=>1),
			//array('preview', 'file', 'types'=>'jpg, jpeg, gif, png','on'=>'insert'),
			//array('image, preview', 'file', 'allowEmpty' => true,'types'=>'jpg, jpeg, gif, png','on'=>'insert'),
            //array('image, preview', 'file', 'allowEmpty' => true,'types'=>'jpg, jpeg, gif, png','on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('text_en, text_ru, text_uk', 'safe', 'on'=>'update'),
			array('id, name_en, name_ru, name_uk, author_id, category_id, type_id, source, hot, lang, status', 'safe', 'on'=>'search'),
			//array('id, name_en, name_ru, name_uk, author_id, category_id, type_id, source, hot, lang, status', 'safe', 'on'=>'adminSearch'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'categories' => array(self::MANY_MANY, 'Category', 'news_category_assignment(news_id, category_id)'),
			'bookmarkers' => array(self::MANY_MANY, 'User', 'user_news_bookmark(news_id, user_id)'),
            'statistic' => array(self::HAS_ONE, 'StatisticsOperation', 'new_id'),
            'statistic_day' => array(self::HAS_ONE, 'StatisticsDay', 'new_id'),
			'newsCount' => array(self::STAT, 'News','category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		
	//Yii::t('app','model.person
		return array(
			'id' => 'ID',
			'lang' => 'Язык',
			'name_en' => Yii::t('app','Заголовок') . ' <span class="leng">en</span>',
			'name_ru' => Yii::t('app','Заголовок'),
			//'name_ru' => Yii::t('app','Заголовок') . ' <span class="leng">ru</span>',
			'name_uk' => Yii::t('app','Заголовок') . ' <span class="leng">ua</span>',
			'author_id' => Yii::t('app','Автор'),
			'category_id' => Yii::t('app','Категория'),
			'categories_id' => Yii::t('app','Категории'),
			'type_id' => Yii::t('app','Тип'),
			'source' => Yii::t('app','Источник'),
			'media_source' => Yii::t('app','Media Source'),
            'video_src' => Yii::t('app','Видео-источник'),
			'preview_source' => Yii::t('app','Превью'),
			'teaser_en' => Yii::t('app','Анонс <span class="leng">en</span>'),
			'teaser_ru' => Yii::t('app','Анонс <span class="leng">ru</span>'),
			'teaser_uk' => Yii::t('app','Анонс <span class="leng">ua</span>'),
			'text_en' => Yii::t('app','Текст <span class="leng">en</span>'),
			//'text_ru' => Yii::t('app','Текст <span class="leng">ru</span>'),
			'text_ru' => Yii::t('app','Текст'),
			'text_uk' => Yii::t('app','Текст <span class="leng">ua</span>'),
			'fb_pub' => Yii::t('app','Опубликовать в facebook'),
			'tw_pub' => Yii::t('app','Опубликовать в twitter'),
			'vk_pub' => Yii::t('app','Опубликовать в Вконтакте'),
			'gp_pub' => Yii::t('app','Опубликовать в google+'),
			'create_time' => Yii::t('app','Время создания'),
			'update_time' => Yii::t('app','Время обновления'),
			'hot' => Yii::t('app','Горячая'),
			'blog' => Yii::t('app','Блог'),
			'fixed' => Yii::t('app','Больше не обновлять'),
            'status' => Yii::t('app','Статус'),
            'views_count' => Yii::t('app','Просмотров'),
            'bookmarks_count' => Yii::t('app','Подписок'),
            'downloads_count' => Yii::t('app','Скачано'),
            'shares_gp_count' => 'g+',
            'shares_vk_count' => 'vk',
            'shares_tw_count' => 'tw',
            'shares_fb_count' => 'fb',
		);
	}
	
	public function freeSearch($keyword, $page = 0)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('name_en',$keyword, true, 'OR');
		$criteria->compare('name_ru',$keyword, true, 'OR');
		$criteria->compare('name_uk',$keyword, true, 'OR');
		$criteria->compare('teaser_uk',$keyword, true, 'OR');
		$criteria->compare('teaser_ru',$keyword, true, 'OR');
		//$criteria->compare('teaser_en',$keyword, true, 'OR');
		$criteria->compare('text_ru',$keyword, true, 'OR');
		//$criteria->compare('text_en',$keyword, true, 'OR');
		$criteria->compare('text_uk',$keyword, true, 'OR');

        $criteria->order = 'create_time DESC';
        $criteria->limit = 9;
        $criteria->offset = 9 * $page;
		
		return new CActiveDataProvider("News", array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
	}
    
    public function getBkmrkResponse($id)
    {
        if(!isset(Yii::app()->session['bookmarks']))
            Yii::app()->session['bookmarks'] = array();
        $bmarks = Yii::app()->session['bookmarks'];
        if(!isset($bmarks[$this->id])){
            $bmarks[$this->id] = $this->id;
            Yii::app()->session['bookmarks'] = $bmarks;
            
            return $this->getBookmarkHtmlInJson(self::BMARKED);
        }else{
            $this->sessionStatBkmrk($id);
		    unset($bmarks[$this->id]);
            Yii::app()->session['bookmarks'] = $bmarks;
            
            return $this->getBookmarkHtmlInJson(self::UNBMARKED);
        }
    }

    public function getBkmrkResponseAuth($id)
    {
        if(!$this->hasUserAssigned(Yii::app()->user,'user_news_bookmark','news_id')){
            $this->assignUser(Yii::app()->user,'user_news_bookmark','news_id');
            return $this->getBookmarkHtmlInJson(self::BMARKED);
        }else{
			$this->sessionStatBkmrk($id);
            $this->removeUser(Yii::app()->user,'user_news_bookmark','news_id');
            
            return $this->getBookmarkHtmlInJson(self::UNBMARKED);
        }
    }
    
    public function sessionStatBkmrk($id)
    {
		if (empty(Yii::app()->session['bookmarked'])){
			Yii::app()->session['bookmarked'] = array();
			$ses = Yii::app()->session['bookmarked'];
			array_push($ses,$id);
			Yii::app()->session['bookmarked'] = $ses;
		}else{
			$ses = Yii::app()->session['bookmarked'];
			$ind = in_array($id,$ses);
			if (!$ind){
				array_push($ses,$id);
				Yii::app()->session['bookmarked'] = $ses;
			}
        }
    }

	public function getTypes()
	{
        return array(
		  self::TYPE_PHOTO => Yii::t('app','Фото'),
		  self::TYPE_VIDEO => Yii::t('app','Видео'),
        );
	}

	static public function getStatuses()
	{
        return array(
		  self::STATUS_PUBLISHED => Yii::t('app','Опубликована'),
		  self::STATUS_DISABLED => Yii::t('app','Отклонена'),
		  self::STATUS_NOT_APPROVED => Yii::t('app','Обрабатывается'),
        );
	}

	public function getStatus()
	{
	    $statuses = self::getStatuses();
        return $statuses[$this->status];
	}

	static public function getStatusTitles()
	{
      return array(
		self::STATUS_PUBLISHED => Yii::t('app','Опубликованные новости'),
		self::STATUS_DISABLED => Yii::t('app','Неопубликованные новости'),
		self::STATUS_NOT_APPROVED => Yii::t('app','Новости, ожидающие подтверждения'),
      );
	}

	public function getLangs()
	{
        return array(
		  parent::LANG_EN => 'en',
		  parent::LANG_RU => 'ru',
		  parent::LANG_UA => 'uk',
        );
	}
    
    public function getType()
	{
	    $types = $this->getTypes();
        
        return $types[$this->type_id];
	}
    
    public function isHot()
	{
	    $yn = array(
		  1 => 'yes',
		  0 => 'no',
        );
        return $yn[$this->hot];
	}
        
    public function getCategories()
    {
        return Category::model()->findAll();
    }
        
    public function getCategoryName()
    {
        return Category::model()->findByPk($this->category_id);
    }
        
    public function getBlogers()
    {
        return Bloger::model()->with('user')->findAll();
    }
        
    public function getDate()
    {
        $ru_month = array( 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' );
        $uk_month = array( 'січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня' );
        $en_month = array( 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december' );
        
        $month = strtolower(date("F",$this->create_time));
        
        switch(Yii::app()->language){
            case "ru": $month = str_replace( $en_month, $ru_month, $month );break;
            case "uk": $month = str_replace( $en_month, $uk_month, $month );break;
        }

        $date_str = date("j",$this->create_time)." ".$month.", ".date("H:i",$this->create_time);
        return $date_str;
    }
        
    public function getBookmarkHtmlInJson($t)
    {
        switch($t){
            case self::BMARKED: $out = json_encode(array(self::MARK_TAG,self::ADDED_STR,$this->getStatBkmrk()));break;
            case self::UNBMARKED: $out = json_encode(array("",self::DEL_STR,$this->getStatBkmrk()));break;
        }
        return $out;
    }
        
    public function getStatBkmrk()
    {
		if ((isset($this->statistic->bookmarks_count)) && (!empty($this->statistic->bookmarks_count)))
			return $this->statistic->bookmarks_count;
		else 
			return 0;
    }
        
    public function getPopupslug()
    {
        return 'news_' . $this->slug;
    }
        
    public function getName()
    {
        /*$langs = $this->getLangs();
        if(isset($langs[$this->lang])){
            $current = "name_".$langs[$this->lang];
        }else{
            $current = "name_".Yii::app()->language;
        }*/

        return $this->name_ru;
    }
        
    public function setName($val)
    {
        /*$langs = $this->getLangs();
        if(isset($langs[$this->lang])){
            $current = "name_".$langs[$this->lang];
            $this->$current = $val;
        }else{
            return false;
        }*/
        $current = "name_ru";
        $this->$current = $val;
    }
        
    public function setNames($val)
    {
        if($this->ru){
            $this->name_ru = $val;
        }
        if($this->uk){
            $this->name_uk = $val;
        }
    }
        
    public function getTeaserOrTitle($lang = null)
    {
        //$name = "name_".Yii::app()->language;
        $teaser = "teaser_".Yii::app()->language;
        //if ($lang)
          //  $teaser = "teaser_".$lang;
        //dd($teaser);
        
        return (strlen($this->$teaser)>0 ? $this->$teaser : $this->name_ru);
        //return $this->$current;
    }
        
    public function getText()
    {
        /*$langs = $this->getLangs();
        if(isset($langs[$this->lang])){
            $current = "text_".$langs[$this->lang];
        }else{
            $current = "text_".Yii::app()->language;
        }*/

        return $this->text_ru;
    }
        
    public function setText($val)
    {
        /*$langs = $this->getLangs();
        if(isset($langs[$this->lang])){
            $current = "text_".$langs[$this->lang];
            //var_dump($current);exit;
            $this->$current = $val;
        }else{
            return false;
        }*/
        $current = "text_ru";
        $this->$current = preg_replace('/\<[\/]{0,1}div[^\>]*\>/i', '', $val);

        //dd($val);
    }
        
    public function setTexts($val)
    {
        if($this->ru){
            $this->text_ru = $val;
        }
        if($this->uk){
            $this->text_uk = $val;
        }
    }
    
    public function isPhotoType()
    {
        return $this->type_id == self::TYPE_PHOTO ? true : false;
    }
    
    public function getEmbedVideo()
    {
        $video_url = $this->video_src;
        $pos = strpos($video_url,'&');
        if(!$pos)
            $pos = strlen($video_url);
        $url_cut = substr($video_url,0,$pos);
        
        return $embed_url = str_replace("watch?v=", "embed/", $url_cut);
    }
    
    public function previewThumb($size = self::PREVIEW_SIZE)
	{
	    //return CGallery::thumb_span($this->preview_source,'uploads/preview',$size,$size,$options = array('class'=>'preview'),CGallery::SQUARE);
        if (strlen($this->preview_source) > 0) {
            return CHtml::image('/uploads/preview/'.$this->preview_source,'',array('class'=>'news_preview'));
        } else {
            return CHtml::image('/images/default.png','',array('class'=>'news_preview'));
        }
    }
    
    public function imageThumb($size = self::PREVIEW_SIZE)
	{
	    //return CGallery::thumb_span($this->media_source,'uploads/preview',$size,$size,$options = array('class'=>'preview'),"",true);
        
        return CHtml::image('/uploads/preview'.$this->media_source);
    }
    
    public function preview($size)
	{
	    return CHtml::image('/uploads/preview/' . CGallery::thumbnailNameX($this->preview_source,'uploads/preview',$size,$size));
       
       //return CHtml::image('/uploads/preview/thumb/'.CGallery::thumbnailName($this->media_source,'uploads/preview',$size,$size));
    }
    
    public function retrieveContent()
    {//var_dump((!empty($this->source) && (!$this->fixed || $this->isNewRecord) && !$this->blog));exit;
        if(!empty($this->source) && (!$this->fixed || $this->isNewRecord) && !$this->blog){
            $article = NKHelper::readability($this->source);
       //dd($article['text']);

            //if($this->isNewRecord)
            	$this->setName($article['title']);

            //if($this->isNewRecord)
                $this->setText($article['text']);
            //dd($this->text_ru);
            if ($this->isNewRecord && $this->fixed) {
                $this->setName($_POST["NewsAdmin"]["name_ru"]);
                $this->setText($_POST["NewsAdmin"]["text_ru"]);
            }
        }
    }
    
    public function renewContentIfNotFixed()
    {
        if(!$this->fixed)
            $this->save();
    }
        
    protected function beforeValidate()
    {
        if($this->getIsNewRecord())
            $this->create_time = time();
        $this->update_time = time();
        
        if(empty($this->author_id))
            $this->author_id = Yii::app()->user->id;
            
        /*$this->image = CUploadedFile::getInstance($this, 'image');
        if(!empty($this->image->name)){
            $this->media_source = $this->image->name;
        }*/
        
        $this->preview = CUploadedFile::getInstance($this, 'preview');
        if(!empty($this->preview)){
            $this->preview_source = $this->preview->name;
        }

        return true;
    }

    protected function beforeSave()
    {
        parent::beforeSave();
        $this->retrieveContent();
        //dd($this->attributes);
        if($this->getIsNewRecord()){
            if($this->blog && !$this->author->bloger->tried)
                $this->status = self::STATUS_NOT_APPROVED;
            else
                $this->status = self::STATUS_PUBLISHED;
        }
        //var_dump($this->preview_source);exit;
        return true;
    }
    
    protected function afterSave()
    {
        parent::afterSave();
        
        if(strpos($this->preview_source,'thumb') !== false){
            $file = str_replace('thumb','tmp',$this->preview_source); 
        }else{
            $file = 'tmp/'.$this->preview_source;
        }
        $tmppath = News::PREVIEW_PATH.$file;
        //var_dump($tmppath);exit;
        
        if(file_exists($tmppath) && !is_dir($tmppath)){
            if (!copy($tmppath, News::PREVIEW_PATH.$this->preview_source)) {
                echo "не удалось скопировать $tmppath...\n";
            }
            unlink($tmppath);
        }
//var_dump($this->setIsNewRecord(false));exit;
		$this->setIsNewRecord(false);
		DBHelper::saveManyMany($this, 'News');
        
        /*if(!empty($this->image)){
            $path = dirname(Yii::app()->request->scriptFile).'/uploads/preview/'.$this->image->name;
            //CVarDumper::dump($path);exit;
            if(!file_exists($path))
            $this->image->saveAs($path);
        }*/
          
        /*if(!empty($this->preview)){
            $path_preview = dirname(Yii::app()->request->scriptFile).'/uploads/preview/'.$this->preview->name;
            if(!file_exists($path_preview))
            $this->preview->saveAs($path_preview);
        }*/
        
    }
}