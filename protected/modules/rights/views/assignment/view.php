<?php $this->breadcrumbs = array(
	'Права'=>Rights::getBaseUrl(),
	Rights::t('core', 'Присвоение ролей'),
); 
$this->pageTitle='Присвоение ролей';
?>

<div id="assignments">
	

	<p>
		<?php //echo Rights::t('core', 'Here you can view which permissions has been assigned to each user.'); ?>
        Здесь вы можете увидеть какие права назначены каждому пользователю.
	</p>
            
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
        </div>                
            <div class="block-fluid">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>"{items}",
	    'emptyText'=>Rights::t('core', 'No users found.'),
	    //'htmlOptions'=>array('class'=>'grid-view assignment-table'),
        'itemsCssClass'=>'fpTable dataTable',
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>'Имя пользователя',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'name-column'),
    			'value'=>'$data->getAssignmentNameLink()',
    		),
    		array(
    			'name'=>'assignments',
    			'header'=>'Роли',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'role-column'),
    			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
    		),
			array(
    			'name'=>'assignments',
    			'header'=>'Задачи',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'task-column'),
    			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
    		),
			array(
    			'name'=>'assignments',
    			'header'=>'Операции',
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'operation-column'),
    			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
    		),
	    )
	)); ?>
</div>
</div>
</div>
</div>