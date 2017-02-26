<?php

/**
 * YiiadminModule 
 * 
 * @uses CWebModule
 * @package YiiAdmin
 * @version $id$
 * @copyright 2010 
 * @author Firstrow <firstrow@gmail.com> 
 * @license BSD
 */
class YiiadminModule extends CWebModule
{
    private $_assetsUrl;
    protected $model;
    public $attributesWidgets=null;
    public $_modelsList=array();
    public static $fileExt='.php';
    private $controller;
    public $password;   
    public $registerModels=array();
    public $excludeModels=array();
    private static $adminModels=array(
        'SettingAdmin',
    );

	public function init()
	{
	    if(!Yii::app()->getModule('user')->isAdmin())
        {
	        Aii::checkIp();
            self::checkAccess();
        }
           
        error_reporting(E_ALL ^ E_NOTICE);
        Yii::app()->clientScript->registerCoreScript('jquery');

        Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'errorAction'=>'yiiadmin/default/error',
			),/*
			'user'=>array(
				'class'=>'WebUser',
				'stateKeyPrefix'=>'yiiadmin',
				'loginUrl'=>Yii::app()->createUrl('yiiadmin/default/login'),
			),*/
		));

		$this->setImport(array(
			'yiiadmin.models.*',
			'yiiadmin.components.*',
            'zii.widgets.grid.CGridColumn',
		));
	}

	public function checkAccess()
	{
	    if(in_array($_GET['model_name'], self::$adminModels))
        {
            exit('Access denied.');
        }
	}

    /**
     * Получение списка моделей
     * 
     * @access public
     * @return void
     */
    public function getModelsList()
    {
        $models=$this->registerModels;
    
        if (!empty($models))
        {
            foreach($models as $model)
            {
                // Импорт всех моделей(модели)
                Yii::import($model);
                if (substr($model, -1)=='*')
                {
                    // Если импортируем директорию с моделями,
                    // Получим список моделей
                    $files=CFileHelper::findFiles(Yii::getPathOfAlias($model));
                    if ($files)
                    {
                        foreach($files as $file)
                        {
                           $class_name=str_replace(self::$fileExt,'',substr(strrchr($file,DIRECTORY_SEPARATOR), 1));
                           $this->addModel($class_name);
                        }
                    }
                }
                else
                {
                    $class_name=substr(strrchr($model, "."), 1);
                    $this->addModel($class_name);
                }
            }
        }

        return array_unique($this->_modelsList);
    }

    /**
     * Добавление модели в список.
     * 
     * @param mixed $name 
     * @access protected
     * @return void
     */
    protected function addModel($name)
    {
        if (!in_array($name,$this->excludeModels))
            $this->_modelsList[]=$name;
    }

    /**
     * Загрузка модели
     * 
     * @param string $name 
     * @access public
     * @return object
     */
    public function loadModel($name)
    {
        $model=(string)$_GET['model_name'];
        $this->model=new $model;
        return $this->model;
    }

    public function createWidget($form,$model,$attribute,$update=0, $widget_arr = array())
    {
        $field_attrs = array();
        $dbType=$model->tableSchema->columns[$attribute]->dbType;
        
        if(!isset($widget_arr['widget']))
            $widget = $this->getAttributeWidget($attribute);
        else
            $widget = $widget_arr['widget'];
        
        if($update && $widget == 'dropDownList')
            $widget = 'predefined';
            //var_dump($widget_arr);exit;
        if(isset($widget_arr['decode_rule']))
        {
            $func = $widget_arr['decode_rule'];
            $field_attrs['value'] = $func($model->$attribute);
        }
        
        switch ($widget)
        {
            case 'textArea';
                return $form->textArea($model,$attribute,$field_attrs);
            break;
            
            case 'tinyArea';
                $field_attrs['class'] = 'do_tiny';

                return $form->textArea($model,$attribute,$field_attrs);
            break;
            
            case 'textField';
                $field_attrs['class'] = 'vTextField';
                
                return $form->textField($model,$attribute,$field_attrs);
            break;
            
            case 'predefined';
                $para = $this->getAttributePredefined($model,$attribute);
                return $para . $form->hiddenField($model,$attribute,array('value'=>$model->$attribute));
            break;
            
            case 'hidden';
                //$para = $this->getAttributeHiddenValue($attribute);
                return $form->hiddenField($model,$attribute,$field_attrs);
            break;

            case 'dropDownList':
            	$options = array();
            	
            	if(isset($widget_arr['empty']))
            		$options = array('empty' => $widget_arr['empty']);
            		
                return $form->dropDownList($model,$attribute,$this->getAttributeChoices($attribute), $options);
            break;

            case 'calendar': 
                $field_attrs['class'] = 'calendar';
                
				$out = $model->$attribute;
                
                if(isset($widget_arr['decode_rule']))
                {
                	$func = $widget_arr['decode_rule'];
                	if($model->$attribute < 1000000)
                		$model->$attribute = time();
					$out = $func('Y-m-d H:i:s', $model->$attribute);
				}
				
				$field_attrs['value'] = $out;
                
                return $form->textField($model,$attribute,$field_attrs);
            break;

            case 'boolean':
                return $form->checkBox($model,$attribute); 
            break;
/*
            case 'checkboxes':
                return $form->checkBoxList($model,$attribute,$this->getAttributeChoices($attribute));
            break;*/

            case 'checkboxes':
                $id_arr = array();
                foreach($model->$attribute as $cat)
                {
                    $id_arr[] = (int)$cat->id;
                }
                $prop = $attribute . '_id';
                $model->$prop = $id_arr;//var_dump($model->$attribute);exit;
                return $form->checkBoxList($model, $prop, $this->getAttributeChoices($attribute), array('multiple'=>true));
            break;

            case 'image':
                $img_str = '<div id="0" class="display_thumb">' .
                '<div class="img_cont">' .
                    CHtml::image('/uploads/preview/'.$model->$attribute,'',array('id'=>'preview_src')) .
                    '<img id="change_arrow" src="/images/Forward_Arrow1.png" />' .
                    '<img src="" id="result" />' .
                '</div>' .
                '<div class="pic_button">' .
                    '<div class="upload_button">' .
                        '<a href="javascript:void()" id="addPic" class="btn btn-success">Загрузить фото</a>' .
                        '<input id="fileupload" type="file" name="loadedFile" data-url="/news/upload" />' .
                    '</div>' .
                    '<a href="javascript:void()" id="resetcrop" class="btn btn-danger">Отмена</a>' .
                '</div>' . 
                '<div class="note">Изображение должно быть не менее ' . News::PREVIEW_SIZE . 'x' . News::PREVIEW_SIZE . 'px</div>' .
                '<div class="note">Допустимые форматы: .jpg, .jpeg, .png</div>' .
                '<div class="note">Максимальный размер ' . floor(News::PREVIEW_WEIGHT / 1024 / 1024) . ' Мб</div>' .
                '</div>' . $form->hiddenField($model,$attribute,array());

                return $img_str;
            break;

            default:
                return $form->textField($model,$attribute,array('class'=>'vTextField')); 
            break;
        }
    }

    protected function getAttributeWidget($name)
    {
        if ($this->attributesWidgets!==null)
        {
            if (isset($this->attributesWidgets->$name))
                return $this->attributesWidgets->$name;
            else
            {
                $dbType=$this->model->tableSchema->columns[$name]->dbType; 
                if ($dbType=='text')
                    return 'textArea';
                else
                    return 'textField';
            }
        }

        if (method_exists($this->model,'attributeWidgets'))
            $attributeWidgets=$this->model->attributeWidgets();
        else
            return null;

        $temp=array();

        if (!empty($attributeWidgets))
        {
            foreach($attributeWidgets as $key=>$val)
            {
                if (isset($val[0]) && isset($val[1]))
                {
                    $temp[$val[0]]=$val[1];
                    $temp[$val[0].'Data']=$val;
                }
            }
        }

        $this->attributesWidgets=(object)$temp;

        return $this->getAttributeWidget($name);
    }

    protected function getAttributeData($attribute)
    {
        $attribute.='Data';
        if (isset($this->attributesWidgets->$attribute))
            return $this->attributesWidgets->$attribute;
        else
            return null;
    }

    /**
     * Получение массива значений атрибута.
     * Имя переменной массива с значениями должно быть: attributeNameChoices. 
     * Например categoryChoices.
     * 
     * @param mixed $attribute 
     * @access private
     * @return array
     */
    private function getAttributeChoices($attribute)
    {
        $data=array();
        $choicesName=(string)$attribute.'Choices';
        if (isset($this->model->$choicesName) && is_array($this->model->$choicesName))
            $data=$this->model->$choicesName;
        
        return $data;
    }
    
    private function getAttributePredefined($model,$attribute)
    {
        $data='';
        $choicesName=(string)$attribute.'Predefined';
        if (isset($model->$choicesName))
            $data=$model->$choicesName;
            
        return $data;
    }
    
    private function getAttributeHiddenValue($attribute)
    {
        $data='';
        $choicesName=(string)$attribute.'HiddenValue';
        if (isset($this->model->$choicesName))
            $data=$this->model->$choicesName;
        
        return $data;
    }

    public function getModelNamePlural($model)
    {
        if (is_string($model)){
            $model=new $model;
        }
        if (isset($model->adminName))
            return $model->adminName;
        else
            return get_class($model);
    }

    public function getObjectPluralName($model, $pos=0)
    {
        if (is_string($model))
            $model=new $model; 

        if (!isset($model->pluralNames))
            return get_class($model);
        else
            return $model->pluralNames[$pos];
    }

	/**
	 * @return string the base URL that contains all published asset files.
	 */
	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
			$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.yiiadmin.assets'));
		return $this->_assetsUrl;
	}

	/**
	 * @param string the base URL that contains all published asset files.
	 */
	public function setAssetsUrl($value)
	{
		$this->_assetsUrl=$value;
	}

    public static function createActionUrl($action,$pk)
    {
        $a=new CController;
        return $a->createUrl('manageModel',$data->primaryKey);
    }

    public static function t($message)
    {
        return Yii::t('YiiadminModule.yiiadmin',$message);
    }

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            $this->controller=$controller;
			$route=$controller->id.'/'.$action->id;

			$publicPages=array(
				'default/login',
				'default/error',
			);
			if($this->password!==false && Yii::app()->user->isGuest && !in_array($route,$publicPages))
				Yii::app()->user->loginRequired();
			else
				return true;
		}
		return false;
	}
}
