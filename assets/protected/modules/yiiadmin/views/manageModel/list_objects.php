<?php
    $this->pageTitle=$title;

    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile(Yii::app()->baseUrl.'/js/colResizable-1.3.min.js');
?>
    <!--<ul class="tools"> 
    <li> 
       <?php echo CHtml::link(YiiadminModule::t( 'Создать').' '.$this->module->getObjectPluralName($model, 0),$this->createUrl('manageModel/create',array('model_name'=>get_class($model))), array('class'=>'add-handler focus')); ?>
    </li> 
    </ul>-->

<script>
function initResizeCol()
{
    $("table").colResizable({
        liveDrag : true
      });
}
function initSelectAllEvent()
{
      $('#objects-grid_c0 input').change(function(){
        if($('tbody tr.selected').length == $('tbody tr').length)
          $('tbody tr').removeClass('selected')
        else
          $('tbody tr').addClass('selected')
      })
}
function initAll()
{
    initResizeCol()
    initSelectAllEvent()
}
function changeCat(orig_id, target_id)
{
    $('#loading').show();
    $.post('/category/changeid', {'orig_id':orig_id, 'target_id':target_id}, function(data){
        $('#loading').hide();
        alert('Новости были перемещены в новую категорию')
        $.colorbox.close();
        $.fn.yiiGridView.update("objects-grid");
    },'json');
}
</script>

<?php
    $this->renderPartial('_buttons',array('model'=>$model));
    $this->renderPartial('_grid',array('listData'=>$listData),false,false);
?>
<?php

Yii::app()->getClientScript()->scriptMap = array(
        'jquery.yiigridview.js' => Yii::app()->baseUrl . '/js/jquery.yiigridview.js',
);

   $this->renderPartial('_buttons',array('model'=>$model));