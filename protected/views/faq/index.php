<?php
/* @var $this FaqController */
/* @var $dataProvider CActiveDataProvider */
?>
<br><br><br>
<table>
	<tr style="font-weight:bold">
		<td>Id</td>
		<td><?php _e('Soru'); ?></td>
		<td><?php _e('Cevap'); ?></td>
		<td><?php _e('Sıklık'); ?></td>
		<td><?php _e('Değerlendirme'); ?></td>
		<td><?php _e('Dil'); ?></td>
		<td><?php _e('Kategoriler'); ?></td>
		<td><?php _e('Anahtar Kelimeler'); ?></td>
	</tr>
<?php
asdfasdfasdf
foreach ($faqs as $key => $data): ?>
<tr>
	<td><?php echo $data['faq']->faq_id; ?></td>
	<td><?php echo $data['faq']->faq_question; ?></td>
	<td><?php echo $data['faq']->faq_answer; ?></td>
	<td><?php echo $data['faq']->faq_frequency; ?></td>
	<td><?php echo $data['faq']->rate; ?></td>
	<td><?php echo $data['faq']->lang; ?></td>
	<?php if (!empty($data['categories'])):
		$categories="";
		foreach ($data['categories'] as $key2 => $category): 
			$categories .= ($key2 != 0) ? ', ' : '' ;
			$categories .=$category->faq_category_title;
		endforeach; ?>
		<td><?php echo $categories; ?></td>
	<?php else: ?>
	<td>-</td>
	<?php endif; ?>
	<?php if (!empty($data['keywords']) && isset($data['keywords'])):
		$keywords="";
		foreach ($data['keywords'] as $key3 => $keyword):
			$keywords .=($key3 != 0)? ', ': '';
			$keywords .= $keyword->keyword; 
		endforeach; ?>
		<td><?php echo $keywords; ?></td>
	<?php else: ?>
	<td>-</td>
	<?php endif; ?>
</tr>
<?php endforeach; ?>
</table>
<?php echo CHtml::link(__('Ekle'),"/faq/create",array('class'=>'btn white radius')); ?>