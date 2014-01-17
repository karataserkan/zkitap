<?php
/* @var $this FaqController */
/* @var $dataProvider CActiveDataProvider */
?>
<br><br><br>
<div class="row">
<?php
foreach ($data as $key => $category): ?>
	<div class="row">
	<h1><?php echo (!isset($category['category']->faq_category_title))? '--':$category['category']->faq_category_title; ?></h1>
		<?php
		foreach ($category as $key2 => $faq): ?>
			<div class="row">
			<h2><?php	echo $faq['faq']->faq_question; ?></h2>
			<p><?php echo $faq['faq']->faq_answer; ?></p>
			<p>
			<?php 
				if (!empty($faq['keywords']) && isset($faq['keywords'])):
				foreach ($faq['keywords'] as $key3 => $keyword):?>
					<?php echo ($key3!=0) ? ',' : '' ;?>
					<a href="/faq/keyword?keyword=<?php echo $keyword->keyword_id; ?>"><?php echo $keyword->keyword;?></a>
				<?php endforeach;
				endif;
			?>
			</p>
		</div>
		<hr>
		<?php
		endforeach;
		?>
	</div>
<?php 
endforeach;
?>
</div>