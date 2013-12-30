<?php
/* @var $this OrganisationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Organisations',
);

$this->menu=array(
	array('label'=>'Create Organisations', 'url'=>array('create')),
	array('label'=>'Manage Organisations', 'url'=>array('admin')),
);
?>

<h1>Organisations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
