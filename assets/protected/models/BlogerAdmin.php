<?php



class BlogerAdmin extends Bloger
{
    public $adminName='Блоггеры'; // will be displayed in main list
    public $pluralNames=array('Блоггера','Блоггеры');
    public $statusChoices;
    public $user_idChoices;
    public $adminkaHiddenValue = 1;
    public $user_idPredefined;
    
    public function __construct($scenario='insert')
    {
        parent::__construct($scenario);
        $this->statusChoices = self::getStatuses();
        $this->user_idChoices = self::getUsersNotBlogers();
        //$this->user_idPredefined = User::getUsername(Yii::app()->user->id);
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
                'header'=>'Пользователь',
                'type'=>'raw',
                'value'=>'CHtml::link($data->user->username, "http://' . $_SERVER['HTTP_HOST'] . '/news/blog/".$data->id, array("target"=>"_blank"))',
                'filter'=>self::getUsers(),
            ),
    		'pen_name_en',
    		'pen_name_ru',
    		'pen_name_uk',
    		'phone',
            array(
                'name'=>'status',
                'value'=>'$data->getStatusTitle()',
                'filter'=>self::getStatuses(),
            ),
		);
        //var_dump(self::statsColumns());exit;
        $total_columns = array_merge($columns,self::statsColumns());
        //var_dump($total_columns);exit;
        return array('columns' => $total_columns);
    }
    
    public function attributeWidgets()
    {
        return array(
            array('user_id','dropDownList'),
            array('status','dropDownList'),
            array('tried','boolean'),
            array('journalist','boolean'),
            array('adminka','hidden'),
        );
    }
    
    public function excludeUpdate()
    {
        return array(
            'user_id',
        );
    }
    
    public static function getUsersNotBlogers()
    {
        $all = User::model()->with(array(
            'bloger'=>array(
                // записи нам не потрібні
                'select'=>false,
                // але потрібно вибрати тільки користувачів з опублікованими записами
                'joinType'=>'LEFT OUTER JOIN',
                'condition'=>'bloger.user_id is null',
            ),
        ))->findAll();
        $out = array();
        
        foreach($all as $c)
        {
            $out[$c['id']] = $c['username'];
        }
        
        return $out;
    }
       
    public function getUsers()
    {
        $users = User::model()->with(array(
            'bloger'=>array(
                // записи нам не потрібні
                'select'=>false,
                // але потрібно вибрати тільки користувачів з опублікованими записами
                'joinType'=>'LEFT JOIN',
                'condition'=>'bloger.user_id=0',
            ),
        ))->findAll();
        
        return $users;
    }
}