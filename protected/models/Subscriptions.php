<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 5/27/2015
 * Time: 3:43 PM
 */


/**
 * This is the model class for table "net_country".
 *
 * The followings are the available columns in table 'net_country':
 * @property string $email
 */
class Subscriptions extends CActiveRecord {


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return S the static model class
     */
    public static function model ($class_name=__CLASS__) {
        return parent::model($class_name);
    }

    public function tableName() {
        return 'subscriptions';
    }


    /**
     * @return array of validation rules for model attributes
     */
    public function rules() {
        return array();
    }

}