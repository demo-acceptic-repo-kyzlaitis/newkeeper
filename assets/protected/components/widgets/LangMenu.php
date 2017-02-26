<?php

Yii::import('zii.widgets.CMenu', true);

class LangMenu extends CMenu
{
    public $lang_title = array(
        /*'en'=>'Eng',*/
        //'ru'=>'Rus',
        //'ua'=>'Ua'
    );
    public $i18n = array(
                //'en'=>'en',
                'ru'=>'ru',
                //'ua'=>'uk',
            );
    
    public function init()
    {
        $this->htmlOptions['class']='languages';
		if(!Yii::app()->user->isGuest){
			$user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
			if(!is_null($user_prefs)){
				Yii::app()->session["lang"] = $user_prefs->lang;
			}
		}
		if(!isset(Yii::app()->session["lang"])){
			Yii::app()->session["lang"] = Yii::app()->sourceLanguage;
		}
    	$uri = explode('/',$_SERVER['REQUEST_URI']);
        foreach ($this->lang_title as $k=>$v){
            if(array_key_exists($uri[1],$this->i18n)){
                $uri[1] = $k;
                $new_uri = implode("/",$uri);
            }else
                $new_uri = '/'.$k.$_SERVER['REQUEST_URI'];
                
            $class = $k;
            if($this->i18n[$k] == Yii::app()->language)
	        $class .= " "."active";
            $this->items[] = array(
            	'label'=>$v,
                'url'=>$new_uri,
                'itemOptions'=>array('class' => $class),
            );
    	}
    }
    
    protected function renderMenu($items)
    {
    	if(count($items))
    	{
    		echo CHtml::openTag('ul',$this->htmlOptions)."\n";
    		$this->renderMenuRecursive($items);
    		echo CHtml::closeTag('ul');
    	}
    }
    
    protected function renderMenuItem($item)
    {
    	if(isset($item['url']))
    	{
            $label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
    		return CHtml::link($label,$item['url'],isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    	}
    	else
    		return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label'], isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    }
}