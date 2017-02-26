<?php



class WidgetCurrencyElementAdmin extends WidgetCurrencyElement
{
    public $adminName='Валюта'; // will be displayed in main list
    public $pluralNames=array('Валюту','Валюта');
    
    public function adminSearch()
    {
        $columns = array(
            array(
                'class'=>'CCheckBoxColumn',
                'selectableRows' => null,
                'checkBoxHtmlOptions' => array('class' => 'classname'),
            ),
    		'name',
    		'buy',
    		'sale',
        );
        
        $total_columns = $columns;
        
        return array('columns' => $total_columns);
    }
}