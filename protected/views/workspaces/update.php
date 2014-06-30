<?php
/* @var $this WorkspacesController */
/* @var $model Workspaces */
/*
$this->breadcrumbs=array(
	'Workspaces'=>array('index'),
	$model->workspace_id=>array('view','id'=>$model->workspace_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Workspaces', 'url'=>array('index')),
	array('label'=>'Create Workspaces', 'url'=>array('create')),
	array('label'=>'View Workspaces', 'url'=>array('view', 'id'=>$model->workspace_id)),
	array('label'=>'Manage Workspaces', 'url'=>array('admin')),
);
*/
?>

<!--<h1>Update Workspaces <?php echo $model->workspace_id; ?></h1>-->
<div class="container">
				<div class="row">
					<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
<?php echo $this->renderPartial('_form_edit', array('model'=>$model)); ?>

<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>