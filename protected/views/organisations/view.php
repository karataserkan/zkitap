<?php
/* @var $this OrganisationsController */
/* @var $model Organisations */

$this->breadcrumbs=array(
	'Organisations'=>array('index'),
	$model->organisation_id,
);

$this->menu=array(
	array('label'=>'List Organisations', 'url'=>array('index')),
	array('label'=>'Create Organisations', 'url'=>array('create')),
	array('label'=>'Update Organisations', 'url'=>array('update', 'id'=>$model->organisation_id)),
	array('label'=>'Delete Organisations', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->organisation_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Organisations', 'url'=>array('admin')),
);
?>

<h1>View Organisations #<?php echo $model->organisation_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'organisation_id',
		'organisation_name',
		'organisation_admin',
	),
)); ?>
