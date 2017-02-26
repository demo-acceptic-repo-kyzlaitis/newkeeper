<?php

class AjaxHelper {
	
	public static function sendResponse($data)
	{
		echo json_encode($data);
        Yii::app()->end();
	}
}