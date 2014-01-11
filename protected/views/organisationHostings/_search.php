<?php
/* @var $this OrganisationHostingsController */
/* @var $model OrganisationHostings */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'organisation_id'); ?>
		<?php echo $form->textField($model,'organisation_id',array('size'=>44,'maxlength'=>44)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hosting_client_IP'); ?>
		<?php echo $form->textField($model,'hosting_client_IP',array('size'=>60,'maxlength'=>120)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hosting_client_port'); ?>
		<?php echo $form->textField($model,'hosting_client_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hosting_client_id'); ?>
		<?php echo $form->textField($model,'hosting_client_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hosting_client_key1'); ?>
		<?php echo $form->textArea($model,'hosting_client_key1',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hosting_client_key2'); ?>
		<?php echo $form->textArea($model,'hosting_client_key2',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->