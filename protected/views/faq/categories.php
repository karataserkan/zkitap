<?php
/* @var $this FaqController */
/* @var $dataProvider CActiveDataProvider */
?>
<br><br><br>
<div class="row">
<?php
foreach ($data as $key => $category): ?>
	<div class="row">
		<?php
		foreach ($category as $key => $faq):
			echo $faq['faq']->faq_question;
		endforeach;
		?>
	</div>
<?php 
endforeach;
?>
</div>