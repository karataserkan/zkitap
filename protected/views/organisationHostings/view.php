<?php
/* @var $this OrganisationHostingsController */
/* @var $model OrganisationHostings */

$this->breadcrumbs=array(
	'Organisation Hostings'=>array('index'),
	$model->hosting_client_id,
);

$this->menu=array(
	array('label'=>'List OrganisationHostings', 'url'=>array('index')),
	array('label'=>'Create OrganisationHostings', 'url'=>array('create')),
	array('label'=>'Update OrganisationHostings', 'url'=>array('update', 'id'=>$model->hosting_client_id)),
	array('label'=>'Delete OrganisationHostings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->hosting_client_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrganisationHostings', 'url'=>array('admin')),
);
?>

<h1>View OrganisationHostings #<?php echo $model->hosting_client_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'organisation_id',
		'hosting_client_IP',
		'hosting_client_port',
		'hosting_client_id',
		'hosting_client_key1',
		'hosting_client_key2',
	),
)); ?>
