<?php
/**
 * ManageModelController 
 * 
 * @uses YAdminController
 * @package yiiadmin
 * @version $id$
 * @copyright 2010 firstrow@gmail.com
 * @author Firstrow <firstrow@gmail.com> 
 * @license BSD
 */

/**
 * Управление данными модели. Вывод, редактирование, удаление.
**/
class ManageModelController extends YAdminController
{

    public function behaviors()
    {
        return array(
            'eexcelview'=>array(
                'class'=>'application.components.behaviors.EExcelBehavior',
            ),
        );
    }
    
    public function actionIndex()
    {

    }

    /**
     * Вывод списка записей модели.
     * 
     * @access public
     * @return void
     */
    public function actionList()
    {
        $model_name=(string)$_GET['model_name'];
        if(isset($_GET['status']))        
            $status=(int)$_GET['status'];
        else
            $status = false;                                    
        $model=$this->module->loadModel($model_name);
        $model->unsetAttributes();
        $model->status = $status;

        if (isset($_GET[get_class($model)]))
            $model->attributes=$_GET[get_class($model)];

        $this->breadcrumbs=array(
            $this->module->getModelNamePlural($model),
        );

        if (method_exists($model,'adminSearch'))
            $data1=$model->adminSearch();
        else
            $data1=array();

        $url_prefix='Yii::app()->createUrl("yiiadmin/manageModel/';
        
        /* row numbers per page */
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);  // would interfere with pager and repetitive page size change
        }
        
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        /* row numbers per page END */
        //var_dump($model->newsCount);exit;
        $data2=array(
            'id'=>'objects-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'filterPosition'=>'renderFilter()_calling_place_is_changed_in_CGrid_view_because_of_conflict_with_colResizeable',
            'itemsCssClass'=>'table',
            'enablePagination'=>true,
            'pagerCssClass'=>'pagination',
            'selectableRows'=>2,
            'pager'=>array(
                'cssFile'=>false,
                'htmlOptions'=>array('class'=>'pagination'),
                'header'=>false,
            ),
            'template'=>' 
                <div class="module changelist-results">
                    {items}
                </div>
                <div class="module pagination">
                    {pager}{summary}<br clear="all">
                </div> 
            ',
            'afterAjaxUpdate'=>'initAll',
            'rowCssClassExpression' => '
                ( $row%2 ? $this->rowCssClass[1] : $this->rowCssClass[0] ) .
                ( isset($data->newsCount) && $data->newsCount ? " pk".$data->id : " pk".$data->id." empty" )
            ',
            'columns'=>array(
                array(
                    'class'=>'YiiAdminButtonColumn',
                    'updateButtonUrl'=>$url_prefix.'update",array("model_name"=>"'.get_class($model).'","pk"=>$data->primaryKey))',
                    'deleteButtonUrl'=>$url_prefix.'delete",array("model_name"=>"'.get_class($model).'","pk"=>$data->primaryKey))',
                    'viewButtonUrl'=>$url_prefix.'view",array("model_name"=>"'.get_class($model).'","pk"=>$data->primaryKey))',
                    'viewButtonOptions'=>array(
                        'style'=>'display:none;',
                    ),
                    /* row numbers per page */
                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,30=>30,40=>40,50=>50,$model->count()=>'Все'),array(
                        // change 'user-grid' to the actual id of your grid!!
                        'onchange'=>"$.fn.yiiGridView.update('objects-grid',{ data:{pageSize: $(this).val() }})",
                    )),
                    /* row numbers per page END */
                ),
            ),
        ); 

        $listData=array_merge_recursive($data1,$data2);

        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_grid',array('listData'=>$listData,'listDataExport'=>$listDataExport),false,true);
            Yii::app()->end();
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile(Yii::app()->baseUrl.'/js/colResizable-1.3.min.js');
        }

        $this->render('list_objects',array(
            'title'=>$model->pluralNames[1],
            'model'=>$model, 
            'listData'=>$listData,
        ));
    }

    /**
     * Создание новой записи.
     * 
     * @access public
     * @return void
     */
    public function actionCreate()
    {
        header('Content-Type: text/html; charset=utf-8');
        $model_name = (string)$_GET['model_name'];
        $model = $this->module->loadModel($model_name);

        if (Yii::app()->request->isPostRequest)
        {
            if (isset($_POST[$model_name]))
                $model->attributes=$_POST[$model_name];
                
            $this->updateCreateTime($model, $model_name);

            if ($model->validate())
            {
                if(!$model->save()){
                    $msg = print_r($model->getErrors(),1);
                    throw CHttpException(400,'data not saving: '.$msg );
                }
                $this->saveManyMany($model, $model_name);
                Yii::app()->user->setFlash('flashMessage', YiiadminModule::t('Запись создана.'));
                $this->redirectUser($model_name,$model->primaryKey);
            }
        }

        $title=YiiadminModule::t( 'Создать').' '.$this->module->getObjectPluralName($model, 0); 
        $this->breadcrumbs=array(
                $this->module->getModelNamePlural($model)=>$this->createUrl('manageModel/list',array('model_name'=>$model_name)),
                $title
        );
//CVarDumper::dump($model->attributes,1);exit;
        $this->render('create',array(
            'title'=>$title,
            'model'=>$model,            
        ));
    }

    public function actionUpdate()
    {
        header('Content-Type: text/html; charset=utf-8');
        $model_name=(string)$_GET['model_name']; 
        $model=$this->module->loadModel($model_name)->findByPk($_GET['pk']);

        if (Yii::app()->request->isPostRequest)
        {
            if (isset($_POST[$model_name]))
                $model->attributes=$_POST[$model_name]; 
               
            $this->updateCreateTime($model, $model_name);

            if ($model->validate())
            {
                $model->save();
                $this->saveManyMany($model, $model_name);
                Yii::app()->user->setFlash('flashMessage', YiiadminModule::t('Изменения сохранены.'));
                $this->redirectUser($model_name,$model->primaryKey);
            }
        }

        $title=YiiadminModule::t( 'Редактировать').' '.$this->module->getObjectPluralName($model, 0); 
        $this->breadcrumbs=array(
                $this->module->getModelNamePlural($model)=>$this->createUrl('manageModel/list',array('model_name'=>$model_name)),
                $title
        );

        $this->render('create',array(
            'title'=>YiiadminModule::t( 'Редактировать').' '.$this->module->getObjectPluralName($model, 0),
            'model'=>$model,
            'update'=>1,
        ));
    }

    public function actionDelete()
    {
        $model_name=(string)$_GET['model_name'];
        $model=$this->module->loadModel($model_name)->findByPk($_GET['pk']);

        if ($model!==null)
        {
            $model->delete();
            $this->redirect($this->createUrl('manageModel/list',array('model_name'=>$model_name)));
        }
    }

    public function updateCreateTime($model, $model_name)
    {
        $time = strtotime($_POST[$model_name]['create_time']);
        
        if(isset($model->create_time))
        	$model->create_time = $time;
    }

    public function saveManyMany($model, $model_name)
    {
        foreach($model->relations() as $name=>$rel)
        {
            if($rel[0] == CActiveRecord::MANY_MANY)
            {   
                $data = $_POST[$model_name][$name . '_id'];//var_dump($data);exit;
                    
                //$name = str_replace('_id', '', $name);

                if (isset($data)){
                    if(is_array($data))
                        $model->setRelationRecords($name, $data);
                    else if(sizeof($model->$name) > 0)
                        $model->removeAllRelationRecords($name);
                }
            }
        }
            
        return $model;
    }

    /**
     * Redirect after editing model data.
     * 
     * @param string $model_name 
     * @param integer $pk 
     * @access protected
     * @return void
     */
    protected function redirectUser($model_name,$pk)
    {
        if ($_POST['_save'])
            $this->redirect($this->createUrl('manageModel/list',array('model_name'=>$model_name)));
        if ($_POST['_addanother'])
        {
            Yii::app()->user->setFlash('flashMessage', YiiadminModule::t('Изменения сохранены. Можете создать новую запись.')); 
            $this->redirect($this->createUrl('manageModel/create',array('model_name'=>$model_name)));
        }
        if ($_POST['_continue'])
            $this->redirect($this->createUrl('manageModel/update',array('model_name'=>$model_name,'pk'=>$pk)));
    }
    
    public function actionExportexcel()
    {
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        $model_name=(string)$_GET['model_name'];
        $model=$this->module->loadModel($model_name);
        $admsearch = $model->adminSearch();
        $columns = $admsearch['columns'];
        unset($columns[0]);

        $this->toExcel($_SESSION['dataprovider'],
            $columns,
            $model_name,
            array(
                //'creator' => 'RudraSoftech',
            ),
            'Excel2007'
        );
    }

    public function actionInstagram() {
        $this->render('instagram');
    }
}
