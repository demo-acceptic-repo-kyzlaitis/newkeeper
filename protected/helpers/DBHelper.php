<?php

class DBHelper
{
	
    public static function saveManyMany($model, $model_name)
    {//var_dump($_POST);exit;
        foreach($model->relations() as $name=>$rel)
        {
            if($rel[0] == CActiveRecord::MANY_MANY)
            {   
                if (isset($_POST[$model_name]) && isset($_POST[$model_name][$name . '_id'])) {
                    $data = $_POST[$model_name][$name . '_id'];
                }
                    
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
}