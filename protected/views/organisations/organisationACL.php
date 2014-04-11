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
		  <h4 class="modal-title"><?php _e("ACL Ekle"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="acl" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="name"><?php _e('İsim'); ?><span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="name" type="text">															
					</div>
				</div>

				<div class="form-group">
					<label  class="col-md-3 control-label">
					<?php _e("ACL Tipi"); ?><span class="required">*</span>
					</label>
					<div class="col-md-9">
			 			<span id="aclTypes">
			 				<div class="radio SelectType" id="uniform-1">
			 					<span>
			 						<input class="uniform" id="1" value="IPRange" type="radio" name="type">
			 					</span>
			 				</div>
			 				<label for="1"><?php _e("Ip Aralığı"); ?></label>
			 				<br>
			 				<div class="radio SelectType" id="uniform-2">
			 					<span>
			 						<input class="uniform" id="2" value="Network" type="radio" name="type">
			 					</span>
			 				</div>
			 				<label for="2"><?php _e("Network"); ?></label>
			 				<br>
			 				<div class="radio SelectType" id="uniform-3">
			 					<span>
			 						<input class="uniform" id="3" value="SingleIp" type="radio" name="type">
			 					</span>
			 				</div>
			 				<label for="3"><?php _e("Tek IP"); ?></label>
						</span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="val1"><?php _e('Ip 1: '); ?><span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="val1" type="text">															
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="val2"><?php _e('Ip 2/Mask'); ?><span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="val2" type="text">															
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="comment"><?php _e('Yorum'); ?></label>
					<div class="col-md-4">
						<textarea name="comment" rows="4" cols="20"></textarea>
					</div>
				</div>	
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="add_acl"><?php _e("Ekle"); ?></a>
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
<div class="row">
<?php
	if ($acls) {
		 
		$acls=json_decode($acls,true);
		foreach ($acls as $key => $acl) {
			?>
			<div class="col-lg-12">
				<?php echo $acl['name']; ?><br>
				<?php echo $acl['type']; ?><br>
				<?php echo $acl['val1']; ?><br>
				<?php echo $acl['val2']; ?><br>
				<?php echo $acl['comment']; ?><br>
				<a href="/organisations/deleteACL/<?php echo $organisation_id; ?>?acl_id=<?php echo $acl['id']; ?>"><?php _e('Sil'); ?></a>
			</div>
			<br>
			<br><hr>
			<?php
		}
	} 
?>
</div>
<!-- /PAGE HEADER -->
<script type="text/javascript">
var type;
var name;
var val1;
var val2;
var comment;
$(document).on("click",".SelectType",function(e){
	if ($(this).attr("id")=="uniform-3") {
		val2=0;
		$('[name="val2"]').hide();
		$('[for="val2"]').hide();
	};
	$(".SelectType span").removeClass("checked");
	$(this).children("span").addClass("checked");
	type=$(this).children("span").children("input").val();
});


$(document).on("click","#add_acl",function(e){
	name=$('[name="name"]').val();
	val1=$('[name="val1"]').val();
	val2=$('[name="val2"]').val();
	comment=$('[name="comment"]').val();
	
	data=[];
	item={};
	item.name='name';
	item.value=name;
	data.push(item);

	item2={};
	item2.name='type';
	item2.value=type;
	data.push(item2);

	item3={};
	item3.name='val1';
	item3.value=val1;
	data.push(item3);

	item4={};
	item4.name='val2';
	item4.value=val2;
	data.push(item4);

	item5={};
	item5.name='comment';
	item5.value=comment;
	data.push(item5);
	

	data=JSON.stringify(data);
	$.ajax({
	  type: "POST",
	  url: '/organisations/addACL/<?php echo $organisation_id ?>',
	  data: {acl:data}
	}).done(function(res){
		console.log(res);
		window.location.assign('/organisations/aCL/<?php echo $organisation_id ?>');
	});

});
</script>