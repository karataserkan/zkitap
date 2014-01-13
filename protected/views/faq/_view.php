<?php
/* @var $this FaqController */
/* @var $data Faq */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->faq_id), array('view', 'id'=>$data->faq_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_question')); ?>:</b>
	<?php echo CHtml::encode($data->faq_question); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_answer')); ?>:</b>
	<?php echo CHtml::encode($data->faq_answer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_frequency')); ?>:</b>
	<?php echo CHtml::encode($data->faq_frequency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lang')); ?>:</b>
	<?php echo CHtml::encode($data->lang); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate')); ?>:</b>
	<?php echo CHtml::encode($data->rate); ?>
	<br />


</div>