<?php
Yii::import('application.modules.user.controllers.*', true);
Yii::import('application.extensions.ehttpclient.*');

class ApiController extends Controller
{
	
    public static function object_to_array($obj)
    {
        if(is_object($obj)) 
            $obj = (array) $obj;
        if(is_array($obj))
        {
            $new = array();
            foreach($obj as $key => $val) {
                $new[$key] = self::object_to_array($val);
            }
        }
        else $new = $obj;
        
        return $new;
    }

	public function actionGetNewsOne()
	{
	    $arr = ApiHelper::getParams();
        $id = isset($arr['id']) ? $arr['id'] : null;

        $model = News::model()->findByPk($id);
        $out = array();

        if(!is_null($model) && $model->status == News::STATUS_PUBLISHED)
        {
            $out[] = $model;
        }
        //dd($out);
        if($out)
		    $res = ApiHelper::prepareNews($out, $arr, false);
        		
		ApiHelper::wrapCallback($res);
	}

	public function actionGetNews()
	{
	    $arr = ApiHelper::getParams();
        $ids = isset($arr['ids']) ? $arr['ids'] : array();
        $limit = isset($arr['limit']) ? $arr['limit'] : -1;
        
        $criteria=new CDbCriteria;
        if($ids)
        {
            $criteria->condition = 't.id IN (:ids)';
            $criteria->params[':ids'] = implode(',', $ids);
        }
        $criteria->order = 't.id DESC';
        $criteria->limit = $limit;
        
        $out = array();
    	$i = 0;
    	
    	foreach($ids as $id)
    	{	
    		$model = News::model()->findByPk($id);
    		
    		if(!is_null($model) || $model->status != News::STATUS_PUBLISHED)
    		{
				$out[] = $model;
				$i++;
			}
			
    		if($limit != -1 && $i >= $limit)
    			break;
		}
        
		$res = ApiHelper::prepareNews($out, $arr);

		ApiHelper::wrapCallback($res);
	}

	public function actionGetPortion()
	{
		$arr = ApiHelper::getParams(false);

        $ids = isset($arr['news_ids']) ? $arr['news_ids'] : array(0);
	    $categories = isset($arr['cat_ids']) ? $arr['cat_ids'] : array(0);
        $blogers = isset($arr['bloger_ids']) ? $arr['bloger_ids'] : array(0);
        $limit = isset($arr['limit']) ? $arr['limit'] : -1;
        $offset_id = isset($arr['offset_news_id']) ? $arr['offset_news_id'] : 0;

		$criteria = new CDbCriteria;
		$criteria->condition = '1=1';
		$criteria->params = array();
		$criteria->join = '';

        if(isset($ids))
        {
    		if($limit == -1 && $offset_id == 0)
				$criteria->condition = '1=0';
			if(sizeof($ids) > 0)
            	$criteria->condition .= ' OR t.id IN ('.implode(',', $ids).')';
            //$criteria->params[':ids'] = implode(',', $ids);
        }else{
            if($offset_id > 0){
                //$criteria->params[':offset_id'] = $offset_id;
                //$criteria->condition .= ' AND t.id < :offset_id';
            }else{
        		//$criteria->limit = $limit;
			}

	        if($blogers[0] != 0)
	        {
	            $criteria->condition .= ' AND t.author_id IN (:blogers)';
	            $criteria->params[':blogers'] = implode(',', $blogers);
	        }
        }
		$criteria->order = 't.create_time DESC';

        $criteria->condition .= ' AND t.status = :status';
        $criteria->params[':status'] = News::STATUS_PUBLISHED;

		$data = News::model()->findAll($criteria);

        $data_cat = array();

        if($categories[0] != 0)
        {
            foreach($data as $item)
            {
                foreach($item->categories as $cat)
                {
                    if(in_array($cat->id, $categories))
                    {
                        $data_cat[$item->id] = $item;
                        continue;
                    }
                }
            }
        }else{
            $data_cat = $data;
        }

        //dd($limit);
		if ($offset_id > 0) {
			$out = array();
			$i = -1;
			foreach ($data_cat as $id=>$news) {
				if ($i >= 0 && $i < $limit) {
					$out[$id] = $news;
					$i++;
					//var_dump('out-id '.$id);
				}
				if ($id == $offset_id) {
					$i = 0;
				}//var_dump($id, $i);
				if ($i >= $limit)
					break;
			}//exit;
		} else {
            if ($limit == -1)
                $limit = null;
			$out = array_slice($data_cat, 0, $limit);
		}
        //dd($out);
		$res = ApiHelper::prepareNews($out, $arr);

        ApiHelper::wrapCallback($res);
	}

	public function actionGetStartItems()
	{	
        $criteria = new CDbCriteria;

        $criteria->order = 't.create_time DESC';
        $criteria->limit = 5;
        
        $data = News::model()->findAll($criteria);
        
		$res = ApiHelper::prepareNews($data, $arr);

		ApiHelper::wrapCallback($res);
	}

	public function actionGetBlogers()
	{	
	    $res = array();
		
		$data = Bloger::model()->findAll();
            
        foreach($data as $item)
        {
        	$bloger = $item->attributes;
        	$bloger['avatar_source'] = 'http://' . $_SERVER['HTTP_HOST'] . $item->user->getAvatar(User::AVA_BLOGER_SIZE, 'bloger_ava', true);
        	$bloger = ApiHelper::filterStrs($bloger);
			$res[] = $bloger;
		}
        
		ApiHelper::wrapCallback($res);
	}

	public function actionGetUserBlogers()
	{	
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
		$data = $user->blogers;
        foreach($data as $item)
        {
            $res[] = $item->attributes;
        }
        
		ApiHelper::wrapCallback($res);
	}

	public function actionSetUserBlogers()
	{	
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
        $res = array(0, 'no blogers were assigned to the user');
        
        $dataAll = Bloger::model()->findAll();
		$data = Bloger::model()->findAllByPk($arr['ids']);
        
        foreach($dataAll as $item)
        {
            $item->removeUser($user,'user_bloger_assignment','bloger_id','user_id');
        }
        foreach($data as $item)
        {
            //var_dump($item->hasUserAssigned($user,'user_bloger_assignment','bloger_id','user_id'));exit;
            if(!$item->hasUserAssigned($user,'user_bloger_assignment','bloger_id','user_id')){
		        $item->assignUser($user,'user_bloger_assignment','bloger_id','user_id');
                $res = array(1, 'blogers assigned to the user');
    		}
        }
        
		ApiHelper::wrapCallback($res);
	}
	
	public function actionGetUserBookmarks()
	{
        $res = array();
        $arr = ApiHelper::getParams();
         
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);

		foreach ($user->bookmarks as $item)
        {
			$res[] = $item['id'];
		}

		ApiHelper::wrapCallback($res);
	}

	public function actionSetUserBookmarks()
	{	
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
        $res = array(0, 'no news were bookmarked');
        
        $dataAll = News::model()->findAll();
		$data = News::model()->findAllByPk($arr['ids']);
        
        foreach($dataAll as $item)
        {
            $item->removeUser($user,'user_news_bookmark','news_id');
        }
        foreach($data as $item)
        {
            if(!$item->hasUserAssigned($user,'user_news_bookmark','news_id')){
		        $item->assignUser($user,'user_news_bookmark','news_id');
                $res = array(1, 'news were added to bookmarks');
    		}
        }
        
		ApiHelper::wrapCallback($res);
	}
	
	public function actionGetCategories()
	{
	    $res = array();
		
		$data = Category::model()->findAll();
            
        foreach($data as $item)
        {
			$res[] = $item->attributes;
		}
        
		ApiHelper::wrapCallback($res);

		print ApiHelper::wrapCallback($res);
	}

	public function actionGetUserCategories()
	{	
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
		$data = $user->categories;
        foreach($data as $item)
        {
            $res[] = $item->attributes;
        }
        
		ApiHelper::wrapCallback($res);
	}
	
	public function actionSetUserCategories()
	{
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
        $res = array(0, 'no categories were assigned to the user');
        
		$data = Category::model()->findAllByPk($arr['ids']);
        $dataAll = Category::model()->findAll();
        
        foreach($dataAll as $item)
        {
            $item->removeUser($user,'user_category_assignment','category_id');
        }
        foreach($data as $item)
        {
            if(!$item->hasUserAssigned($user,'user_category_assignment','category_id'))
            {
    			$item->assignUser($user,'user_category_assignment','category_id');
                $res = array(1, 'categories assigned to the user');
    		}
        }
        
		ApiHelper::wrapCallback($res);
	}

	public function actionGetProfile()
	{
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
		$res = array_merge(array('email' => $user->email), $user->profile->attributes, array('receive_news' => $user->preferences->receive_news));
        //var_dump($res);exit;
        $res['avatar_source'] = "/" . User::PREVIEW_PATH . $res['avatar_source'];
        
		ApiHelper::wrapCallback($res);
	}

	public function actionSetProfile()
	{
	    $res = array();
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
        if(sizeof($arr['attributes']) > 0)
        {
            if (!$user->preferences) {
                $pref = new UserPreferences;
                $pref->user_id = $user->id;
                $pref->save();
                $user->preferences = $pref;
            }
            //var_dump($arr['attributes']['receive_news']);
            //var_dump($arr['attributes']);
            //var_dump($user->preferences->attributes);
            $user->profile->attributes = $arr['attributes'];
            if(isset($arr['attributes']['sex']))
                $user->profile->sex = $arr['attributes']['sex'];
            if($arr['attributes']['email'])
                $user->email = $arr['attributes']['email'];
            if(isset($arr['attributes']['receive_news']))
                $user->preferences->receive_news = $arr['attributes']['receive_news'];
                
            if(isset($arr['attributes']['old_pass']) && isset($arr['attributes']['new_pass']))
            {
                if(UserModule::encrypting($arr['attributes']['new_pass']) == $user->password)
                {
                    $user->password = UserModule::encrypting($arr['attributes']['new_pass']);   
                    $res = array(1, 'User\'s profile updated');
                }
                else{
                    $res = array(0, 'Error changing password');                    
                }
            }else{
                $res = array(1, 'User\'s profile updated');
            }
            $user->preferences->save();
            $user->profile->save();
            $user->save();
        }else{
            $res = array(0, 'No attributes given to update user\'s profile');
        }
        
		ApiHelper::wrapCallback($res);
	}

    public function actionAvatar()
    {
        $res = array(0, 'An error occurred');
        $arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        if(isset($arr["byte"]))
        {
            $image_byte_code = $arr['byte'];
            $content = base64_decode($image_byte_code);
            $im = imagecreatefromstring($content);

            if ($im !== false) {
                //header('Content-Type: image/jpeg');
                $fname = md5(time() . rand(100, 999)) . ".jpg";
                imagejpeg($im, $_SERVER['DOCUMENT_ROOT'] . "/" . User::PREVIEW_PATH . $fname);
                imagedestroy($im);
                $user->profile->avatar_source = $fname;
                $user->profile->save();
                $res = array(1, 'Avatar saved');
            }
        }

        ApiHelper::wrapCallback($res);
    }
    
	public function actionSearch()
	{
	    $arr = ApiHelper::getParams();
        $model = new News;
		$model->unsetAttributes();
        
		$criteria=new CDbCriteria;

		//$criteria->compare('name_en',$arr['keyword'], true, 'OR');
		$criteria->compare('name_ru',$arr['keyword'], true, 'OR');
		$criteria->compare('name_uk',$arr['keyword'], true, 'OR');
		$criteria->compare('teaser_uk',$arr['keyword'], true, 'OR');
		$criteria->compare('teaser_ru',$arr['keyword'], true, 'OR');
		//$criteria->compare('teaser_en',$arr['keyword'], true, 'OR');
		$criteria->compare('text_ru',$arr['keyword'], true, 'OR');
		//$criteria->compare('text_en',$arr['keyword'], true, 'OR');
		$criteria->compare('text_uk',$arr['keyword'], true, 'OR');
        
		$data = $model->findAll($criteria);
        if(sizeof($data) > 0)
        {
		    $res = ApiHelper::prepareNews($data, $arr);
        }else{
            $res = array(0, 'No results for this keyword.');
        }
        
		ApiHelper::wrapCallback($res);
    }

	public function actionConnected()
	{exit;
		$res = array(1, 'Connected');
		$arr = ApiHelper::getParams();
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token'], false);
		
		$dif = strtotime(date('Y-m-d H:i:s')) - strtotime($user->api_login_at);
		//var_dump($user->attributes, strtotime(date('Y-m-d H:i:s')), strtotime($user->api_login_at));exit;
		if($dif > 3600)
		{
			$res = array(0, 'Not connected');
		}
		
		ApiHelper::wrapCallback($res);
	}

	public function actionLogin()
	{
	    $arr = ApiHelper::getParams();
	    $email = $arr['email'];
	    
        if(isset($arr['access_token']) && strlen($arr['access_token']) > 0)
        {
        	switch($arr['login_type'])
        	{
        		case 'facebook':
		        	$fb = file_get_contents('https://graph.facebook.com/me?access_token=' . $arr['access_token']);
		        	$fb = json_decode($fb, true);
			        	//var_dump($fb['email']);exit;
		        	if(!isset($fb['email']))
	                {
	                    $res = array(0, 'You must allow to see your e-mail in FB settings');
	                }else{
			        	$email = $fb['email'];
			        	$user = User::model()->notsafe()->findByAttributes(array('email' => $email));
			        	
			        	if(is_null($user))
		                {
			        		$user = ApiHelper::generateFbUser($fb);
		                }
					}
	        	break;
        		case 'twitter':
	        		$twitter = Yii::app()->twitter->getTwitterTokened(
	        			$arr['access_token'],//'2149360598-qCutDJI7Z0uQ0MlLfGTe3wTUhT4G3hIMA5GuEu0',
	        			$arr['access_token2']//'1RZHh1a1isomX8w18zohX793Xix2X2U3KfcLdFmkoMDHw'
	        		);
 
		            $twuser = $twitter->get("account/verify_credentials");
		            
		            $user = User::model()->notsafe()->findByAttributes(array('id_tw' => $twuser->id));
		            if(is_null($user))
	                {
	                	if($arr['email'])
	                		$user = ApiHelper::generateTwUser($twuser, $arr['email']);
	                	else
		        			$res = array('twitter_email_fail');
	                }
	        	break;
			}
        }else{
            $user = User::model()->notsafe()->findByAttributes(array('email' => $email));
            if(is_null($user))
            {
                $res = array(0, 'User not found');
            }
        }
        if(is_object($user))
        {
        	//var_dump($user);exit;
        	//var_dump($user);exit;
            if((isset($arr['access_token']) && strlen($arr['access_token']) > 0) || $user->password == Yii::app()->getModule('user')->encrypting($arr['password'])) {
                $user->setToken();
                $user->setApiLoginAt();
                //$user->lastvisit_at = date('Y-m-d H:i:s');
                $user->save();
                $res = array(
                    //'status' => 1,
                    'user_id' => $user->id,
                    'token' => $user->token,
                );
            } else {

            //}
            //if(!isset($arr['access_token']) && $user->password != Yii::app()->getModule('user')->encrypting($arr['password']))
                $res = array(0, 'Wrong password ' . Yii::app()->getModule('user')->encrypting($arr['password']));
            //else{
            }
        }
		
		ApiHelper::wrapCallback($res);
	}

	public function actionLogOut()
	{
			if (Yii::app()->user->id){
				Yii::app()->user->logout();
				ApiHelper::wrapCallback(array('1', 'logged out'));//logged out
			}else
				ApiHelper::wrapCallback(array('0', 'cant log out : you are not logged yet'));// cant log out : you are not logged yet
			
	}

	public function actionRecovery()
	{
        /*$_POST = array(
            'login_or_email' => 'arybachu@gmail.com',
        );*/
        
        $arr = ApiHelper::getParams();
        $user = User::model()->findByAttributes(array('username' => $arr['email']));
        if(is_null($user))
        {
            $user = User::model()->findByAttributes(array('email' => $arr['email']));
            if(is_null($user))
            {
                $res = array(0, 'User not found');
            }
        }
        if(is_object($user))
        {
            if(!isset($arr['newpass']))
            {
                $newpass = substr(md5(rand(10000, 99999) . microtime()), 0, 6);
            }else{
                $newpass = $arr['newpass'];
            }
            $user->activkey = UserModule::encrypting(microtime().$newpass);
       	    $user->password = UserModule::encrypting($newpass);
            $user->save();
            $subject = UserModule::t("You have requested the password recovery site {site_name}",
					array(
						'{site_name}'=>Yii::app()->name,
					));
			$message = UserModule::t("You have requested the password recovery site {site_name}. This is your new password: " . $newpass . ".",
					array(
						'{site_name}'=>Yii::app()->name,
					));
			
			UserModule::sendMail($user->email,$subject,$message);
            $res = array(1, 'The new password was sent on your e-mail');
        }
		
		ApiHelper::wrapCallback($res);
	}

	public function actionRegister($send = 0)
	{	
	    /*$_POST = array(  
		    "RegistrationForm" => array(
				"username"=>"apitest",
				"password"=>"testPassword",
				"email"=>"apitest@as.as",
			),
		    "Profile" => array(
				 "first_name_en"=>"Volodymyr",
				 "last_name_en"=>"Volmyr",
				 "first_name_ru"=>"Владимир",
				 "last_name_ru"=>"Волмир",
				 "first_name_uk"=>"Володимір",
				 "last_name_uk"=>"Волмир"
			 ),
	    );*/
        $arr = ApiHelper::getParams();//var_dump($arr);exit;
        $user = User::model()->findByAttributes(array('username' => $arr['user']['username']));
        if(is_null($user))
        {
            $user = User::model()->findByAttributes(array('email' => $arr['user']['email']));
            if(is_null($user))
            {
                $user = new User;
                $profile = new Profile;
                $user->attributes = $arr['user'];
                $user->setToken();
                $user->activkey = UserModule::encrypting(microtime().$user->password);
        	    $user->password = UserModule::encrypting($user->password);
				$user->superuser = 0;
				$user->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
                
                if ($user->save()) 
                {
                    $profile->attributes = ((isset($arr['profile']) ? $arr['profile'] : array()));
                    $profile->user_id = $user->id;
    				$profile->save();
                    
	                $res = array(1, 'User ' . $arr['user']['username'] . ' was registered');
                }else{
                    $res = array(1, 'User ' . $arr['user']['username'] . ' was not registered');
                }
            }else{
                $res = array(0, 'User with such email is already registered');
            }
        }else{
            $res = array(0, 'User with such username is already registered');
        }
        
        ApiHelper::wrapCallback($res);
	}
	
	public function actionGetWidgetInfo()
    {
        $res = array();
        if(isset($_POST['city_id']) || isset($_POST['curr_id']))
        {
            $city = City::model()->findByPk((int)$_POST['city_id']);
            $curr = WidgetCurrencyElement::model()->findByPk((int)$_POST['curr_id']);
            
            if(!is_null($city))
                $res['city'] = $city->attributes;
            if(!is_null($curr))
                $res['currency'] = $curr->attributes;
        }else{
    		$cities = City::model()->findAll();
    		foreach ($cities as $city)
            {
                $res[] = $city->attributes;
   			}
        }
		
        ApiHelper::wrapCallback($res);
	}
	
	public function actionGetUserWidgetInfo($user_id = "")
    {
		$arr = ApiHelper::getParams();
            
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
		if ($user->preferences){
            ApiHelper::wrapCallback($user->preferences->attributes);
		}else{
			ApiHelper::wrapCallback(array(0, "user has no preferenses"));
		}
	}
	
	//Выставляю данные виджетов для юзера
	public function actionSetUserWidgetInfo($arr=null,$callback="")
    {
		$arr = ApiHelper::getParams();
		
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);
        
        /*if (!isset($arr["user_id"]))
			ApiHelper::wrapCallback(array("0", 'current id not found'), $callback);
        if(!isset($arr['token']))
            ApiHelper::wrapCallback(array(0, "no token recieved"));
        
		$user = User::model()->findByPk($arr["user_id"]);
		if (!$user)
			ApiHelper::wrapCallback(array("0", 'current user not found'),$callback);//если юзера не существует
        if($user->token != $arr['token'])
            ApiHelper::wrapCallback(array(0, 'invalid token recieved'));*/
		//может оказаться, что юзер в таблице только создан и потому таблички с его преференсами не существует, тогда заводим новую
		if (!$preferences = UserPreferences::model()->findByPk($arr["user_id"]))
        {
            $preferences = new UserPreferences();	
			$preferences->user_id = $arr["user_id"];
		}
        
        $preferences->attributes = $arr['attributes'];
		
        $preferences->attributes = (array)$arr['attributes'];
          
        /*
		if (isset($arr['lang']) && (!empty($arr['lang']))) 
			$preferences->lang = $arr['lang'];
		if ((isset($arr['weather_city_id'])) && (!empty($arr['weather_city_id']))) 
			$preferences->weather_city_id = $arr['weather_city_id'];
		if ((isset($arr['traffic_city_id'])) && (!empty($arr['traffic_city_id']))) 
			$preferences->traffic_city_id = $arr['traffic_city_id'];
		if ((isset($arr['currency_id'])) && (!empty($arr['currency_id']))) 
			$preferences->currency_id = $arr['currency_id'];
		if ((isset($arr['mobile_later'])) && (!empty($arr['mobile_later']))) 
		    $preferences->mobile_later = $arr['mobile_later'];
		if ((isset($arr['friends_later'])) && (!empty($arr['friends_later']))) 
			$preferences->friends_later = $arr['friends_later'];
		if ((isset($arr['follow_later'])) && (!empty($arr['follow_later']))) 
			$preferences->follow_later = $arr['follow_later'];
		if ((isset($arr['font_size'])) && (!empty($arr['font_size']))) 
			$preferences->font_size = $arr['font_size'];*/
		if ($preferences->save()){
			ApiHelper::wrapCallback(array("1", 'info for user widgets saved'));
		}else{
			ApiHelper::wrapCallback(array("0", 'error saving user widgets info'));
		}
	}

	public function actionUpdateItemInfo()
	{
		$this->render('updateItemInfo');
	}

	public function actionUpdateUserInfo()
	{
		$this->render('updateUserInfo');
	}
	
	//Выдаю инфу о городах 
	//id	name_en	name_ru	name_uk	temp	traffic	text_temp
	public function actionGetCities()
    {
        $data = array();
        $arr = ApiHelper::getParams(false);
        
    	$dbCommand = Yii::app()->db->createCommand("
	        SELECT * FROM `city` WHERE status=1
	    ");

	    $rows = $dbCommand->queryAll();

        if(isset($arr['lat']) && isset($arr['lng']))
        {            
            $data[] = ApiHelper::closestLocation($arr, $rows);
        }else{
		    $data = $rows;
        }
        
        if(empty($data))
        {
            $data = array(0, 'No cities found');
        }

		ApiHelper::wrapCallback($data);
	}
	
	private static function findCity($coords)
	{
		$city_name = null;
    	$q = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $coords['lat'] . ',' . $coords['lng'] . '&sensor=true';
     	
        $info = json_decode(file_get_contents($q));
        $info = self::object_to_array($info);
        
        if($info["status"] != "ZERO_RESULTS")
        {
	        foreach($info["results"][0]["address_components"] as $item)
	        {
	            if(in_array('locality', $item['types']))
	            {
	                $city_name = $item['long_name'];
	                break;
	            }
	        }
	        
	        if(!$city_name)
	        {
	        	$coords_new = array(
	        		'lat' => (float)$coords['lat'] * 0.9,
	        		'lng' => (float)$coords['lat'] * 0.9,
	        	);
	        	
				$city_name = self::findCity($coords_new);
			}
        }
		
		return $city_name;
	}
	
	//инфа о валюте
	//id	name	buy	sale	symbol	showorder
	public function actionGetCurrencies()
	{
		$data = WidgetCurrencyElement::model()->findAll();
		
		foreach($data as $item){
			//var_dump($item);exit;
            $res[] = self::object_to_array($item->attributes);
		}

        if(is_null($res))
        {
            $res = array(0, 'No currencies found');
        }
		
		print ApiHelper::wrapCallback($res);
	}
	
	public function actionCategoryAssigned()
	{
        $res = array();
        $arr = (array)json_decode($_POST['params']);
        
        $user = ApiHelper::getUserByIdToken($arr["user_id"], $arr['token']);

		foreach ($user->categories as $item)
        {
			$res[] = array(
                'id' => $item['id'],
                'name_en' => $item['name_en'],
                'name_ru' => $item['name_ru'],
                'name_uk' => $item['name_uk'],
            );
		}

		ApiHelper::wrapCallback($res);
	}

    public function actionGetAbout()
    {
        $model = Content::model()->find(array('condition'=>'name="contact"'));

        ApiHelper::wrapCallback(array(
            'text_ru' => ApiHelper::linksToAbsPath($model->text_ru),
            'text_uk' => ApiHelper::linksToAbsPath($model->text_uk),
        ));
    }
	
}