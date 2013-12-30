<?php
/* @var $this OrganisationsController */

$organisationId=$organizationUser['organisation_id'];


?>



<br><br><br>
<?php
	foreach ($workspaces as $key => $workspace) {
		?>
		<div class="row">
			<h3><?php echo $workspace['workspace_name']; ?></h3>
		

			<a href="#" popup="<?php echo $workspace['workspace_id']; ?>" class="btn white radius float-right book-editors-settings"id="boook-editors-settings" ><i class="icon-users"></i>Kullanıcılar</a>	
			



		</div>
<center id="popup-close-area" popup="pop-<?php echo $workspace['workspace_id']; ?>" style="display:none; position:relative">
				<div id="close-div" style="background-color:#123456; width:100% height:#123456; position:fixed;"> </div>
				<div class="book-editors-options-box-container">
				<h2>Workspace Users<a popup="close-<?php echo $workspace['workspace_id']; ?>" id="close-option-box"class="icon-close white size-15 delete-icon float-right" ></a></h2>
				<div class="editor-list">
				<?php 
					$workspaceUsers=$this->workspaceUsers($workspace['workspace_id']);

					foreach ($workspaceUsers as $key => $user): 
						?>
						<div id="editor-list-istems" class="editor-list-item">
							<span id="editor-name" class="editor-name">
							<?php echo $user['name']." ".$user['surname']; ?>
							</span>
							<a href="index.php?r=organisation/delWorkspaceUser&workspaceId=<?php echo $workspace['workspace_id']; ?>&userId=<?php echo $user['id']; ?>" class="icon-close size-15 delete-icon"></a>
							
						</div>	
				<?php endforeach; ?>
				</div>

				<div style="background-color:#fff; height: 60px; padding:5px; margin:10px; color:#333; text-align:left;">
					<span class="editor-name" >Kullanıcı Ekle:</span>
					<br style="clear:both; margin-bottom:20px;">
					<form id="a<?php echo $workspace['workspace_id']; ?>" method="post">
					<input id="workspaceId" value="<?php echo $workspace['workspace_id']; ?>" style="display:none">
					<select id="user" class="book-list-textbox radius grey-9 float-left"  style=" width: 280px;">
						<?php
							$organizationUsers = $this->freeWorkspaceUsers($workspace['workspace_id'],$organisationId);//$this->organizationUsers($organisationId);
							foreach ($organizationUsers as $key => $organizationUser) {
								echo '<option value="'.$organizationUser['id'].'">'.$organizationUser['name'].' '.$organizationUser['surname'].'</option>';
							}
						 ?>
					</select>
					</form>
					<a href="#" onclick="sendUser(a<?php echo $workspace['workspace_id']; ?>)" class="btn white radius float-right" style="margin-left:20px; width:50px; text-align:center;">
						Ekle
					</a>
				</div>

				</div>
			</center>
<script>
$("[popup='<?php echo $workspace['workspace_id']; ?>']").click(function(){
	$("[popup='pop-<?php echo $workspace['workspace_id']; ?>']").show("fast").draggable({containment: "#allWorkspaces"});
});
$("[popup='close-<?php echo $workspace['workspace_id']; ?>']").click(function(){
	$("[popup='pop-<?php echo $workspace['workspace_id']; ?>']").hide("fast");
});
</script>
		<?php
	}
?>

<script>											
function sendUser(e){
    var b = e.id;
    var userId=$('#' + b + '> #user').val();
    var type=$('#' + b + '> #type').val();
    var bookId=$('#' + b + ' > #book').val();
    var link ='?r=site/right&userId='+userId+'&bookId='+bookId+'&type='+type;
    window.location.assign(link);
    }
</script>