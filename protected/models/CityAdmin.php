<?php

class CityAdmin extends City
{   
    public $adminName='Города (темп-ра, траффик)'; // will be displayed in main list
    public $pluralNames=array(
        'Город (Code Yahoo: на сайте weather.com, введя в поиск город и попав на его страницу, копируем код из ссылки: http://www.weather.com/weather/today/Simferopol+<span style="color:green; text-decoration:underline;">UPXX0054</span>:1:UP)',
        'Города'
    );   
    public $country_idChoices;
    public $statusChoices;
    
    public function __construct($scenario='insert')
    {
        parent::__construct($scenario);
        $this->country_idChoices = self::getCountriesAdmin();
        $this->statusChoices = array(1=>'Активен',0=>'Неактивен');
    }
    
    public function adminSearch()
    {
        $columns = array(
            array(
                'class'=>'CCheckBoxColumn',
                'selectableRows' => null,
                'checkBoxHtmlOptions' => array('class' => 'classname'),
            ),
    		'name_ru',
            array(
                'name'=>'country_id',
                'value'=>'$data->country->name_ru'
            ),
            'temp',
            'traffic',
            array(
                'name'=>'status',
                'value'=>'$data->getStatus()',
                'filter'=>$this->statusChoices,
            ),
        );
        
        $total_columns = $columns;
        
        return array('columns' => $total_columns);
    }

    // Config for attribute widgets
    public function attributeWidgets()
    {
        return array(
            array('name_ru', 'textFiled'),
            array('name_uk', 'textFiled'),
            array('temp', 'textFiled'),
            array('text_temp', 'textFiled'),
            array('traffic', 'textFiled'),
            array('code_yahoo', 'textFiled'),
            array('lat', 'textFiled'),
            array('lng', 'textFiled'),
            array('country_id', 'dropDownList'),
            array('status', 'dropDownList'),
        );
    }
        
    public function getCountriesAdmin()
    {
        $all = NetCountry::model()->findAll(array("order"=>"name_ru"));
        $out = array();
        
        foreach($all as $c)
        {
            $out[$c['id']] = $c['name_ru']; 
        }
        
        return $out;
    }

}