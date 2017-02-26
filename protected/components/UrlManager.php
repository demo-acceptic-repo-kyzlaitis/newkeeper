<?php

class UrlManager extends CUrlManager
{    
    public $default_lang = 'ru';
    
    public function createUrl($route, $params=array(), $ampersand='&')
    {
        $prefix = '/';
        $langs = array_flip(Yii::app()->params['languages']);
        
        if (empty($params['language']) && Yii::app()->language !== $this->default_lang)
        {
            $prefix = $langs[Yii::app()->language]."/";//var_dump(Yii::app()->language);exit;
        }
        
        if($route != '/')
            $route = trim($route,"/");
        else if(Yii::app()->language == $this->default_lang)
            $route = $this->default_lang;
        //if($route = '/'){
            //$route = '/';
//var_dump($prefix.$route);exit;
//}
        return parent::createUrl($prefix.$route, $params, $ampersand);
    }
}