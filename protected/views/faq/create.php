<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Faq', 'url'=>array('index')),
	array('label'=>'Manage Faq', 'url'=>array('admin')),
);
?>

<h1>Create Faq</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>