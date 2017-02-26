<?php

Yii::import('zii.widgets.CMenu', true);

class WeatherMenu extends CMenu
{

	public $html_id;
	
    public function init()
    {
        $this->htmlOptions['class']='overview';
		if(!isset($this->html_id) || !$this->html_id) $this->html_id='1';
        $this->htmlOptions['id']='overview-'.$this->html_id;
        $criteria = new CDbCriteria;
        //$criteria->join = 'LEFT JOIN city c ON t.city_id = c.id';
        $criteria->order = 'name_'.Yii::app()->language.' ASC';
        $items = City::model()->findAll($criteria);

        if(!Yii::app()->user->isGuest){
		$user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
    		if(!is_null($user_prefs)){
    			Yii::app()->session["weather_city_id"] = $user_prefs->weather_city_id;
    		}
    	}
    	if(!isset(Yii::app()->session["weather_city_id"])){
                $city = Yii::app()->db->createCommand()
                        ->select('id')
                        ->from('city')
                        ->order('name_'.Yii::app()->language)
                        ->queryScalar();
    		Yii::app()->session["weather_city_id"] = $city;
    	}
        //CVarDumper::dump(Yii::app()->session["weather_city_id"]);

        foreach ($items as $item){
            $class = '';
            if($item->id == Yii::app()->session["weather_city_id"])
                $class = 'active';
            $this->items[] = array('label'=>$item->getName(),
                                   'url'=>'/city/gettemp/'.$item->id,
                                   'linkOptions'=>array(
                                       'type' => 'POST',
                                       'update'=>'#temperature, #temperature_top',
                                    ),
                                    'htmlOptions'=>array(
                                       'class' => $class,
                                    ),
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
		return CHtml::ajaxLink($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array(), isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
	}
	else
		return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    }
}