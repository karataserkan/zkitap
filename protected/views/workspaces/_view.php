<?php
/* @var $this WorkspacesController */
/* @var $data Workspaces */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('workspace_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->workspace_id), array('view', 'id'=>$data->workspace_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workspace_name')); ?>:</b>
	<?php echo CHtml::encode($data->workspace_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_time')); ?>:</b>
	<?php echo CHtml::encode($data->creation_time); ?>
	<br />


</div>