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



<!-- POPUP add -->
<div class="modal fade" id="delUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Kullanıcıyı Kaldır"); ?></h4>
		</div>
		<div class="modal-body">
		 	Kullanıcıyı kaldırmak istediğinizden emin misiniz?
		</div>
      <div class="modal-footer">
      	<a href="#" id="delUserBtn" class="btn btn-primary">
			<?php _e('Kaldır'); ?>
		</a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç"); ?></button>
      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->



 <div id="content">

	<div class="col-sm-12">
		<div class="page-header" style="overflow:visible; padding-bottom:50px;">

				<h3 class="content-title pull-left">Kullanıcılar</h3>
                
                
                                        <div class="action_bar_spacer"></div>
                                        
                                        <ul class="users_category_actions">
                                            <li class="dropdown users_page_categories">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Davetli Kullanıcı Listesi <i class="fa fa-chevron-down"></i></a>
                                                    <ul class="dropdown-menu" id="filter-controls">
                                                        <li><div class="invited_user_status users_waiting tip-left" title="Bekleniyor..."></div><span>Bekleyen Kullanıcı</span></li>
                                                        <li><div class="invited_user_status users_refused tip-left" title="Reddedildi"></div><span>Reddeden Kullanıcı</span></li>
                                                        <li><div class="invited_user_status users_accepted tip-left" title="Onaylandı"></div><span>Onaylayan Kullanıcı</span></li>
                                                    </ul>
                                            </li>
                                        </ul>

                
                
                
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
		<div class="users_frame">	
		
		<img itemprop="image" class="col-sm-12 clearfix" src="<?php echo $avatarSrc; ?>">
		<h5 class="col-sm-12" style="text-transform:capitalize;"><?php echo $user->name . "  " .$user->surname;?></h5>
		<!-- <a class="col-sm-12" href="?r=organisations/deleteOrganisationUser&userId=<?php echo $user->id; ?>&organisationId=<?php echo $organisationId; ?>"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<?php _e('Kullanıcılardan Çıkar'); ?></a> -->
		<a class="col-sm-12 delUser" data-id="<?php echo $user->id; ?>" data-toggle="modal" data-target="#delUser" href="#" user="<?php echo $user->id; ?>"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<?php _e('Kullanıcılardan Çıkar'); ?></a>
		<div class="clearfix"></div>
		</div>
		<?php
	endforeach;
	endif;
	?>
	<?php 
	if ($invitated) { ?>
</div>
<div class="col-sm-12">

				<h3 class="content-title pull-left">Davetli Kullanıcılar</h3>
	</div>

		<?php foreach ($invitated as $key => $user) { ?>
			<div class="users_frame">	
				<h5><?php echo $user->email; ?></h5>
			</div>
		<?php }
	}

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

<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements

			var userId;
			var organisationId="<?php echo $organisationId;?>";
			$('.delUser').click(function(){
				userId=$(this).data("id");
			});
			$('#delUserBtn').click(function(){
				$.ajax(
	  					{
					  		type: "POST",
					  		url: "/organisations/deleteOrganisationUser/",
					  		data: { userId:userId,organisationId:organisationId }
						}
				  )
				  .done(
				  		function( msg ) 
				  		{
				    		console.log("user removed!");
				    		location.reload();
				  		}
			  		);
			});
		});
	</script>