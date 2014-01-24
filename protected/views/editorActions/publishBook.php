<section>
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'publish-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
                       'onsubmit'=>"return false;",/* Disable normal form submit */
                       'onclick'=>"send();" /* Do ajax call when user presses enter key */
                     ),
)); 
?>

<?php
foreach ($hosts as $key => $host) {
	$contentHostIds[$host->hosting_client_id]=$host->hosting_client_IP;
}
$contentHostIds['GIWwMdmQXL']='cloud.lindneo.com';
?>

<div class="form-group">
	<?php echo "Sunucu" ?>
	<label class="checkbox-inline">
	<?php echo $form->checkBoxList($model,'contentHostId',$contentHostIds); ?>
	</label>

</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentTitle'); ?>
<?php echo $form->textField($model,'contentTitle'); ?>
</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentType'); ?>
<?php echo $form->dropDownList($model,'contentType',array('epub'=>'Epub','epdf'=>'Epdf','pdf'=>'pdf')); ?>
</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentExplanation'); ?>
<?php echo $form->textArea($model,'contentExplanation'); ?>
</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentIsForSale'); ?>
<?php echo $form->dropDownList($model,'contentIsForSale',array('Yes'=>__('Evet'),'Free'=>__('Hayır'))); ?>
</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentPrice'); ?>
<?php echo $form->textField($model,'contentPrice'); ?>
</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentPriceCurrencyCode'); ?>
<?php echo $form->dropDownList($model,'contentPriceCurrencyCode',array('949'=>'Türk Lirası','998'=>'Dolar','978'=>'Euro')); ?>
</div>

<div class="form-group">
<?php echo $form->labelEx($model,'contentReaderGroup'); ?>
<?php echo $form->textField($model,'contentReaderGroup'); ?>
</div>

<div class="row buttons">
		<?php echo CHtml::submitButton(__('Kaydet'),array('onclick'=>'send();')); ?>
	</div>

<?php $this->endWidget(); ?>
</section>
<script>
		jQuery(document).ready(function() {		
			App.setPage("forms");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<script type="text/javascript">
 
function send()
 {
 
   var data=$("#publish-form").serialize();

  $.ajax({
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl("editorActions/deneme"); ?>',
   data:data,
success:function(data){
                //alert(data); 
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
    },
 
  dataType:'html'
  });
 
}
 
</script>