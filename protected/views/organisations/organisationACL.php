<script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements

		$('.alert').bind('closed.bs.alert', function (event,ui) {
  			var id_acl=$(this).find(".close").data().id;
  			var organisation_id="<?php echo $organisation_id; ?>";
  			console.log(id_acl);
  			$.ajax(
	  					{
					  		type: "GET",
					  		url: "/organisations/deleteACL/"+organisation_id,
					  		data: { acl_id: id_acl }
						}
				  )
				  .done(
					  		function( msg ) 
					  		{
					    		console.log("access control list removed!");
					  		}
				  		);
		});
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
			 					<span class="checked">
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
						<input class="form-control checkIp" name="val1" type="text" placeholder="255.255.255.255">															
					</div>
					<label id="val1error" class="control-label col-md-3"></label>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="val2"><?php _e('Ip 2:*'); ?></label>
					<div class="col-md-4">
						<input class="form-control checkIp" name="val2" type="text" placeholder="255.255.255.0">															
					</div>
					<label id="val2error" class="control-label col-md-3"></label>
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
				<h3 class="content-title pull-left"><?php _e('Erişim Kontrol Listesi (ACL)') ?></h3>
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
			
			<div class="alert alert-block alert-info fade in" style="margin:20px;">
				<a class="close" data-id="<?php echo $acl['id']; ?>" data-dismiss="alert" href="#" aria-hidden="true">
					×
				</a>

				<p></p>

				<h4>
					<i class="fa fa-check-square-o"></i> 
					<?php echo $acl['name']; ?> | <?php echo $acl['type'];?>
				</h4>
					<?php echo $acl['val1']; ?>-<?php echo $acl['val1']; ?><br>
					<?php echo $acl['comment']; ?>
				<p></p>
			</div>

			<?php
		}
	} 
?>



<?php
/*
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
	}*/ 
?>
</div>
<!-- /PAGE HEADER -->
<script type="text/javascript">
var type;
var name;
var val1;
var val2;
var comment;
var IPRange = true;
var Network = false;
$(document).on("click",".SelectType",function(e){

	if ($(this).attr("id")=="uniform-1") {
		$('[name="val2"]').show();
		$('[for="val2"]').show();
		$('[for="val2"]').text("Ip 2:*");
		IPRange = true;
		Network = false;
		$('#val2error').show();
	};
	if ($(this).attr("id")=="uniform-2") {
		$('[name="val2"]').show();
		$('[for="val2"]').show();
		$('[for="val2"]').text("Mask:*");
		IPRange = false;
		Network = true;
		$('#val2error').show();
	};
	if ($(this).attr("id")=="uniform-3") {
		val2=0;
		$('[name="val2"]').hide();
		$('[for="val2"]').hide();
		IPRange = false;
		Network = false;
		$('#val2error').hide();
	};

	$(".SelectType span").removeClass("checked");
	$(this).children("span").addClass("checked");
	type=$(this).children("span").children("input").val();
});

function validate(str)
{
    return /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-fA-F]|[a-fA-F][a-fA-F0-9\-]*[a-fA-F0-9])\.)*([A-Fa-f]|[A-Fa-f][A-Fa-f0-9\-]*[A-Fa-f0-9])$|^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/.test(str);
}
$(document).on("click","#add_acl",function(e){
	name=$('[name="name"]').val();
	val1=$('[name="val1"]').val();
	val2=$('[name="val2"]').val();
	comment=$('[name="comment"]').val();
	var error=0;
	var error2=0;
	var error3=0;
	if (validate(val1)!=true) {
		error++;
	};

	if (Network==true) {
		if (validate(val2)!=true) {
			error3++;
		};
	};

	if (IPRange==true) {
		if (validate(val2)!=true) {
			error2++;
		};		
	};

	// if (validate(val1)!=true) {
	// 	error++;
	// };
	// var valSplit=val1.split('.');
	// if (valSplit.length!=4) {
	// 	error++;
	// }
	// else{
	// 	for (var i = 0; i < valSplit.length; i++) {
	// 		if(valSplit[i]>255 || valSplit[i]<0)
	// 		{
	// 			error++;
	// 		}
	// 	};
	// };
	console.log(error3);
	console.log(error2);
	console.log(error);
	if (error>0) {
		$('#val1error').text("*Geçersiz IP adresi");
		$('#val1error').parent().addClass("has-error");
	}else
	{
		// $('#val1error').parent().addClass("has-success");
		// $('#val1error').hide();
	};

	if (error2>0) {
		$('#val2error').text("*Geçersiz IP adresi");
		$('#val2error').parent().addClass("has-error");
	}
	else
	{
		// $('#val2error').parent().addClass("has-success");
		// $('#val2error').hide();
	};

	if (error3>0) {
		$('#val2error').text("*Geçersiz Mask");
		$('#val2error').parent().addClass("has-error");
	}else
	{
		// $('#val2error').parent().addClass("has-success");
		// $('#val2error').hide();
	};

	if (error==0 && error2==0 && error3==0) {		
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
	};

});
</script>