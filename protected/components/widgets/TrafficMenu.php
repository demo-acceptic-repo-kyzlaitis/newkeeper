<?php

Yii::import('zii.widgets.CMenu', true);

class TrafficMenu extends CMenu
{
    public function init()
    {
        $this->htmlOptions['class']='overview';
        $this->htmlOptions['id']='overview-2';
        
        $items = City::model()->active()->traffic()->findAll();
        
        if(!Yii::app()->user->isGuest){
			$user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
			if(!is_null($user_prefs)){
				Yii::app()->session["traffic_city_id"] = $user_prefs->traffic_city_id;
			}
		}
		
		if(!isset(Yii::app()->session["traffic_city_id"]))
		{
            $city = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('city')
                    ->order('name_'.Yii::app()->language)
                    ->queryScalar();
			Yii::app()->session["traffic_city_id"] = $city;
		}
        
        foreach ($items as $item)
        {
            $class = '';
            if($item->id == Yii::app()->session["traffic_city_id"])
                $class = 'active';
            
            $this->items[] = array(
            	'label'=>$item->getName(),
                'url'=>'/city/gettraffic/'.$item->id,
                'linkOptions'=>array(
                   'type' => 'POST',
                   'update'=>'#traffic, #traffic_top',
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