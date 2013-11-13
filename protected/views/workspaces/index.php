<?php
/* @var $this WorkspacesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Workspaces',
);

$this->menu=array(
	array('label'=>'Create Workspaces', 'url'=>array('create')),
	array('label'=>'Manage Workspaces', 'url'=>array('admin')),
);
?>

<h1>Workspaces</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
