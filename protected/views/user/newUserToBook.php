
<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
										<h3 class="content-title pull-left"><?php _e('Davet') ?></h3>
								</div>
							</div>
						</div>
						<div class="col-md-3 item">

<?php 
	_e("Eser çalışma isteğini kabul ediyor musunuz?");
?>
</div>
<a href="/user/respondBookInvitation?key=<?php echo $key?>&respond=1" class="btn btn-success"><?php _e("Kabul Et"); ?></a>
<a href="/user/respondBookInvitation?key=<?php echo $key?>&respond=0" class="btn btn-danger"><?php _e("Kabul Etme"); ?></a>
<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>