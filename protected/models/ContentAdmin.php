<?php



class ContentAdmin extends Content
{
    public $adminName='Текстовые области'; // will be displayed in main list
    public $pluralNames=array('Текстовую область','Текстовые области');
    
    public function adminSearch()
    {
        $columns = array(
            array(
                'class'=>'CCheckBoxColumn',
                'selectableRows' => null,
                'checkBoxHtmlOptions' => array('class' => 'classname'),
            ),
    		'name',
    		//'title_en',
    		'title_ru',
    		//'title_uk',
    		//'text_en',
    		//'text_ru',
    		//'text_uk',
        );
        
        $total_columns = $columns;
        
        return array('columns' => $total_columns);
    }

    // Config for attribute widgets
    public function attributeWidgets()
    {
        return array(
            array('text_ru','tinyArea'),
            array('text_uk','tinyArea'),
            array('title_ru','textField'),
            array('title_uk','textField'),
            array('name','textField'),
        );
    }
}