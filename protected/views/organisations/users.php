<?php
/* @var $this OrganisationsController */
 ?>
 

<!-- POPUP add -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Kullanıcı Ekle"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="a<?php echo $organisationId; ?>" method="post">
					<span class="editor-name" ><?php _e('Email Adresi'); ?>:</span>
					<input id="email" value="">
					<input id="organisationId" value="<?php echo $organisationId; ?>" style="display:none">
			</form>
		</div>
      <div class="modal-footer">
      	<a href="#" onclick="sendUser(a<?php echo $organisationId; ?>)" class="btn btn-primary">
			<?php _e('Ekle'); ?>
		</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç"); ?></button>
      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->



 <div id="content" class="row">

	<div class="col-sm-12">
		<div class="page-header">

				<h3 class="content-title pull-left">Kullanıcılar</h3>
				<a class="btn pull-right btn-primary"  data-id="addUser" data-toggle="modal" data-target="#addUser" >
				<i class="fa fa-plus-circle"></i>
				<span><?php _e('Kullanıcı Ekle'); ?></span>
				</a>
		</div>
	</div>

</script>

 <?php
if ($users) {
	//_en('%s Kullanıcı Bulundu', '%s Kullanıcı Bulundu', count($users));
	?>
	<div>
	<?php
	if ($users):
	
	foreach ($users as $key => $user):
			?>

		<?php
			$avatarSrc=Yii::app()->request->baseUrl."/css/ui/img/avatars/profile.png";
			$userProfileMeta=UserMeta::model()->find('user_id=:user_id AND meta_key=:meta_key',array('user_id'=>$user->id,'meta_key'=>'profilePicture'));
			if ($userProfileMeta->meta_value) {
				$avatarSrc=$userProfileMeta->meta_value;
			}
		?>
		<div class="col-sm-2">	
		<div class="well">
		<img itemprop="image" class="col-sm-12" src="<?php echo $avatarSrc; ?>" style="height:120px">
		<h5 class="col-sm-12" style="text-transform:capitalize;"><?php echo $user->name . "  " .$user->surname;?></h5>
		<a href="?r=organisations/deleteOrganisationUser&userId=<?php echo $user->id; ?>&organisationId=<?php echo $organisationId; ?>" class="float-right" style="margin-left:14px"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<?php _e('Kullanıcılardan Çıkar'); ?></a>
		<div class="clearfix"></div>
		</div>
		</div>
		<?php
	endforeach;
	endif;
	?><?php
}
 ?>
</div>
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

<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>