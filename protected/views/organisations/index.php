<?php
/* @var $this OrganisationsController */
/* @var $dataProvider CActiveDataProvider */
 ?>
 <?php echo CHtml::link(__('Çalışma Alanı'),"/organisations/workspaces?organizationId=".$organizationId,array('class'=>'btn white radius')); ?>
<br><br>
<?php echo CHtml::link(__('Kullanıcılar'),"/organisations/users?organisationId=".$organizationId,array('class'=>'btn white radius')); ?>
