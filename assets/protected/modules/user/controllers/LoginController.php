<?php
Yii::import('application.extensions.hybridauth.hybridauth.Hybrid.*');
Yii::import('application.extensions.hybridauth.hybridauth.Hybrid.Providers.*');

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	
	public function actions()
	{
	  return array(
		/*'oauth' => array(
		  'class'=>'ext.hoauth.HOAuthAction',
		),
		'oauthadmin' => array(
		  'class'=>'ext.hoauth.HOAuthAdminAction',
		),*/
	  );
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('oauthadmin'),
				'users'=>UserModule::getAdmins(),
			),
			array('allow',  // deny all users
                'actions'=>array('facebook'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
                'actions'=>array('oauthadmin'),
				'users'=>array('*'),
			),
		);
	}

	static function autoSignin($user)
	{
	    $model = new UserLogin;//var_dump($user);exit;
	    $model->username = $user->username;
	    $model->password = $user->password;
        $model->authenticate(true);
	}

	function actionTwittercomplete()
	{
	    if(Yii::app()->request->isAjaxRequest)
	    {
	    	$data = array();
	    	$data['error'] = 0;

            if(User::model()->findByAttributes(array('email' => $_POST['email']))){
            	$data['error'] = 1;
            	$data['msg'] = Yii::t('app',"Такой e-mail уже кем-то используется");
            }
            if(!preg_match('/^\S+@\S+\.\S+$/', $_POST['email']))
            {
            	$data['error'] = 1;
            	$data['msg'] = Yii::t('app',"E-mail имеет неверный формат");
            }
            if(!strlen($_POST['email'])){
            	$data['error'] = 1;
            	$data['msg'] = Yii::t('app',"Необходимо заполнить все поля");
            }
            
            if($data['error'] == 0)
            {
	            $user = User::model()->findByPk(Yii::app()->session['tw_verify']);
	            
	            if($user)
	            {
		            $user->email = $_POST['email'];
		            $user->verified_tw = 1;
		            $user->save();
		            
		            self::autoSignin($user);
		            
		            unset(Yii::app()->session['tw_verify']);
		        	
            		$data['msg'] = Yii::t('app',"Вы успешно вошли используя Twitter");
				}else{
	            	$data['error'] = 1;
	            	$data['msg'] = Yii::t('app',"Возникла ошибка регистрации пользователя");
				}
			}
			
            AjaxHelper::sendResponse($data);
	    }
        Yii::app()->end();
	}

	function actionTwittercancel()
	{
	    if(Yii::app()->request->isAjaxRequest)
	    {
	    	$user = User::model()->findByPk(Yii::app()->session['tw_verify']);
	    	
	    	if($user)
	        {
	        	$user->delete();
	        }

	    	unset(Yii::app()->session['tw_verify']);
	    	
        	$data['error'] = 0;
        	$data['msg'] = '';
            AjaxHelper::sendResponse($data);
	    }
        Yii::app()->end();
	}

	function actionTwitter()
	{
		$config = array( 
			"base_url"   => 'http://' . $_SERVER['HTTP_HOST'] . '/user/login/twitter',
			"providers"  => array (
				"Twitter"   => Yii::app()->params['hoauth']['providers']['Twitter'],
			),		 
		);
 	    if(isset($_REQUEST['access_token']))
        {
            var_dump($_REQUEST);exit;
        }
            
		if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done']))
        {
            Hybrid_Endpoint::process();
        }
			
		$socialAuth = new Hybrid_Auth($config);
		
		$provider = $socialAuth->authenticate("twitter");
		$userProfile = $provider->getUserProfile();
		//var_dump($userProfile);exit;
		$provider->logout();
		
		$user = User::model()->findByAttributes(array(
			'id_tw' => $userProfile->identifier,
			'verified_tw' => 1,
		));
		
		if(!is_null($user))
        {
        	self::autoSignin($user);
        	$this->redirect(Yii::app()->user->loginUrl[0]);
        }else{
			$user = User::model()->findByAttributes(array(
				'id_tw' => $userProfile->identifier,
			));
			
			if(!$user)
			{
	        	$user = self::generateTwUser($userProfile);
	            $user->id_tw = $userProfile->identifier;
	            
	            $user->save();
			}
			
			Yii::app()->session['tw_verify'] = $user->id;
			
			$this->redirect(Yii::app()->user->loginUrl[0]);
        }
        
	}

	function actionFacebook()
	{
		$config = array( 
			"base_url"   => 'http://' . $_SERVER['HTTP_HOST'] . '/user/login/facebook',
			"providers"  => array (
				"Facebook"   => array (
					"enabled"    => true,
					"keys"       => array ( "id" => 1526643264271868,//333332226831118, 
										"secret" => '6e72a63724e66e26723a7d64d8af09f3',//'f22981e1b7a2b43b758a7cced50e2287',
									),
					),
			),		 
		);
 	    if(isset($_REQUEST['access_token']))
        {
            var_dump($_REQUEST);exit;
        }
            
		if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done']))
        {
            Hybrid_Endpoint::process();

        }
			
		$socialAuth = new Hybrid_Auth($config);
		
		$provider = $socialAuth->authenticate("facebook");
		$userProfile = $provider->getUserProfile();
		$provider->logout();
//var_dump($userProfile);exit;
		$user = User::model()->findByAttributes(array('email' => $userProfile->emailVerified));//var_dump($user->attributes);exit;
        if(!is_null($user))
        {
            $user->id_fb = $userProfile->identifier;
            $user->save();
        }else{
            $user = self::generateFbUser($userProfile);
        }
        
		self::autoSignin($user);
        $this->redirect(Yii::app()->user->loginUrl[0]);
	}
	
	public static function generateTwUser($userProfile)
	{
		$email = $userProfile->emailVerified;
		
		if(!$email)
		{
			$email = substr(md5(rand(0, 9999) . time()), 6);
		}
		
		$user = new User;
        $profile = new Profile;
        $pass = substr(md5(rand(0, 9999) . time()), 6);
        $user->username = $email;
        $user->email = $email;
        $user->password = UserModule::encrypting($pass);
        $user->activkey = UserModule::encrypting(microtime().$pass);
        $user->superuser = 0;
        $user->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
        
        if ($user->save(false))
        {
			$profile->user_id = $user->id;
            $profile->first_name_en = $userProfile->firstName;
            $profile->last_name_en = $userProfile->lastName;
            $profile->day = $userProfile->birthDay;
            $profile->month = $userProfile->birthMonth;
            $profile->year = $userProfile->birthYear;
			$profile->save(false);
        }
        
        return $user;
	}
	
	public static function generateFbUser($userProfile)
	{
		$user = new User;
        $profile = new Profile;
        $pass = substr(md5(rand(0, 9999) . time()), 6);
        $user->username = $userProfile->emailVerified;
        $user->email = $userProfile->emailVerified;
        $user->password = UserModule::encrypting($pass);
        $user->activkey = UserModule::encrypting(microtime().$pass);
        $user->superuser = 0;
        $user->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
        if ($user->save())
        {
			$profile->user_id = $user->id;
            $profile->first_name_en = $userProfile->firstName;
            $profile->last_name_en = $userProfile->lastName;
            $profile->day = $userProfile->birthDay;
            $profile->month = $userProfile->birthMonth;
            $profile->year = $userProfile->birthYear;
			$profile->save();
        }
        
        return $user;
	}
	
	public function actionIndex()
	{
		$state["post"] = 0;
        if (isset($_POST['params'])){
			
			$state["post"] = 1;
            $jobj = json_decode($_POST['params']);
			
            $_POST = (array)$jobj;
            $ind = 1;
			
            foreach($_POST as $k=>$it){
               if ($ind--) $_POST[$k] = (array)$it;
            }
        }
                
		if (Yii::app()->user->isGuest){
			$model = new UserLogin;
			$state["quest"] = 1;
			// collect user input data
			
			if(isset($_POST['UserLogin'])){
				$model->attributes = $_POST['UserLogin'];
//                dd($model->attributes);
				// validate user input and redirect to previous page if valid
				if($model->validate()){
				    if (Yii::app()->request->isAjaxRequest) {
				        echo json_encode($_SERVER['HTTP_REFERER']);
                        Yii::app()->end();
				    }
					$state["validated"] = 1;
					if (!$state["post"]) 
						$this->lastViset();
					if (Yii::app()->user->returnUrl=='/index.php'){
						if(!$state["post"])
							$this->redirect(Yii::app()->controller->module->returnUrl);
						else{
							print Yii::app()->user->id;// validated - prints user id
						}
					}
					else{
						if(!$state["post"])    
							$this->redirect(Yii::app()->user->returnUrl);
						else{
							//print Yii::app()->user->id;// validated - prints user id
                            $user = User::model()->findByPk(Yii::app()->user->id);
                            $user->setToken();
                            if($user->save())
                                print json_encode(array('user_id' => Yii::app()->user->id, 'token' => $user->token));
						}
					}
				}else{
				    if(Yii::app()->request->isAjaxRequest){
                        if(empty($_POST['UserLogin']['password']) || empty($_POST['UserLogin']['username'])){
                            echo json_encode(array(0,Yii::t('app',"Необходимо заполнить все поля")));
                            Yii::app()->end();
                        }
				        echo json_encode(array(0, Yii::t('app','Проверьте написание логина или пароля')));
                        Yii::app()->end();
				    }
					$state["validated"] = 0;
					if ($state["post"]) {
						$state["wrong"] = 1;
						echo json_encode(array(-1));//wrong data
					}
				}
			}//error post request
			// display the login form
			if (!$state["post"])
				$this->render('/user/login',array('model'=>$model));
			elseif((!$state["validated"]) && (!$state["wrong"])){
				echo json_encode(array(0, 'no data in the form'));//no data in the form
			}
		}else{
			$state["quest"] = 0;
			if(!$state["post"])
				$this->redirect(Yii::app()->controller->module->returnUrl);
			else{
				echo json_encode(array(-2, 'not quest'));//not quest 
			}
		}
    }
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		if ($lastVisit){
			$lastVisit->lastvisit = time();
			$lastVisit->save();
		}
	}
	
	// public function actionCheckById(){
	// //parametrs to registr
	// die("hello");
		// $id_fb = Yii::app()->session['id_fb'] ;
		// $avatar = Yii::app()->session['avatar'];
		// $firstName = Yii::app()->session['firstName'];
		// $lastName = Yii::app()->session['lastName'];
		// $email = Yii::app()->session['email'];
		// $password = rand();
	// //getting user if isset
		// $criteria = new CDbCriteria();
		// $criteria->condition = "id_fb=:id_fb OR email=:email";
		// $criteria->params = array('id_fb' => $id_fb,"email"=>$email);
		// if($user = User::model()->find($criteria)){
			// Yii::app()->user->id = $user->id; //validated ok
			// if ($user->email == $email){
					// $user->id_fb = $id_fb;
					// $user->save();
				// }
			// $this->redirect("/");
		// }else{ //create new user
			// $_POST = array (
            // 'RegistrationForm' => array (
                // 'username' => $firstName.substr(time(),3),
                // 'password' => $password,
                // 'verifyPassword' => $password,
                // 'email' => $email,
            // ), 
            // 'Profile' => array (
                // 'first_name_en' => $firstName, 
                // 'last_name_en' => $lastName, 
                // 'first_name_ru' => '', 
                // 'last_name_ru' => '', 
                // 'first_name_uk' => '', 
                // 'last_name_uk' => '', 
            // ), 
            // 'yt0' => 'Register');			
		// }
	// }
	
	
}