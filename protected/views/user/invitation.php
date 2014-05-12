
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
if($newUser)
	echo $this->renderPartial('_invitation_form', array('model'=>$model));
else
	_e("İsteği kabul ettiniz. Anasayfaya giderek sisteme giriş yapabilirsiniz.");
?>
</div>
<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>