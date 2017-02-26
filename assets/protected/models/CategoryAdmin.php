<?php


class CategoryAdmin extends Category
{
    public $adminName='Категории'; // will be displayed in main list
    public $pluralNames=array('Категорию','Категории');

    public function __construct($scenario='insert')
    {
        parent::__construct($scenario);
        
        $this->stats['Кол-во новостей'] = 'news_count';
    }
    
    public function adminSearch()
    {
	    $columns = array(
            array(
                'class'=>'CCheckBoxColumn',
                'selectableRows' => null,
                'checkBoxHtmlOptions' => array('class' => 'classname'),
            ),
    		//'name_en',
            array(
                'name'=>'name_ru',
                'type'=>'raw',
                'value'=>'CHtml::link($data->name_ru, "http://' . $_SERVER['HTTP_HOST'] . '/news/category/".$data->id, array("target"=>"_blank"))',
            ),
            array(
                'name'=>'name_en',
                'type'=>'raw',
                'value'=>'CHtml::link($data->name_en, "http://' . $_SERVER['HTTP_HOST'] . '/news/category/".$data->id, array("target"=>"_blank"))',
            ),
    		//'name_uk',
            array(
                'name'=>'media_source',
                'type'=>'html',
                'value'=>'$data->adminThumb(50)',
            ),
		);
        
        $total_columns = array_merge($columns,self::statsColumns());
        
        return array('columns' => $total_columns);
    }

    // Config for attribute widgets
    public function attributeWidgets()
    {
        return array(
            array('media_source','image'),
            array('name_ru','textField'),
            array('name_uk','textField'),
        );
    }
}