<?php
/* @var $this BookController */
/* @var $model BookDataForm */
/* @var $form CActiveForm */
?>

</div> <!--header-->

<div style="height: 40px;"></div>


<div class="form create-book-container white" >

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bookData-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<div class="row">
	<?php
		 echo $form->radioButtonList($model,'size',
	                    array(  0 => '1920 X 1080',
	                            1 => '1400 X 1050',
	                            2 => '1280 X 960',
	                            3 => '1024 X 768',
	                            4 => '800 X 600' ),
	                  
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