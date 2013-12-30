<?php
/* @var $this OrganisationsController */
/* @var $data Organisations */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('organisation_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->organisation_id), array('view', 'id'=>$data->organisation_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organisation_name')); ?>:</b>
	<?php echo CHtml::encode($data->organisation_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organisation_admin')); ?>:</b>
	<?php echo CHtml::encode($data->organisation_admin); ?>
	<br />


</div>