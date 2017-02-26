<?php

// put this in your /protected/commands folder.

/**
 * 
 * This is the cron job command that gets called by heroku (heroku.sh) every 10 minutes.
 * The jobs are queued up in the database and referenced by the CronJob model. Each action
 * should receive an array of parameters and return an array with keys succeeded as bool and
 * execution_result as string or null. Action can also return false to delay execution until
 * next loop if certain conditions aren't met. (like not sending an email during a certain 
 * time period, for example). 
 * 
 */

class CronCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "yeah";
        //$dataProvider=new CActiveDataProvider('News');
        //$this->renderPartial('category/ajax');
                //js-code to open the dialog    
                if (!empty($_GET['asDialog']))
                    echo CHtml::script('js:bootbox.modal($("#id_category").html());');
                Yii::app()->end();
    }
}
