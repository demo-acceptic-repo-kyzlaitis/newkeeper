<?php

Yii::import('zii.widgets.CMenu', true);

class ActiveMenu extends CMenu
{
    public $id = 'mainNavbar';
    
    public function init()
    {
        $this->htmlOptions['id']=$this->id;
        $this->htmlOptions['class']='main_nav';
        // Here we define query conditions.
        $this->items[] = array('label'=>Yii::t("app","Мой набор"), 'url'=>Yii::app()->createUrl('/news/mynews'));
        if($_SERVER["REQUEST_URI"] == "/")
            $active = 'active';
        else
            $active = '';
        $this->items[] = array('label'=>Yii::t("app","Все темы"), 'url'=>Yii::app()->createUrl('/news'), 'itemOptions'=>array('class'=>"menus_bord ".$active));
        
        $criteria = new CDbCriteria;
        //$criteria->condition = '`status` = 1';
        $criteria->order = '`showorder` ASC';

        $items = Category::model()->findAll($criteria);

        foreach ($items as $item)
            $this->items[] = array('label'=>$item->getName(), 'url'=>Yii::app()->createUrl('/news/category/' . $item->slug));
            
        //$this->items[] = array('label'=>Yii::t("app","Блоги"), 'url'=>Yii::app()->createUrl('/bloger')/*, 'itemOptions'=>array('class'=>"menus_bord_left")*/);
        
        foreach($this->items as $k=>$item)
        {
            if($item["url"] == $_SERVER["REQUEST_URI"] || $item["url"] == substr($_SERVER["REQUEST_URI"],3)){
                $class = "active";
                if($item["url"] == '/ua/news' || $item["url"] == '/news' || $item["url"] == '/en/news' || $item["url"] == '/ru/news')
                    $class .= ' menus_bord';
                $this->items[$k]['itemOptions'] = array('class'=>$class);
            }
        }
    }
}