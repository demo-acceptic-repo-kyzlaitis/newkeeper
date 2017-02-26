<?php

class User extends NKActiveRecord
{
	const STATUS_NOACTIVE=1;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
    
    const PREVIEW_SIZE = 100;
    const PREVIEW_PATH = "uploads/avatars/";
    
    public $avatar;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $created
     * @var timestamp $lastvisit_at
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 
	protected function afterDelete(){
    parent::afterDelete();
    $model = Profile::model()->findByPk($this->id);
    $model->delete();
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
            array('token','length','max'=>255),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			//array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
            array('created', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at,api_login_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('email, superuser, status', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, created, lastvisit_at, superuser, status, id_fb, token', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('email', 'required'),
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			//array('id_fb', 'id_fb'),
            array('token','length','max'=>255),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}
    
    public function rulesAdmin()
	{
        return array(
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
            array('token','length','max'=>255),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			//array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
            array('created', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at,api_login_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('email, superuser, status', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, created, lastvisit_at, superuser, status, id_fb, token', 'safe', 'on'=>'search'),
        );
   }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile'])){
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        }
        $relations['publications'] = array(self::HAS_MANY, 'News', 'author_id');
		$relations['bookmarks'] = array(self::MANY_MANY, 'News', 'user_news_bookmark(user_id, news_id)');
		$relations['categories'] = array(self::MANY_MANY, 'Category', 'user_category_assignment(user_id, category_id)');
		$relations['bloger'] = array(self::HAS_ONE, 'Bloger', 'user_id');//can be a bloger
		$relations['preferences'] = array(self::HAS_ONE, 'UserPreferences', 'user_id');
		$relations['blogers'] = array(self::MANY_MANY, 'Bloger', 'user_bloger_assignment(user_id, bloger_id)');
        
        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>'Имя пользователя',
			'password'=>Yii::t("app","Пароль"),
			'verifyPassword'=>UserModule::t("Retype"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => 'Дата регистрации',
			'created' => 'Дата регистрации',
			'id_fb' => UserModule::t("id_fb"),
			'lastvisit_at' => 'Последний визит',
			'superuser' => 'Супер-пользователь',
			'status' => 'Статус',
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, created, lastvisit_at, superuser, status, id_fb, token',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.created, user.lastvisit_at, user.superuser, user.status, user.id_fb, user.token',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
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
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('created',$this->created);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
		$criteria->compare('id_fb',$this->id_fb);
        /*
        $sort = new CSort();
        $sort->attributes = array(
        '_fullName'=>array(
            'asc'=>'(SELECT CONCAT(first_name_ru,last_name_ru) as full_name FROM usr_profiles p
                    WHERE p.user_id = t.id) ASC',
            'desc'=>'(SELECT CONCAT(first_name_ru,last_name_ru) as full_name FROM usr_profiles p
                    WHERE p.user_id = t.id) DESC',
            ),
            '*', // add all of the other columns as sortable   
        );*/
        $dataprovider = new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=> 1000000000000,
            ),
        ));
        
		$_SESSION['dataprovider'] = $dataprovider;
        
        $dataprovider = new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            //'sort'=>$sort,
        	'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
        ));
        
        return $dataprovider;
    }

    public function getCreatetime() {
        return strtotime($this->created);
    }

    public function setCreatetime($value) {
        $this->created=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }

    public function setApiLoginAt() {
        $this->api_login_at=date('Y-m-d H:i:s');
    }

    public function setToken(){
        $this->token = md5(time().rand(1000,9999) . $this->password);
    }
    
    public function getFullName($br=false, $lang=false)
    {
        if(!$lang)
        {
            $fname_lang = "first_name_".Yii::app()->language;
            $lname_lang = "last_name_".Yii::app()->language;
        }else{
            $fname_lang = "first_name_".$lang;
            $lname_lang = "last_name_".$lang;
        }
        $fname = $this->profile->$fname_lang;
        $lname = $this->profile->$lname_lang;
        if($br)
            $full = $fname."<br />".$lname;
        else
            $full = $fname." ".$lname;
            
		return $full;
    }

	public function getShortName() {
        $fname_lang = "first_name_".Yii::app()->language;
        $fname = $this->profile->$fname_lang;
		return $fname;
    }

    public function getAvatar($size = self::AVA_BLOGER_SIZE,$class = 'bloger_ava')
	{
	    error_reporting(0);
	    //CVarDumper::dump($this->profile->avatar_source);exit;
	    //return '<span class="bloger_ava" style="background: url(/uploads/avatars/' . $this->profile->avatar_source . ') no-repeat; width:' . $size . 'px; height:' . $size . 'px; "></span>';
        //return '<img class="bloger_ava" src="/uploads/avatars/' . $this->profile->avatar_source . '" width="' . $size . 'px" height="' . $size . 'px" >';
        //return CGallery::thumb_span($this->profile->avatar_source,'uploads/avatars',$size,$size,array('class'=>$class));
        $fname = $this->profile->avatar_source;
        if(strlen($fname) == 0)
            $fname = 'avatar_no_avatar.jpg';
            
        return CHtml::image('/uploads/avatars/'.$fname,
        $this->username,array('class'=>'side_ava'));
    }
}