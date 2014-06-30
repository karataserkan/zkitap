<?php
/* @var $this OrganisationsController */
/* @var $model Organisations */

$this->breadcrumbs=array(
	'Organisations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Organisations', 'url'=>array('index')),
	array('label'=>'Manage Organisations', 'url'=>array('admin')),
);
?>

<h1>Create Organisations</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>