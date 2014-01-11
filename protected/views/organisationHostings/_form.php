<?php
/* @var $this OrganisationHostingsController */
/* @var $model OrganisationHostings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organisation-hostings-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'organisation_id'); ?>
		<?php echo $form->textField($model,'organisation_id',array('size'=>44,'maxlength'=>44)); ?>
		<?php echo $form->error($model,'organisation_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hosting_client_IP'); ?>
		<?php echo $form->textField($model,'hosting_client_IP',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'hosting_client_IP'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hosting_client_port'); ?>
		<?php echo $form->textField($model,'hosting_client_port'); ?>
		<?php echo $form->error($model,'hosting_client_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hosting_client_id'); ?>
		<?php echo $form->textField($model,'hosting_client_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'hosting_client_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hosting_client_key1'); ?>
		<?php echo $form->textArea($model,'hosting_client_key1',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'hosting_client_key1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hosting_client_key2'); ?>
		<?php echo $form->textArea($model,'hosting_client_key2',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'hosting_client_key2'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->