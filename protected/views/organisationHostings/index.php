<?php
/* @var $this OrganisationHostingsController */
/* @var $dataProvider CActiveDataProvider */
?>
<br><br><br>
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
	<?php echo CHtml::link(__('Düzenle'),"/organisationHostings/update?organisationId=".$organisationId.'&id'.$host->hosting_client_id,array('class'=>'btn white radius')); ?>
	</div>
	<hr>
	<?php	
	endforeach;
endif;
?>