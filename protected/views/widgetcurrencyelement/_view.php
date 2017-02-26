<?php
/* @var $this WidgetcurrencyclementController */
/* @var $data WidgetCurrencyElement */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buy')); ?>:</b>
	<?php echo CHtml::encode($data->buy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale')); ?>:</b>
	<?php echo CHtml::encode($data->sale); ?>
	<br />

	<b><?php// echo CHtml::encode($data->getAttributeLabel('symbol')); ?>:</b>
	<?php// echo CHtml::encode($data->sale); ?>
	<br />


</div>