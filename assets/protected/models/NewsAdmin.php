<?php



class NewsAdmin extends News
{
    public $adminName='Новости'; // will be displayed in main list
    public $pluralNames = array('Новость','Новости');
    public $category_idChoices;
    public $categoriesChoices;
    public $author_idPredefined;
    public $type_idChoices;
    public $langChoices;
    public $statusChoices;

    public function __construct($scenario='insert')
    {
        parent::__construct($scenario);
        $this->category_idChoices = self::getCategoriesAdmin();
        $this->categoriesChoices = self::getCategoriesAdmin();//self::getEntitiesAdmin('Category');
        //var_dump($this->categoriesChoices);exit;
        //$this->author_idChoices = self::getAuthorsAdmin();
        $this->type_idChoices = self::getTypes();
        $this->langChoices = self::getLangsAdmin();
        $this->statusChoices = self::getStatuses();
        
        $this->stats['Просмотры за день'] = 'day_views_count';
        //$this->author_idPredefined = array(Yii::app()->user->id => User::getUsername(Yii::app()->user->id));
    }

    // Config for CGridView class
    public function adminSearch()
    {
        $columns = array(
                array(
                    'class'=>'CCheckBoxColumn',
                    'selectableRows' => null,
                    'checkBoxHtmlOptions' => array('class' => 'classname'),
                ),
                array(
                    'name'=>'name_ru',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->name_ru, "http://' . $_SERVER['HTTP_HOST'] . '#".$data->getPopupslug(), array("target"=>"_blank"))',
                    //'value'=>'CHtml::link($data->name_ru,NKHelper::createAdminUrl("update",' . __CLASS__ . ',$data->id))',
                    //'value'=>'CHtml::link(substr($data->name_ru,0,50)."...",NKHelper::createAdminUrl("update",' . __CLASS__ . ',$data->id))',
                ),/*
                array(
                    'name'=>'author_id',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->author->username,NKHelper::createAdminUrl("update","User",$data->author_id))',
                ),*/
                array(
                    'name'=>'source',
                    'type'=>'raw',
                    //'value'=>'CHtml::link($data->source,$data->source,array("target"=>"_blank"))',
                    'value'=>'CHtml::link(substr($data->source,0,20)."...",$data->source,array("target"=>"_blank"))',
                ),
                array(
                    'name'=>'hot',
                    'value'=>'$data->hot==1 ? CHtml::encode("Да") : CHtml::encode("Нет")',
                    'filter'=>array(1=>'Да',0=>'Нет'),
                ),
                array(
                    'name'=>'status',
                    'value'=>'$data->getStatus()',
                    'filter'=>News::getStatuses(),
                ),
                array(
                    'name'=>'blog',
                    'value'=>'$data->hot==1 ? CHtml::encode("Да") : CHtml::encode("Нет")',
                    'filter'=>array(1=>'Блог',0=>'Не блог'),
                ),
                /*array(
                    'name'=>'type_id',
                    'value'=>'$data->getType()',
                    'filter'=>self::getTypes(),
                ),
                array(
                    'name'=>'video_src',
                    //'type'=>'raw',
                    'value'=>'substr($data->video_src,0,50)."..."',
                ),*/
                array(
                    'name'=>'preview_source',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->preview(50), "http://' . $_SERVER['HTTP_HOST'] . '#".$data->getPopupslug(), array("target"=>"_blank"))',
                ),
                array(
                    'name'=>'category_id',
                    'value'=>'$data->getCategoryName()',
                    'filter'=>self::getCategories(),
                ),
        );
        
        $total_columns = array_merge($columns,self::statsColumns());
        
        return array('columns' => $total_columns);
    }

    // Config for attribute widgets
    public function attributeWidgets()
    {
        //dd($this->slug);
        return array(
            array('source','textField'),
            array('fixed','boolean'),
            //array('ru','boolean'),
            //array('uk','boolean'),
            //array('lang','dropDownList'),
            //array('name_en','textField'),
            //array('text_en','tinyArea'),
            array('text_ru','tinyArea'),
            //array('text_uk','tinyArea'),
            array('name_ru','textField'),
            //array('name_uk','textField'),
            array('teaser_ru','textArea'),
            array('teaser_uk','textArea'),
            array('preview_source','image'),
            //array('category_id', 'dropDownList'),
            array('categories', 'checkboxes'),
            //array('type_id', 'dropDownList'),
            array('status','dropDownList'),
            array('hot','boolean'),
            //array('blog','boolean'),
            array('author_id', 'predefined'),
            array('slug', 'textField'),
            array('create_time', 'calendar', array(
                'decode_rule' => 'date',
            )),
        );
    }
    
    public function excludeUpdate()
    {
        return array(
            'author_id',
        );
    }

    public static function getCategoriesAdmin()
    {
        $all = Category::model()->findAll();
        $out = array();
        
        foreach($all as $c)
        {
            $out[$c['id']] = $c['name_ru'];
        }
        return $out;
    }

    public static function getAuthorsAdmin()
    {
        $all = Bloger::model()->with('user')->findAll(array(
            'order'=>'user.email'
        ));
        $out = array();
        
        foreach($all as $c)
        {
            $out[$c->user['id']] = $c->user['email'];
        }
        return $out;
    }
}