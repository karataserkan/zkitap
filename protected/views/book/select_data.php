
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
	                    array(  "2048x1536" => '2048 X 1536',
	                    		'1920x1080' => '1920 X 1080',
	                            '1400x1050' => '1400 X 1050',
	                            '1366x768' => '1366 X 768',
	                            '1280x960' => '1280 X 960',
	                            '1280x800' => '1280 X 800',
	                            '1024x768' => '1024 X 768',
	                            '800x600' => '800 X 600' ),
	                  
	                   array(
	    					'labelOptions'=>array('style'=>'display:inline'),
	    					'separator'=>'     ',
							)
	                   );
	?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(__('Kaydet')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->