<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NKActiveRecord
 *
 * @author Artem
 */
abstract class NKActiveRecord extends ManyManyActiveRecord
{
	const LANG_NO = 0;
	const LANG_EN = 1;
	const LANG_RU = 2;
	const LANG_UA = 3;
 
    public $status;
    public $news_count;
    public $day_views_count;
    public $views_count;
    public $bookmarks_count;
    public $downloads_count;
    public $shares_gp_count;
    public $shares_vk_count;
    public $shares_tw_count;
    public $shares_fb_count;
    public $shares_total_count;
    
    public $stats = array(
        'Просмотры'=>'views_count',
        'Подписки'=>'bookmarks_count',
        'Скачивания'=>'downloads_count',
        'g+ шары'=>'shares_gp_count',
        'vk шары'=>'shares_vk_count',
        'tw шары'=>'shares_tw_count',
        'fb шары'=>'shares_fb_count',
    );
    
    function countSqlStr($field){}    
    
    static public function getStatuses()
    {
        return array();
    }            
    
	public function assignUser($user, $assign_table, $assign_field, $foreign_field='id')
	{
		$command = Yii::app()->db->createCommand();
		$command->insert($assign_table, array(
			'user_id' => $user->id,
			$assign_field => $this->$foreign_field,
		));
	}

	public function removeUser($user, $assign_table, $assign_field, $foreign_field='id')
	{
		$command = Yii::app()->db->createCommand();
		$command->delete(
			$assign_table,
			'user_id=:userId AND '.$assign_field.'=:foreignId',
		array(':userId'=>$user->id,':foreignId'=>$this->$foreign_field));
	}

	public function hasUserAssigned($user, $assign_table, $assign_field, $foreign_field='id')
	{
		$sql = "SELECT user_id FROM ".$assign_table." WHERE ".$assign_field."=:foreignId AND user_id=:userId";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":foreignId", $this->$foreign_field, PDO::PARAM_INT);
		$command->bindValue(":userId", $user->id, PDO::PARAM_INT);
		return $command->execute()==1;
	}
        
    public function addToSession($array,$param='id')
    {
        $bmarks = Yii::app()->session[$array];
        $bmarks[$model->$param] = $model->$param;
        Yii::app()->session[$array] = $bmarks;
    }
    
    public function removeFromSession($array,$param='id')
    {
        $bmarks = Yii::app()->session[$array];
        unset($bmarks[$model->$param]);
        Yii::app()->session[$array] = $bmarks;
    }
    
    public function isInSession($array,$param='id')
    {
        $bmarks = Yii::app()->session[$array];
        if($bmarks[$model->$param] != $model->$param){
            return false;
        }else{
            true;
        }
    }
    
    public function statsColumns()
    {
        $out = array();
        foreach($this->stats as $k=>$st)
        {
            $out[] = array(
                'name'=>$k,
                'value'=>'$data->' . $st,
                'htmlOptions'=>array("width"=>"30px"),
                'filter'=>false,
            );
        }
        
        return $out;
    }

	public function getLangsAdmin()
	{
        return array(
		  self::LANG_RU => 'RU',
		  self::LANG_EN => 'EN',
		  self::LANG_UA => 'UA',
        );
	}

	public function getLangsDisplay()
	{
        return array(
		  self::LANG_NO => 'All',
		  self::LANG_RU => 'RU',
		  self::LANG_EN => 'EN',
		  self::LANG_UA => 'UA',
        );
	}
}

