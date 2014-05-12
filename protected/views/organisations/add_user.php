<?php
/* @var $this OrganisationsController */
if ($success) {
	echo $success;
}
if ($error) {
	echo $error;
}
 ?>
 <script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>