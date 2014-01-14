<br><br><br>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-create-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_categories'); ?>
		<?php echo $form->checkBoxList($model,'faq_categories',
	                    $categories,
	                  
	                   array(
	    					'labelOptions'=>array('style'=>'display:inline'),
	    					'separator'=>'     ',
							)
	                   );
	?>
		<?php echo $form->error($model,'faq_categories'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton(__('Kaydet')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->