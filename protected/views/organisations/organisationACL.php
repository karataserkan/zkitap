<script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- POPUP EDITORS -->
<div class="modal fade" id="addAcl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Eseri Güncelle"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="copy" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="contentTitle">Eser Adı<span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="contentTitle" placeholder="Lütfen bir isim girin!" id="updateContentTitle" type="text">															
					</div>
				</div>	
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="update_book_title"><?php _e("Güncelle"); ?></a>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç"); ?></button>
	      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->

<div id="content" class="col-lg-12">
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
				<h3 class="content-title pull-left"><?php _e('Access Control List (ACL)') ?></h3>
				<a class="btn pull-right btn-primary" data-id="addAcl" data-toggle="modal" data-target="#addAcl" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-plus-circle"></i><span> ACL Ekle</span></a>
	
			
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->