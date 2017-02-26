<?php

class LangMenuSelect extends LangMenu
{    
    protected function renderMenu($items)
    {
    	if(count($items))
    	{
    		echo CHtml::openTag('div',$htmlOptions = array ('class'=>'radio-container'))."\n";
    		echo CHtml::openTag('div',$htmlOptions = array ('class'=>'radio-options'))."\n";
    		echo CHtml::openTag('div',$htmlOptions = array ('class'=>'toggle'))."\n";
            /*
    		$uri = explode('/',$_SERVER['REQUEST_URI']);
    		$uri_1 = $uri[1];
    		switch ($uri_1) {
    			case 'ru':
    				$uri_1 = "Rus";
    				break;
    			case 'en':
    				$uri_1 = "Eng";
    				break;
    			case 'ua':
    				$uri_1 = "Ua";
    				break;	
    		}
            if ( $uri_1 != 'ru' || 'en' || 'ua' ) {
                $uri_1 = "Rus";
            }
    		echo $uri_1;
            */
    		echo CHtml::closeTag('div')."\n";
    		echo CHtml::openTag('ul',$this->htmlOptions)."\n";
    		$this->renderMenuRecursive($items);
    		echo CHtml::closeTag('ul')."\n";
    		
    		echo CHtml::closeTag('div');
    	}
    }
    
    protected function renderMenuItem($item)
    {
    	if(isset($item['url']))
    	{
            $label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
            //var_dump(CHtml::link($label,$item['url'],isset($item['htmlOptions']) ? $item['htmlOptions'] : array()));exit;
            $url_1 = substr($item['url'], 1, 2);
            $uri = explode('/',$_SERVER['REQUEST_URI']);

            if($this->i18n[$url_1] == Yii::app()->language)
                $check = "checked = 'checked'";
                
    		return '<li><input type="radio" onclick="goLocation(this)" data-url="' . $item['url'] . '" value="' . $url_1 .'"  '. $check .'  /><label>' . $label . '</label></li>';
            CHtml::link($label,$item['url'],isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    	}
    	else
    		return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label'], isset($item['htmlOptions']) ? $item['htmlOptions'] : array());
    }
    
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if(isset($item['active']) && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}

			//echo CHtml::openTag('li', $options);

			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			//echo CHtml::closeTag('li')."\n";
		}
	}
}