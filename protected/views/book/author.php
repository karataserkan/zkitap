<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->title,
);
/*
$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->book_id)),
	array('label'=>'Delete Book', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->book_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Book', 'url'=>array('admin')),
);
*/
?>

<h1><?php echo $model->title; ?></h1>
<hr>
<div id='editor_view_pane' style='background:#000; padding:5px;margin:5px;'>
	<div id='ruler' style='background:yellow; padding:25px;margin:5px;' >
		<div id='guide'> 
			<div id='current_page' style='background:white;border:thin solid black;zoom:1;padding:1cm;  height:800px;' >
				Page Here Drag&drops
			</div>
		</div> <!-- guide -->
	</div><!-- ruler -->
</div><!-- editor_pane -->

<a href='?r=chapter/create&book_id=<?php echo $model->book_id; ?>' >Add Chapter</a>
<a href='?r=chapter/add&book_id=<?php echo $model->book_id; ?>' >Add Page</a>


