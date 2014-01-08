
<?php
/* @var $this BookController */
/* @var $model BookDataForm */
/* @var $form CActiveForm */
$step_no=4;
include 'newBookSteps.php';	
?>

<div class="form create-book-container white" style="width:700px !important;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bookData-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<div class="row">
	<?php
		 echo $form->radioButtonList($model,'size',
	                    array(  0 => '2048 X 1536',
	                    		1 => '1920 X 1080',
	                            2 => '1400 X 1050',
	                            3 => '1366 X 768',
	                            4 => '1280 X 960',
	                            5 => '1280 X 800',
	                            6 => '1024 X 768',
	                            7 => '800 X 600' ),
	                  
	                   array(
	    					'labelOptions'=>array('style'=>'display:inline'),
	    					'separator'=>'     ',
							)
	                   );
	?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Kaydet'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->