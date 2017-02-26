<?php

class Aii extends Yii
{
    public static function t($arg, $msg = '', $params = array(), $source = NULL, $language = NULL)
    {
        return parent::t('app', $arg);
    }
    
    public static function tr($arg)
    {        
        return self::setting(Yii::app()->language, $arg);
    }
    
    public static function param($arg)
    {        //var_dump($arg);exit;
        return self::setting('param', $arg);
    }
    
    private static function setting($cat, $arg)
    {
        if(!Yii::app()->settings->get($cat, $arg))
            Yii::app()->settings->set($cat, $arg, '');
        
        return Yii::app()->settings->get($cat, $arg);
    }
    
    public function checkIp()
	{
        $ips = explode(' ', Aii::param('ips'));
        if(!in_array($_SERVER['REMOTE_ADDR'], $ips))
            exit('You are not allowed to access from current IP.');
    }
    
}