<?php
/* @var $this OrganisationsController */
 ?>
 <div id="content" class="row">

	<div class="col-sm-12">
		<div class="page-header">
			
			
				<h3 class="content-title pull-left">Kullanıcılar</h3>
										
				<a class="btn pull-right btn-primary" id="boook-editors-settings" href="#" popup="<?php echo $organisationId; ?>" >
											<i class="fa fa-plus-circle"></i>
											<span><?php _e('Kullanıcı Ekle'); ?></span>
										</a>
		</div>
	</div>
		
	
		
	<center id="popup-close-area" popup="pop-<?php echo $organisationId; ?>" style="display:none; position:relative">
				<div id="close-div" style="background-color:#123456; width:100% height:#123456; position:fixed;"> </div>
				<div class="book-editors-options-box-container" style="height:150px">
				<h2><?php _e('Kullanıcı Ekle'); ?><a popup="close-<?php echo $organisationId; ?>" id="close-option-box"class="icon-close white size-15 delete-icon float-right" ></a></h2>
				

				<div style="background-color:#fff; height: 90px; padding:5px; margin:10px; color:#333; text-align:left;">
					<span class="editor-name" ><?php _e('Kullanıcı Ekle'); ?>:</span>
					<br style="clear:both; margin-bottom:20px;">
					<form id="a<?php echo $organisationId; ?>" method="post">
					<input id="email" value="">
					<input id="organisationId" value="<?php echo $organisationId; ?>" style="display:none">
					</form>
					<a href="#" onclick="sendUser(a<?php echo $organisationId; ?>)" class="btn white radius float-right" style="margin-left:20px; width:50px; text-align:center;">
						<?php _e('Ekle'); ?>
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

 <?php
if ($users) {
	_en('%s Kullanıcı Bulundu', '%s Kullanıcı Bulundu', count($users));
	?>
	<div>
	<?php
	foreach ($users as $key => $user):
			?>
		<div class="col-sm-2">	
		<div class="well">
		<img itemprop="image" class="col-sm-12" src="http://2.s3.envato.com/files/89938742/callcenterfemale_3541.jpg">
		<h5 class="col-sm-12" style="text-transform:capitalize;"><?php echo $user->name . "  " .$user->surname;?></h5>
		<a href="?r=organisations/deleteOrganisationUser&userId=<?php echo $user->id; ?>&organisationId=<?php echo $organisationId; ?>" class="float-right" style="margin-left:14px"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<?php _e('Kullanıcılardan Çıkar'); ?></a>
		<div class="clearfix"></div>
		</div>
		</div>
		<?php
	endforeach;
	?><?php
}
 ?>
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