<?php
/* @var $this ChapterController */
/* @var $model Chapter */

$this->breadcrumbs=array(
	'Chapters'=>array('index'),
	$model->title=>array('view','id'=>$model->chapter_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Chapter', 'url'=>array('index')),
	array('label'=>'Create Chapter', 'url'=>array('create')),
	array('label'=>'View Chapter', 'url'=>array('view', 'id'=>$model->chapter_id)),
	array('label'=>'Manage Chapter', 'url'=>array('admin')),
);
?>

<h1>Update Chapter <?php echo $model->chapter_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>