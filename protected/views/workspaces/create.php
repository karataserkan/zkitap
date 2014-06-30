<?php
/* @var $this WorkspacesController */
/* @var $model Workspaces */

// $this->breadcrumbs=array(
// 	'Workspaces'=>array('index'),
// 	'Create',
// );

// $this->menu=array(
// 	array('label'=>'List Workspaces', 'url'=>array('index')),
// 	array('label'=>'Manage Workspaces', 'url'=>array('admin')),
// );
?>

<!--<h1>Create Workspaces</h1>-->
<div class="container">
				<div class="row">
					<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>