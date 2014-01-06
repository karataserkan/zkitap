<?php
/* @var $this OrganisationsController */
 ?><div class="row">
 <br>
 <br>
 <br>
 <br>

 <?php
if ($users) {
	foreach ($users as $key => $user):
			?>
		<div class="row">
		<?php echo $user->name . "  " .$user->surname;?>
		<a href="?r=organisations/deleteOrganisationUser&userId=<?php echo $user->id; ?>&organisationId=<?php echo $organisationId; ?>" class="btn white radius float-right book-editors-settings"id="boook-editors-settings" ><i class="icon-delete"></i>Sil</a>
		</div>
		<?php
	endforeach;
}
 ?>
</div>
<div class="row">
	<a href="#" popup="<?php echo $organisationId; ?>" class="btn white radius float-right book-editors-settings"id="boook-editors-settings" ><i class="icon-add"></i>Kullanıcı Ekle</a>	
	<center id="popup-close-area" popup="pop-<?php echo $organisationId; ?>" style="display:none; position:relative">
				<div id="close-div" style="background-color:#123456; width:100% height:#123456; position:fixed;"> </div>
				<div class="book-editors-options-box-container" style="height:150px">
				<h2>Kullanıcı Ekle<a popup="close-<?php echo $organisationId; ?>" id="close-option-box"class="icon-close white size-15 delete-icon float-right" ></a></h2>
				

				<div style="background-color:#fff; height: 90px; padding:5px; margin:10px; color:#333; text-align:left;">
					<span class="editor-name" >Kullanıcı Ekle:</span>
					<br style="clear:both; margin-bottom:20px;">
					<form id="a<?php echo $organisationId; ?>" method="post">
					<input id="email" value="">
					<input id="organisationId" value="<?php echo $organisationId; ?>" style="display:none">
					</form>
					<a href="#" onclick="sendUser(a<?php echo $organisationId; ?>)" class="btn white radius float-right" style="margin-left:20px; width:50px; text-align:center;">
						Ekle
					</a>
				</div>

				</div>
			</center>
<script>
$("[popup='<?php echo $organisationId; ?>']").click(function(){
	$("[popup='pop-<?php echo $organisationId; ?>']").show("fast").draggable({containment: "#allWorkspaces"});
});
$("[popup='close-<?php echo $organisationId; ?>']").click(function(){
	$("[popup='pop-<?php echo $organisationId; ?>']").hide("fast");
});
</script>
</div>
<script>											
function sendUser(e){
    var b = e.id;
    var email=$('#' + b + '> #email').val();
    var organisationId=$('#' + b + ' > #organisationId').val();
    var link ='?r=organisations/addUser&email='+email+'&organisationId='+organisationId;
    window.location.assign(link);
    }
</script>