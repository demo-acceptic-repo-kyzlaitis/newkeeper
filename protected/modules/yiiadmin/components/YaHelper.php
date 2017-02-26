<?php


class YaHelper
{
    
    public static function createAdminUrl($action,$model,$id)
    {
        return '/yiiadmin/manageModel/' . $action . '?model_name=' . $model . '&pk=' . $id;
    }
    
}