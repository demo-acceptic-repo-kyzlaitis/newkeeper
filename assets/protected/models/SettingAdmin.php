<?php

class SettingAdmin extends Setting
{
    public $adminName = 'Параметры';
    public $pluralNames = array('Параметр','Параметры');
    
    public function fillChoices()
    {
        
    }
    
    public function attributeWidgets()
    {
        return array(
            array('category', 'hidden', array(
                'val' => 'param',
                'widget' => 'hidden',
            )),
            array('title', 'textField', array(
            )),
            array('key', 'textField', array(
            )),
            array('value', 'textArea', array(
                'decode_rule' => 'unserialize',
                //'note' => 'Посилання зберігайте без "http://"',
            )),
        );
    }

    // Config for CGridView class
    public function adminSearch()
    {
        return array(
                // Data provider, by default is "search()"
                //'dataProvider'=>$this->search(),
            'columns'=>array(
                array(
                    'class'=>'CCheckBoxColumn',
                    'selectableRows' => null,
                    'checkBoxHtmlOptions' => array('class' => 'classname'),
                ),
                //'category',
                array(
                    'name'=>'title',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->title, YaHelper::createAdminUrl("update",' . __CLASS__ . ',$data->id))',
                ),
                array(
                    'name'=>'key',
                    'type'=>'raw',
                    'value'=>'CHtml::link($data->key, YaHelper::createAdminUrl("update",' . __CLASS__ . ',$data->id))',
                ),
                array(
                    'name'=>'value',
                    'type'=>'raw',
                    'value'=>'CHtml::link(unserialize($data->value), YaHelper::createAdminUrl("update",' . __CLASS__ . ',$data->id))',
                ),
            ),
        );
    }

}