<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->faq_id,
);

$this->menu=array(
	array('label'=>'List Faq', 'url'=>array('index')),
	array('label'=>'Create Faq', 'url'=>array('create')),
	array('label'=>'Update Faq', 'url'=>array('update', 'id'=>$model->faq_id)),
	array('label'=>'Delete Faq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->faq_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Faq', 'url'=>array('admin')),
);
?>

<h1>View Faq #<?php echo $model->faq_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'faq_id',
		'faq_question',
		'faq_answer',
		'faq_frequency',
		'lang',
		'rate',
	),
)); ?>
