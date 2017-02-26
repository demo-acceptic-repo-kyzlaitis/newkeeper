<?php $this->breadcrumbs = array(
	'Права'=>Rights::getBaseUrl(),
	Rights::t('core', 'Операции'),
); 
$this->pageTitle='Операции';?>

<div id="operations">
	<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
        </div>                
            <div class="block-fluid">


	<p>
		<?php //echo Rights::t('core', 'An operation is a permission to perform a single operation, for example accessing a certain controller action.'); ?><br />
        Операция - это разрешение производить одиночное действие, например, вызывать определенный метод контроллера.<br />
		<?php //echo Rights::t('core', 'Operations exist below tasks in the authorization hierarchy and can therefore only inherit from other operations.'); ?>
        Операции находятся под задачами в иерархии и могут наследоваться только от других операций.
	</p>

	<p><?php echo CHtml::link(Rights::t('core', 'Создать операцию'), array('authItem/create', 'type'=>CAuthItem::TYPE_OPERATION), array(
		'class'=>'add-operation-link',
	)); ?></p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>'{items}',
	    'emptyText'=>Rights::t('core', 'No operations found.'),
	    'htmlOptions'=>array('class'=>'grid-view operation-table sortable-table'),
        'itemsCssClass'=>'fpTable dataTable',
	    'columns'=>array(
	    	array(
    			'name'=>'name',
    			'header'=>'Имя',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'name-column'),
    			'value'=>'$data->getGridNameLink()',
    		),
    		array(
    			'name'=>'description',
    			'header'=>'Описание',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'description-column'),
    		),
    		array(
    			'name'=>'bizRule',
    			'header'=>'Бизнес правило',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'bizrule-column'),
    			'visible'=>Rights::module()->enableBizRule===true,
    		),
    		array(
    			'name'=>'data',
    			'header'=>'Данные',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'data-column'),
    			'visible'=>Rights::module()->enableBizRuleData===true,
    		),
    		array(
    			'header'=>'&nbsp;',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'actions-column'),
    			'value'=>'$data->getDeleteOperationLink()',
    		),
	    )
	)); ?>

	<p class="info"><?php //echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?></p>

</div>
</div>
</div>
</div>