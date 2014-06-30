<?php
$step_no=3;
include 'newBookSteps.php';
?>
</div>

<div class="form create-book-container white">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'FileForm',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
		
	<div class="row">
		<?php echo $form->labelEx($model,'pdf_file'); ?>
		<?php echo $form->fileField($model, 'pdf_file'); ?>
		<?php echo $form->error($model,'pdf_file'); ?>
	</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton(__('Yükle')); ?>
	</div>

<?php $this->endWidget(); ?>