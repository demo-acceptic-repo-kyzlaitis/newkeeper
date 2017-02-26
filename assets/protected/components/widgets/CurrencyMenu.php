<?php

Yii::import('zii.widgets.CMenu', true);

class CurrencyMenu extends CMenu
{
    public function init()
    {
        $this->htmlOptions['class']='currency';
        $criteria = new CDbCriteria;
        //$criteria->order = '`city_'.Yii::app()->language.'` ASC';

        $items = WidgetCurrencyElement::model()->findAll($criteria);
        
		if(!Yii::app()->user->isGuest){
			$user_prefs = UserPreferences::model()->findByPk(Yii::app()->user->id);
			if(!is_null($user_prefs)){
				$active = $user_prefs->currency_id;
			}
		}

        foreach ($items as $item){
            $class = '';
            if(!Yii::app()->user->isGuest && $item->id == $active){
                $class = 'active';
            }else{
                if($item->id == Yii::app()->session["currency_id"])
                $class = 'active';
            }
            //if($class == 'active')//var_dump($active);exit;
            $this->items[] = array('label'=>$item->name,
                                   'url'=>'javascript:void(0)',
                                   /*'linkOptions'=>array(
                                        'type' => 'POST',
                                        'dataType' => 'json',
                                        'success'=>new CJavaScriptExpression("function(html){
                                            currency(html);
                                        }"),
                                        'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                                    ),*/
                                    'htmlOptions'=>array(
                                       'class' => $class,
                                       'id' => 'wc'.$item->id,
                                    ),
                            );
        }
    }
    
    protected function renderMenu($items)
    {
    	if(count($items))
	    {
    		echo CHtml::openTag('ol',$this->htmlOptions)."\n";
    		$this->renderMenuRecursive($items);
    		echo CHtml::closeTag('ol');
	    }
    }
    
    protected function renderMenuItem($item)
    {
    	if(isset($item['url']))
    	{
        	$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
    		return CHtml::ajaxLink($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array(), isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    	}else
		    return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label'], isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    }
}