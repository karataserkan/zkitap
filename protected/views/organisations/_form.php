<?php
/* @var $this OrganisationsController */
/* @var $model Organisations */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'organisations-form',
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
		<?php echo $form->labelEx($model,'organisation_name'); ?>
		<?php echo $form->textArea($model,'organisation_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'organisation_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'organisation_admin'); ?>
		<?php echo $form->textField($model,'organisation_admin',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'organisation_admin'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->