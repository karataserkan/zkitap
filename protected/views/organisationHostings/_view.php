<?php
/* @var $this OrganisationHostingsController */
/* @var $data OrganisationHostings */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('hosting_client_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->hosting_client_id), array('view', 'id'=>$data->hosting_client_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organisation_id')); ?>:</b>
	<?php echo CHtml::encode($data->organisation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hosting_client_IP')); ?>:</b>
	<?php echo CHtml::encode($data->hosting_client_IP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hosting_client_port')); ?>:</b>
	<?php echo CHtml::encode($data->hosting_client_port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hosting_client_key1')); ?>:</b>
	<?php echo CHtml::encode($data->hosting_client_key1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hosting_client_key2')); ?>:</b>
	<?php echo CHtml::encode($data->hosting_client_key2); ?>
	<br />


</div>