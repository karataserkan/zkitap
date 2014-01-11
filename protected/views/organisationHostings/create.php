<?php
/* @var $this OrganisationHostingsController */
/* @var $model OrganisationHostings */

$this->breadcrumbs=array(
	'Organisation Hostings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrganisationHostings', 'url'=>array('index')),
	array('label'=>'Manage OrganisationHostings', 'url'=>array('admin')),
);
?>

<h1>Create OrganisationHostings</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>