<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_id'); ?>
		<?php echo $form->textField($model,'faq_id'); ?>
		<?php echo $form->error($model,'faq_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_question'); ?>
		<?php echo $form->textField($model,'faq_question',array('size'=>60,'maxlength'=>10000)); ?>
		<?php echo $form->error($model,'faq_question'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_answer'); ?>
		<?php echo $form->textField($model,'faq_answer',array('size'=>60,'maxlength'=>10000)); ?>
		<?php echo $form->error($model,'faq_answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_frequency'); ?>
		<?php echo $form->textField($model,'faq_frequency'); ?>
		<?php echo $form->error($model,'faq_frequency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lang'); ?>
		<?php echo $form->textField($model,'lang',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'lang'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rate'); ?>
		<?php echo $form->textField($model,'rate'); ?>
		<?php echo $form->error($model,'rate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->