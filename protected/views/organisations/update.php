<?php
/* @var $this OrganisationsController */
/* @var $model Organisations */

$this->breadcrumbs=array(
	'Organisations'=>array('index'),
	$model->organisation_id=>array('view','id'=>$model->organisation_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Organisations', 'url'=>array('index')),
	array('label'=>'Create Organisations', 'url'=>array('create')),
	array('label'=>'View Organisations', 'url'=>array('view', 'id'=>$model->organisation_id)),
	array('label'=>'Manage Organisations', 'url'=>array('admin')),
);
?>

<h1>Update Organisations <?php echo $model->organisation_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>