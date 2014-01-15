 <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<br><br><br>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-create-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_categories'); ?>
		<?php echo $form->dropDownList($model,'faq_categories',$categories,
					array(
	    					'multiple' => 'true',
	    					'selected'=>'selected',
							)
	                   );
	?>
		<?php echo $form->error($model,'faq_categories'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_keywords'); ?>
		<?php echo $form->textField($model,'faq_keywords'); ?>
		<?php echo $form->error($model,'faq_keywords'); ?>
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

 <script>
$(function() {
function split( val ) {
return val.split( /,\s*/ );
}
function extractLast( term ) {
return split( term ).pop();
}
$( "#FaqCreateForm_faq_keywords" )
// don't navigate away from the field on tab when selecting an item
.bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).data( "ui-autocomplete" ).menu.active ) {
event.preventDefault();
}
})
.autocomplete({
source: function( request, response ) {

$.getJSON( "/faq/searchKey", {
term: extractLast( request.term )
}, response );
},
search: function() {
// custom minLength
var term = extractLast( this.value );
if ( term.length < 2 ) {
return false;
}
},
focus: function() {
// prevent value inserted on focus
return false;
},
select: function( event, ui ) {
var terms = split( this.value );
// remove the current input
terms.pop();
// add the selected item
terms.push( ui.item.value );
// add placeholder to get the comma-and-space at the end
terms.push( "" );
this.value = terms.join( ", " );
return false;
}
});
});
</script>