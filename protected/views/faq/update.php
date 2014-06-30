<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->faq_id=>array('view','id'=>$model->faq_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Faq', 'url'=>array('index')),
	array('label'=>'Create Faq', 'url'=>array('create')),
	array('label'=>'View Faq', 'url'=>array('view', 'id'=>$model->faq_id)),
	array('label'=>'Manage Faq', 'url'=>array('admin')),
);
?>

<h1>Update Faq <?php echo $model->faq_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>