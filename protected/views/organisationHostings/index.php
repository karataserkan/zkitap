<script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements

		$('#acl_info_box_event').click(function(){
			var box=$('#acl_info_box');
			console.log(box.css('display'));
			if(box.css('display')=='none')
				box.css({'display':'block'});
			else
				box.css({'display':'none'});



		});

		$('.close').bind('click', function (event,ui) {
			var id=$(this).data("id");
			var target=$(this).data("target");
			
			if(target=='#addServer')
			{
				var data=JSON.parse(atob(id));
				console.log(data);

				var hosting_client_id=data.hosting_client_id;
				var organisation_id=data.organisation_id;
				var hosting_client_IP=data.hosting_client_IP;
				var hosting_client_port=data.hosting_client_port;

				$('#acl').find('[name=server_address]').val(hosting_client_IP);
				$('#acl').find('[name=server_port]').val(hosting_client_port);
				$('#acl').find('[name=status]').val(hosting_client_id);
			

				//$.each($('#acl').find('[name=type]'),function(i,val){console.log(val.value);});
			}
			else if(target=='#confirmation'){
				console.log('fssdf');
				$("#remove_ok").attr("data-id",id);
			}

		});

		function clearForm(){
			$('#acl').find('[name=server_address]').val("");
			$('#acl').find('[name=server_port]').val("");
		}

		$('#confirmation').on('hidden.bs.modal', function () {
    		clearForm();
		});
		$('#addServer').on('hidden.bs.modal', function () {
    		clearForm();
		});
		$('#remove_ok').bind('click', function (event,ui) {
			var id_acl =$(this).data("id");
			console.log(id_acl);

  			var organisation_id="<?php echo $organisationId; ?>";
  			console.log(organisation_id);
  			$.ajax(
	  					{
					  		type: "GET",
					  		url: "/organisationHostings/deleteHost/",
					  		data: { organisationId:organisation_id, id: id_acl }
						}
				  )
				  .done(
					  		function( msg ) 
					  		{
					    		console.log("access control list removed!");
					    		location.reload();
					  		}
				  		);
		});
	});
</script>
<!-- POPUP EDITORS -->
<div class="modal fade" id="addServer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Sunucu Ekle"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="acl" method="post" class="form-horizontal">
		 		<input type="hidden" name="status" value="">
				<div class="form-group">
					<label class="control-label col-md-3" for="server_address"><?php _e('Sunucu Adresi'); ?><span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="server_address" type="text">															
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="server_port"><?php _e('Sunucu Portu'); ?><span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="server_port" type="text">															
					</div>
				</div>
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="add_server"><?php _e("Ekle"); ?></a>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç"); ?></button>
	      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->

<!--Confirmation starts-->
<!--
<div class="modal fade in" id="box-config-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabelx" aria-hidden="false" style="display: block;">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	  <h4 class="modal-title">Box Settings</h4>
	</div>
	<div class="modal-body">
	  Here goes box setting content.
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  <button type="button" class="btn btn-primary">Save changes</button>
	</div>
  </div>
</div>
</div>
-->

<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Sunucu Sil"); ?></h4>
		</div>
		<div class="modal-body">
		Silmek istediğinizden emin misiniz?
		</div>
	      <div class="modal-footer">
	      	<button type="button" id="remove_ok" class="btn btn-primary" data-id="" id="remove_server"><?php _e("Evet"); ?></button>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Hayır"); ?></button>
	      </div>
		</div>
	 </div>
</div>

<!--Confirmation ends-->

<div id="content" class="col-lg-12">
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
				<h3 class="content-title pull-left"><?php _e('Sunucu Listesi'); ?></h3>
					
				<a class="btn pull-right btn-primary" data-id="addServer" data-toggle="modal" data-target="#addServer"><i class="fa fa-plus-circle"></i><span> Sunucu Ekle</span></a>
	
			
		</div>
	</div>
</div>


<div class="row">

<div class="box border blue" style="margin:20px;">
	<div id="acl_info_box_event" class="box-title">
		<h4 style="text-shadow:none"><i class="fa fa-info-circle"></i>Sunucu Listesi hakkında bilgiler!</h4>
		<div class="tools">
				<i class="fa fa-chevron-down"></i>
		</div>
	</div>
	<div  id="acl_info_box" class="box-body big" style="display: none;">
		<div class="jumbotron">
		  <h2>Sunucu listesi,</h2>
		  <p>Yayınlanan eserler bulutta tutulmaktadır. Bu durumda siz de yayınladığınız eserin istediğiniz bulut sunucularında barınmasını sağlayabilirsiniz</p>
		  <p><a href="http://tr.wikipedia.org/wiki/Bulut_bili%C5%9Fim" class="btn btn-primary btn-lg" target="_blank" role="button">Bulut sunucular hakkında genel bilgi</a></p>

		</div>	

	</div>
</div>



</div>
<div class="row">

<?php
	if ($hostings){

	foreach ($hostings as $key => $host){
			$host_data = array(
								'hosting_client_id'=>$host->hosting_client_id,
							   'organisation_id'=>$host->organisation_id,
							   'hosting_client_IP'=>$host->hosting_client_IP,
							   'hosting_client_port'=>$host->hosting_client_port
							    );
			?>
			
			<div class="alert alert-block alert-info fade in" style="margin:20px;">
				<!--
				<a class="close" data-id="<?php echo $acl['id']; ?>" data-dismiss="alert" href="#" aria-hidden="true">
					×
				</a>-->

				<a class="fa fa-times-circle close tip" data-original-title="<?php _e('Sunucuyu Kaldır'); ?>" data-id="<?php echo $host->hosting_client_id; ?>" data-toggle="modal" data-target="#confirmation"></a>
				<a class="fa fa-edit close tip" data-original-title="<?php _e('Sunucuyu Düzenle'); ?>" data-id="<?php echo base64_encode(json_encode($host_data)); ?>" style="margin-right:5px" data-toggle="modal" data-target="#addServer"></a>
				

				<p></p>

				<h4>
					<table>
						<tr>
							<td style="width:150px;"><?php echo __("İstemci Adresi"); ?></td>
							<td><?php echo $host->hosting_client_IP; ?></td>
						</tr>
						<tr>
							<td style="width:150px;"><?php echo __("İstemci Port"); ?></td>
							<td><?php echo $host->hosting_client_port; ?></td>
						</tr>
					</table>
				</h4>
				<p></p>
			</div>

			<?php
			}
		}
	else
	{
		?>
		<div class="alert alert-block alert-warning fade in" style="margin:20px;">
				<p></p><h4><i class="fa fa-exclamation-circle"></i> Uyarı</h4>Henüz herhangi bir Sunucu Listesi oluşturulmamış. Bu durum, eserlerinizin yayınlanmasına engel teşkil edecektir.<p></p>
		</div>
<?php
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
 
$(document).on("click","#add_server",function(e){
	server_address_val=$('[name="server_address"]').val();
	server_port_val=$('[name="server_port"]').val();
	status =$('[name="status"]').val();
	
		$.ajax({
		  type: "POST",
		  url: '/organisationHostings/server',
		  data: {organisationId:'<?php echo $organisationId;?>',server_address:server_address_val,server_port:server_port_val,status:status}
		}).done(function(res){
			console.log(res);
			window.location.assign('/organisationHostings/index?organisationId='+'<?php echo $organisationId;?>');
		});

});
</script>