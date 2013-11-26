<?php

foreach ($layouts as $layout)
{
	echo $layout->title; ?>
	<br>--<br>
	<p><?= CHtml::link('use',array('book/author',"bookId"=>$layout->book_id))?></p>
<?}?>