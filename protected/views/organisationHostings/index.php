<?php
/* @var $this OrganisationHostingsController */
/* @var $dataProvider CActiveDataProvider */
?>

 <div id="content" class="row">

	<div class="col-sm-12">
		<div class="page-header">

			<h3 class="content-title pull-left">Sunucular</h3>
			<i class="fa fa-plus-circle"></i><?php echo CHtml::link(__('Ekle'),"/organisationHostings/create?organisationId=".$organisationId,array('class'=>'btn pull-right btn-primary')); ?>
			</a>
		</div>
	</div>


<?php
if ($hostings):
	foreach ($hostings as $key => $host):
	?>
	<div class="row">
	<h3><?php echo __("İstemci ID").": ".$host->hosting_client_id; ?></h3>
	<ul>
		<li><span><?php echo __("İstemci IP").": ".$host->hosting_client_IP; ?></span></li>
		<li><span><?php echo __("İstemci Port").": ".$host->hosting_client_port; ?></span></li>
		<li><span><?php echo __("İstemci Key1").": ".$host->hosting_client_key1; ?></span></li>
		<li><span><?php echo __("İstemci Key2").": ".$host->hosting_client_key2; ?></span></li>
	</ul>
	<?php echo CHtml::link(__('Düzenle'),"/organisationHostings/update?organisationId=".$organisationId.'&id='.$host->hosting_client_id,array('class'=>'btn white radius')); ?>
	<?php echo CHtml::link(__('Sil'),"/organisationHostings/deleteHost?organisationId=".$organisationId.'&id='.$host->hosting_client_id,array('class'=>'btn white radius')); ?>
	</div>
	<hr>
	<?php	
	endforeach;
endif;
?>

</div>