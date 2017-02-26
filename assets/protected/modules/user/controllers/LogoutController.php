<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionIndex()
	{
		Yii::app()->user->logout();
		$this->redirect('http://'.$_SERVER['HTTP_HOST']);
	}

}