<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


		<?php echo $content; ?>


	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>

<?php $this->endContent(); ?>