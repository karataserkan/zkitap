<?php
/* @var $this WorkspacesController */
/* @var $model Workspaces */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workspaces-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'workspace_id'); ?>
		<?php echo $form->textField($model,'workspace_id',array('size'=>44,'maxlength'=>44)); ?>
		<?php echo $form->error($model,'workspace_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'workspace_name'); ?>
		<?php echo $form->textArea($model,'workspace_name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'workspace_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creation_time'); ?>
		<?php echo $form->textField($model,'creation_time'); ?>
		<?php echo $form->error($model,'creation_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->