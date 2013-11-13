<?php
/* @var $this ChapterController */
/* @var $model Chapter */

$this->breadcrumbs=array(
	'Chapters'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Chapter', 'url'=>array('index')),
	array('label'=>'Create Chapter', 'url'=>array('create')),
	array('label'=>'Update Chapter', 'url'=>array('update', 'id'=>$model->chapter_id)),
	array('label'=>'Delete Chapter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->chapter_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Chapter', 'url'=>array('admin')),
);
?>

<h1>View Chapter #<?php echo $model->chapter_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'chapter_id',
		'title',
		'book_id',
		'start_page',
		'order',
		'created',
		'data',
	),
)); ?>
