<?php


class UserAdmin extends User
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;
    
    public $adminName='Пользователи'; // will be displayed in main list
    public $pluralNames=array('Пользователя','Пользователи');
    public $statusChoices;
    
    public function __construct($scenario='insert')
    {
        parent::__construct($scenario);
        $this->statusChoices = self::getStatuses();
    }
    
    public function adminSearch()
    {
	    $columns = array(
            array(
                'class'=>'CCheckBoxColumn',
                'selectableRows' => null,
                'checkBoxHtmlOptions' => array('class' => 'classname'),
            ),
    		array(
    			'name' => 'username',
    			'type'=>'raw',
    			'value' => 'CHtml::link($data->username,array("/yiiadmin/manageModel/update","pk"=>$data->id,"model_name"=>"UserAdmin"))',
    		),
    		array(
    			'name'=>'email',
    			'type'=>'raw',
    			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
    		),
    		'created',
    		'lastvisit_at',
    		array(
    			'name'=>'superuser',
    			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
    			'filter'=>User::itemAlias("AdminStatus"),
                'htmlOptions'=>array("width"=>"30px"),
    		),
    		array(
    			'name'=>'status',
    			'value'=>'User::itemAlias("UserStatus",$data->status)',
    			'filter' => User::itemAlias("UserStatus"),
                'htmlOptions'=>array("width"=>"60px"),
    		),
            array(
                'name'=>'profile.first_name_ru',
                //'value'=> '$data->getFullName()',
            ),
            array(
                'name'=>'profile.last_name_ru',
                //'value'=> '$data->getFullName()',
            ),/*
            array(
                'name'=>'profile.avatar_source',
            ),*/
		);
        
        $total_columns = $columns;
        
        return array('columns' => $total_columns);
    }
    
    public function attributeWidgets()
    {
        return array(
            array('status','dropDownList'),
            array('superuser','boolean'),
            array('created','calendar'),
            array('lastvisit_at','calendar'),
        );
    }
    
	static public function getStatuses()
	{
        return array(
		  self::STATUS_ACTIVE => Yii::t('app','Активен'),
		  self::STATUS_NOT_ACTIVE => Yii::t('app','Неактивен'),
        );
	}
}