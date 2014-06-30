<?php
/* @var $this WorkspacesController */
/* @var $model Workspaces */

$this->breadcrumbs=array(
	'Workspaces'=>array('index'),
	$model->workspace_id,
);

$this->menu=array(
	array('label'=>'List Workspaces', 'url'=>array('index')),
	array('label'=>'Create Workspaces', 'url'=>array('create')),
	array('label'=>'Update Workspaces', 'url'=>array('update', 'id'=>$model->workspace_id)),
	array('label'=>'Delete Workspaces', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->workspace_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Workspaces', 'url'=>array('admin')),
);
?>

<h1>View Workspaces #<?php echo $model->workspace_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'workspace_id',
		'workspace_name',
		'creation_time',
	),
)); ?>
