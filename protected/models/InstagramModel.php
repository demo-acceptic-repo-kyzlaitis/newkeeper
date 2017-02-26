<?php

/**
 * Class InstagramModel
 *
 * @property integer id primary key
 * @property varchar (255) access_token
 */
class InstagramModel extends CActiveRecord{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InstagramModel  the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string
     */
    public function tableName() {

        return 'instagram_user';
    }




}