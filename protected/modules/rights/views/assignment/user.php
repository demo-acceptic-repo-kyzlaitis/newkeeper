<?php $this->breadcrumbs = array(
	'Права'=>Rights::getBaseUrl(),
	Rights::t('core', 'Назначение')=>array('assignment/view'),
	$model->getName(),
); ?>

<div class="row-fluid">
    <div class="widget">
        <div class="head">
            <div class="icon"><i class="icosg-clipboard1"></i></div>
	<h2><?php echo Rights::t('core', 'Назначение прав для :username', array(
		':username'=>$model->getName()
	)); ?></h2>                    
        </div>                
            <div class="block-fluid">

	
	<div class="assignments span-12 first">

		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'template'=>'{items}',
			'hideHeader'=>true,
			'emptyText'=>Rights::t('core', 'This user has not been assigned any items.'),
			'htmlOptions'=>array('class'=>'grid-view user-assignment-table mini'),
			'columns'=>array(
    			array(
    				'name'=>'name',
    				'header'=>Rights::t('core', 'Name'),
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'name-column'),
    				'value'=>'$data->getNameText()',
    			),
    			array(
    				'name'=>'type',
    				'header'=>Rights::t('core', 'Type'),
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'type-column'),
    				'value'=>'$data->getTypeText()',
    			),
    			array(
    				'header'=>'&nbsp;',
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'actions-column'),
    				'value'=>'$data->getRevokeAssignmentLink()',
    			),
			)
		)); ?>

	</div>

		<?php if( $formModel!==null ): ?>

			<div class="form">

				<?php $this->renderPartial('_form', array(
					'model'=>$formModel,
					'itemnameSelectOptions'=>$assignSelectOptions,
				)); ?>

			</div>

		<?php else: ?>

			<p class="info"><?php //echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>
            Для данного пользователя нет возможных назначений.

		<?php endif; ?>


</div>
</div>
</div>
</div>