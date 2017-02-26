<?php $this->breadcrumbs = array(
	'Права'=>Rights::getBaseUrl(),
	Rights::t('core', 'Права доступа'),
); 
$this->pageTitle='Права доступа';?>

<div id="permissions">

	

	<p>
		<?php //echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
        Здесь вы можете управлять правами, назначенными для каждой роли.<br />
		<?php echo Rights::t('core', 'Доступами можно управлять в разделах: {roleLink}, {taskLink} и {operationLink}.', array(
			'{roleLink}'=>CHtml::link('Роли', array('authItem/roles')),
			'{taskLink}'=>CHtml::link('Задачи', array('authItem/tasks')),
			'{operationLink}'=>CHtml::link('Операции', array('authItem/operations')),
		)); ?>
	</p>

	<p><?php echo CHtml::link(Rights::t('core', 'Сгенерировать элементы доступов исходя из контроллеров приложения'), array('authItem/generate'), array(
	   	'class'=>'generator-link',
	)); ?></p>
<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
        </div>                
            <div class="block-fluid">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
		'emptyText'=>Rights::t('core', 'No authorization items found.'),
		'htmlOptions'=>array('class'=>'grid-view permission-table'),
		'columns'=>$columns,
        'itemsCssClass'=>'fpTable dataTable',
	)); ?>

	<p class="info">*) <?php echo Rights::t('core', 'Наведите курсор чтобы увидеть от кого наследовано данное разрешение.'); ?></p>

	<script type="text/javascript">

		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});

	</script>

</div>
</div>
</div>
</div>

