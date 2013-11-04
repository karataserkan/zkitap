<?php
/* @var $this WorkspacesController */
/* @var $model Workspaces */

$this->breadcrumbs=array(
	'Workspaces'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Workspaces', 'url'=>array('index')),
	array('label'=>'Manage Workspaces', 'url'=>array('admin')),
);
?>

<h1>Create Workspaces</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>