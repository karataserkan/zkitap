<?php
/* @var $this OrganisationHostingsController */
/* @var $model OrganisationHostings */
?>
<div class="container">
				<div class="row">
					<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>