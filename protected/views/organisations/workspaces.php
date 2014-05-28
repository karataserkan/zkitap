

<script>
		jQuery(document).ready(function() {		
			// App.setPage("gallery");  //Set current page
			// App.init(); //Initialise plugins and elements
		});
	</script>
<?php
/* @var $this OrganisationsController */

$organisationId=$organizationUser['organisation_id'];


?>
 <div id="content_main">
 <!--
	<div class="col-sm-12">
		<div class="page-header">
			<h3 class="content-title pull-left">Çalışma Alanı</h3>
			<a class="btn pull-right btn-primary " href="/workspaces/create?organisationId=<?php echo $organisationId; ?>"  popup="linden_team">
				<i class="fa fa-plus-circle"></i>
				<span><?php _e('Çalışma Alanı Ekle'); ?></span>
			</a>
		</div>
	</div>-->


	
<?php
	foreach ($workspaces as $key => $workspace) {
		?>
		<!--
		<div class="col-sm-3">	
			<div class="well">
			<h5 class="col-sm-12" style="text-transform:capitalize;"><?php echo $workspace['workspace_name']; ?></h5>
			<a id="#workspace-users" data-id="pop-<?php echo $workspace['workspace_id']; ?>" data-toggle="modal" data-target="#pop-<?php echo $workspace['workspace_id']; ?>" class="btn white radius float-right"><i class="icon-users"></i><?php _e('Kullanıcılar'); ?></a>	
			<a href="/workspaces/deleteWorkspace?id=<?php echo $workspace['workspace_id']; ?>&organisationId=<?php echo $organisationId; ?>" class="btn white radius float-right"><i class="icon-delete"></i><?php _e('Sil'); ?></a>
			<a href="/workspaces/updateWorkspace?id=<?php echo $workspace['workspace_id']; ?>&organisationId=<?php echo $organisationId; ?>" class="btn white radius float-right"><i class="icon-update"></i><?php _e('Düzenle'); ?></a>	
			<div class="clearfix"></div>
			</div>
		</div>-->



<!-- POPUP add -->
<div class="modal fade" id="pop-<?php echo $workspace['workspace_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Çalışma Alanı Kullanıcıları"); ?></h4>
		</div>
		<div class="modal-body">
			<?php 
					$workspaceUsers=$this->workspaceUsers($workspace['workspace_id']);

					foreach ($workspaceUsers as $key => $user): 
						?>
						<div id="editor-list-istems" class="editor-list-item">
							<a href="/organisations/delWorkspaceUser?workspaceId=<?php echo $workspace['workspace_id']; ?>&userId=<?php echo $user['id']; ?>&organizationId=<?php echo $organisationId; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
							<span id="editor-name" class="editor-name">
							<?php echo $user['name']." ".$user['surname']; ?>
							</span>
							<br><br>
						</div>	
				<?php endforeach; ?>

				<form id="a<?php echo $workspace['workspace_id']; ?>" method="post">
					<span class="editor-name" ><?php _e('Kullanıcı Ekle'); ?>:</span>
					<input id="workspaceId" value="<?php echo $workspace['workspace_id']; ?>" style="display:none">
					<input id="organisationId" value="<?php echo $organisationId; ?>" style="display:none">
					<select id="user" class="book-list-textbox radius grey-9 float-left"  style=" width: 280px;">
						<?php
							$organizationUsers = $this->freeWorkspaceUsers($workspace['workspace_id'],$organisationId);//$this->organizationUsers($organisationId);
							foreach ($organizationUsers as $key => $organizationUser) {
								echo '<option value="'.$organizationUser['id'].'">'.$organizationUser['name'].' '.$organizationUser['surname'].'</option>';
							}
						 ?>
					</select>
				</form>


		</div>
      <div class="modal-footer">
      	<a href="#" onclick="sendUser(a<?php echo $workspace['workspace_id']; ?>)" class="btn btn-primary">
			<?php _e('Ekle'); ?>
		</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Kapat"); ?></button>
      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->


		<?php
	}
?>


<script>											
function sendUser(e){
    var b = e.id;
    var userId=$('#' + b + '> #user').val();
    var workspaceId=$('#' + b + '> #workspaceId').val();
    var organisationId=$('#' + b + ' > #organisationId').val();
    var link ='/organisations/addWorkspaceUser?workspaceId='+workspaceId+'&userId='+userId+'&organizationId='+organisationId;
    window.location.assign(link);
    }
</script>
</div>

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
			
			if(target=='#addWorkspace')
			{
				var data=JSON.parse(atob(id));
				console.log(data);

				var workspace_id=data.workspace_id;
				var workspace_name=data.workspace_name;

				$('#acl').find('[name=workspace_name]').val(workspace_name);
				$('#acl').find('[name=status]').val(workspace_id);
			

				//$.each($('#acl').find('[name=type]'),function(i,val){console.log(val.value);});
			}
			else if(target=='#confirmation'){
				console.log('fssdf');
				$("#remove_ok").attr("data-id",id);
			}

		});

		function clearForm(){
			$('#acl').find('[name=workspace_name]').val("");
		}

		$('#confirmation').on('hidden.bs.modal', function () {
    		clearForm();
		});
		$('#addWorkspace').on('hidden.bs.modal', function () {
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
					  		url: "/workspaces/deleteWorkspace/",
					  		data: { organisationId:organisation_id, id: id_acl }
						}
				  )
				  .done(
					  		function( msg ) 
					  		{
					    		console.log("workspace removed!");
					    		location.reload();
					  		}
				  		);
		});
	});
</script>
<!-- POPUP EDITORS -->
<div class="modal fade" id="addWorkspace" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Çalışma Alanı Ekle"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="acl" method="post" class="form-horizontal">
		 		<input type="hidden" name="status" value="">
				<div class="form-group">
					<label class="control-label col-md-3" for="workspace_name"><?php _e('Çalışma Alanı Adı'); ?><span class="required">*</span></label>
					<div class="col-md-9">
						<input class="form-control" name="workspace_name" type="text">															
					</div>
				</div>
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="add_workspace"><?php _e("Ekle"); ?></a>
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
		  <h4 class="modal-title"><?php _e("Çalışma Alanı Sil"); ?></h4>
		</div>
		<div class="modal-body">
		Silmek istediğinizden emin misiniz?
		</div>
	      <div class="modal-footer">
	      	<button type="button" id="remove_ok" class="btn btn-primary" data-id="" id="remove_workspace"><?php _e("Evet"); ?></button>
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
				<h3 class="content-title pull-left"><?php _e('Çalışma Alanı Listesi'); ?></h3>
					
				<a class="btn pull-right btn-primary" data-id="addWorkspace" data-toggle="modal" data-target="#addWorkspace"><i class="fa fa-plus-circle"></i><span> Çalışma Alanı Ekle</span></a>
	
			
		</div>
	</div>
</div>


<div class="row">

<div class="box border blue" style="margin:20px;">
	<div id="acl_info_box_event" class="box-title">
		<h4 style="text-shadow:none"><i class="fa fa-info-circle"></i>Çalışma Alanı Listesi hakkında bilgiler!</h4>
		<div class="tools">
				<i class="fa fa-chevron-down"></i>
		</div>
	</div>
	<div  id="acl_info_box" class="box-body big" style="display: none;">
		<div class="jumbotron">
		  <h2>Çalışma Alanı listesi,</h2>
		  <p>Yayınlanan eserler çalışma alanlarına göre tutulmaktadır. Bu durumda siz de oluşturacağınız eseri istediğiniz çalışma alanında oluşturabilirsiniz</p>
		  
		</div>	

	</div>
</div>



</div>
<div class="row">

<?php
	if ($workspaces){

	foreach ($workspaces as $key => $workspace){

			$workspace_data = array(
								'workspace_id'=>$workspace['workspace_id'],
							   'workspace_name'=>$workspace['workspace_name']
							    );
			?>
			
			<div class="alert alert-block alert-info fade in" style="margin:20px;">
				<!--
				<a class="close" data-id="<?php echo $acl['id']; ?>" data-dismiss="alert" href="#" aria-hidden="true">
					×
				</a>-->

				<a class="fa fa-times-circle close" data-id="<?php echo $workspace['workspace_id']; ?>" style="margin-right:5px" data-toggle="modal" data-target="#confirmation"></a>
				<a class="fa fa-edit close" data-id="<?php echo base64_encode(json_encode($workspace_data)); ?>" style="margin-right:5px" data-toggle="modal" data-target="#addWorkspace"></a>
				<a class="fa fa-users close" data-id="pop-<?php echo $workspace['workspace_id']; ?>" style="margin-right:5px" data-toggle="modal" data-target="#pop-<?php echo $workspace['workspace_id']; ?>"></a>
				

				<p></p>

				<h4>
					<table>
						<tr>
							<td style="width:200px;"><?php echo __("Çalışma Alanı Adı"); ?></td>
							<td><?php echo $workspace['workspace_name']; ?></td>
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
				<p></p><h4><i class="fa fa-exclamation-circle"></i> Uyarı</h4>Henüz herhangi bir Çalışma Alanı Listesi oluşturulmamış. Bu durum, eserlerinizin oluşturulmasına engel teşkil edecektir.<p></p>
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
 
$(document).on("click","#add_workspace",function(e){
	workspace_name_val=$('[name="workspace_name"]').val();
	status =$('[name="status"]').val();
	console.log('<?php echo $organisationId;?>');
		$.ajax({
		  type: "POST",
		  url: '/workspaces/create',
		  data: {organisationId:'<?php echo $organisationId;?>',workspace_name:workspace_name_val,status:status}
		}).done(function(res){
			console.log(res);
			window.location.assign('/organisations/workspaces?organizationId='+'<?php echo $organisationId;?>');
		});

});
</script>
