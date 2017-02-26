<?php

class ApiHelper {

    public static function linksToAbsPath($str)
    {
        return str_replace('href="/','href="http://' . $_SERVER['HTTP_HOST'] . '/', $str);
    }
	    
	public static function wrapCallback($str, $callback = '')
    {
        header("Content-Type: text/html; charset=UTF-8");
		$str = json_encode($str);
		if(strlen($callback) == 0){
			echo $str;
		}
		else
		{
		    echo $callback. "(". $str. ")";
		}
        exit;
	}
    
    /*
    * Parse request and extract params if $_POST['params'] exists
    */
    public static function getParams($exit_if_empty = true)
    {
        if ( !isset($_POST['params']) || empty($_POST['params']))
        {
            if($exit_if_empty)
			    ApiHelper::wrapCallback(array("0", 'no parameters given'));
            else
                $out = array();
        }else{
            //var_dump(json_decode($_POST['params']));exit;
            $out = (array)json_decode($_POST['params']);
    
            foreach($out as $k=>$item)
            {
                if(is_object($item))
                {
                    $item = (array)$item;
                }
                $out[$k] = $item;
            }
        }
        
		return $out;
    }
    
    public static function getUserByIdToken($id, $token, $visit = true)
    {
        if (!isset($id))
			ApiHelper::wrapCallback(array("0", 'current id not found'));
        if(!isset($token))
            ApiHelper::wrapCallback(array(0, "no token recieved"));
        
		$user = User::model()->with(array('categories', 'blogers', 'bookmarks'))->findByPk($id);
		if (!$user)
			ApiHelper::wrapCallback(array("0", 'current user not found'));//если юзера не существует
        if($user->token != $token)
            ApiHelper::wrapCallback(array(0, 'invalid token recieved'));
            
        if($visit){
        	$user->setApiLoginAt();
			$user->save();
		}
            
        return $user;
    }
	
    /*
    * If no user found by email we create one
    */
	public static function generateFbUser($params)
	{
		$user = new User;
        $profile = new Profile;
        $pass = substr(md5(rand(0, 9999) . time()), 6);
        $user->username = array_shift(explode('@',$params['email']));
        $user->email = $params['email'];
        $user->password = UserModule::encrypting($pass);
        $user->activkey = UserModule::encrypting(microtime().$pass);
        $user->superuser = 0;
        $user->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
        if ($user->save())
        {
			$profile->user_id = $user->id;
            $profile->first_name_en = $params['first_name'];
            $profile->last_name_en = $params['last_name'];
			$profile->save();
        }else{
			var_dump($user->getErrors());exit;
		}
        
        return $user;
	}
	
    /*
    * If no user found by email we create one
    */
	public static function generateTwUser($params, $email)
	{
		$user = new User;
        $profile = new Profile;
        $pass = substr(md5(rand(0, 9999) . time()), 6);
        $user->username = array_shift(explode('@',$email));
        $user->email = $email;
        $user->password = UserModule::encrypting($pass);
        $user->activkey = UserModule::encrypting(microtime().$pass);
        $user->superuser = 0;
        $user->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);
        $user->id_tw = $params->id;
        if ($user->save())
        {
        	$name = explode(' ', $params->name);
			$profile->user_id = $user->id;
            $profile->first_name_en = $name[0];
            $profile->last_name_en = $name[1];
			$profile->save();
        }else{
			var_dump($user->getErrors());exit;
		}
        
        return $user;
	}
    
    /*
    * Common process for all API methods that return array of news
    */
    public static function prepareNews($data, $arr, $short = true)
    {
    	$default_unset_arr = array(
	    	//'name_ru',
	    	'name_en',
	    	//'name_uk',
	    	//'teaser_ru',
	    	'teaser_en',
	    	//'teaser_uk',
	    	//'text_ru',
	    	'text_en',
	    	//'text_uk',
	    );
    	$unset_arr = array(
	    	//'name_ru',
	    	//'name_en',
	    	//'name_uk',
	    	//'teaser_ru',
	    	//'teaser_en',
	    	//'teaser_uk',
	    	'text_ru',
	    	'text_en',
	    	'text_uk',
	    );
	    
        $prefix = 'http://' . $_SERVER['HTTP_HOST'] . '/uploads/preview/';
        $res = array();
        
        foreach($data as $item)
        {
            $tmp = array();
            foreach($item->attributes as $k=>$attr)
            {
                    $tmp[$k] = $attr;
            }
            foreach($tmp as $k=>$attr)
            {
                //$tmp[$k] = strip_tags($attr, '<a>');
                $tmp[$k] = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $tmp[$k]);

            }

            if(isset($arr['screenWidth']) && $arr['screenWidth'] != 0)
                $tmp['preview_source'] = $prefix . CGallery::thumbnailNameX($item->preview_source,'uploads/preview',$arr['screenWidth'],$arr['screenWidth']);
            else
                $tmp['preview_source'] = $prefix . $tmp['preview_source'];
                
            if($item->blog)
                $tmp['bloger_avatar'] = 'http://' . $_SERVER['HTTP_HOST'] . $item->author->getAvatar(45,'desc_ava',true);
            else
                $tmp['bloger_avatar'] = '';
            
            if ($short)
            {
	            foreach($unset_arr as $attr)
	            {
					unset($tmp[$attr]);
				}
			} else {
	            $tmp = self::filterStrs($tmp);
			}
            foreach($default_unset_arr as $attr)
            {
				unset($tmp[$attr]);
			}
            
            $res[] = $tmp;
        }
        
        return $res;
    }

    public static function filterStrs($arr)
    {
    	$filter_arr = array(
	    	'teaser_ru',
	    	'teaser_uk',
	    	'description_ru',
	    	'description_uk',
	    	'text_ru',
	    	'text_uk',
	    );
    	$filter_elems = array(
	    	'\r',
	    	'\n',
	    	'\\r',
	    	'\\n',
	    	'~[[:cntrl:]]~',
	    );
	    
        foreach($filter_arr as $attr)
        {
            foreach($filter_elems as $elem)
            {
            	$enc = json_encode($arr[$attr]);
				$enc_f = str_replace($elem,'',$enc);
				$arr[$attr] = json_decode($enc_f);
            }
		}
    	
    	return $arr;
    }
    
    /*
    * Methods to get distance berween two locations
    */
	private static function vectorDistance($dx, $dy)
	{
        return sqrt($dx * $dx + $dy * $dy);
    }

    private static function locationDistance($location1, $location2)
    {
        $dx = $location1['lat'] - (float)$location2['lat'];
        $dy = $location1['lng'] - (float)$location2['lng'];

        return self::vectorDistance($dx, $dy);
    }

    public static function closestLocation($targetLocation, $locationData)
    {
    	$out = null;
    	$min = 10000000;
    	
	    foreach($locationData as $loc)
	    {
	    	$tmp = self::locationDistance($targetLocation, $loc);
	    	$arr[$loc['name_ru']] = array(
	    		'dist' => $tmp
	    	);
	    	if($tmp < $min)
	    	{
				$out = $loc;
	    		$min = $tmp;
			}
	    }

	    return $out;
    }
	
}