
<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
<?php
/* @var $this OrganisationsController */

$organisationId=$organizationUser['organisation_id'];


?>
 <div id="content" class="row">

	<div class="col-sm-12">
		<div class="page-header">
			<h3 class="content-title pull-left">Çalışma Alanı</h3>
			<a class="btn pull-right btn-primary " href="/workspaces/create?organisationId=<?php echo $organisationId; ?>"  popup="linden_team">
				<i class="fa fa-plus-circle"></i>
				<span><?php _e('Çalışma Alanı Ekle'); ?></span>
			</a>
		</div>
	</div>


	
<?php
	foreach ($workspaces as $key => $workspace) {
		?>
		
		<div class="col-sm-3">	
			<div class="well">
			<h5 class="col-sm-12" style="text-transform:capitalize;"><?php echo $workspace['workspace_name']; ?></h5>
			<a id="#workspace-users" data-id="pop-<?php echo $workspace['workspace_id']; ?>" data-toggle="modal" data-target="#pop-<?php echo $workspace['workspace_id']; ?>" class="btn white radius float-right"><i class="icon-users"></i><?php _e('Kullanıcılar'); ?></a>	
			<a href="/workspaces/deleteWorkspace?id=<?php echo $workspace['workspace_id']; ?>&organisationId=<?php echo $organisationId; ?>" class="btn white radius float-right"><i class="icon-delete"></i><?php _e('Sil'); ?></a>
			<a href="/workspaces/updateWorkspace?id=<?php echo $workspace['workspace_id']; ?>&organisationId=<?php echo $organisationId; ?>" class="btn white radius float-right"><i class="icon-update"></i><?php _e('Düzenle'); ?></a>	
			<div class="clearfix"></div>
			</div>
		</div>



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