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