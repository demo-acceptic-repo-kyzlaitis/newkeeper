<div class="button_block">
<?php

   echo CHtml::ajaxButton('Удалить выбранные', Yii::app()->createUrl(strtolower(get_parent_class($model)).'/admindelete'),array(
           'type'=>'POST',
           'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
           'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
           'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
        ),
        array()
   );
   if(get_parent_class($model) == 'News'){
       echo CHtml::ajaxButton('Опубликовать', Yii::app()->createUrl('news/publish'),array(
               'type'=>'POST',
               'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
               //'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
               'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
            ),
            array()
       );
       echo CHtml::ajaxButton('Снять с публикации', Yii::app()->createUrl('news/unpublish'),array(
               'type'=>'POST',
               'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
               //'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
               'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
            ),
            array()
       );
       echo CHtml::ajaxButton('В обрабатываемые', Yii::app()->createUrl('news/processing'),array(
               'type'=>'POST',
               'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
               //'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
               'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
            ),
            array()
       );
   }
   if(get_parent_class($model) == 'Bloger'){
       echo CHtml::ajaxButton('Активировать', Yii::app()->createUrl('bloger/activate'),array(
               'type'=>'POST',
               'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
               //'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
               'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
            ),
            array()
       );
       echo CHtml::ajaxButton('Деактивировать', Yii::app()->createUrl('bloger/deactivate'),array(
               'type'=>'POST',
               'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
               //'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
               'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
            ),
            array()
       );
       echo CHtml::ajaxButton('В неподтвержденные', Yii::app()->createUrl('bloger/processing'),array(
               'type'=>'POST',
               'data'=>'js:{ids : $("#objects-grid").yiiGridView("getSelection")}',
               //'beforeSend'=>'js:function(xhr, opts){var del = confirm("Вы желаете удалить выбранные записи?"); if(!del) xhr.abort();}',
               'complete'=>'js:function(data){$("#objects-grid").yiiGridView("update")}'
            ),
            array()
       );
   }

   echo CHtml::button('Экспортировать в Excel', array('onclick' => 'window.location.href="/yiiadmin/manageModel/exportexcel?model_name='.get_class($model) . '"'));
?>
 
    <?php echo CHtml::button(
        YiiadminModule::t( 'Создать').' '.$this->module->getObjectPluralName($model, 0), 
        array(
            'onclick' => 'window.location.href="' . $this->createUrl('manageModel/create', array('model_name'=>get_class($model))) . '"',
            'class'=>'create_button',
        )
    ); ?>

</div>