<?php

?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/templatebook.css" media="all" />


<ol class="steps">
    <li class="step1"><span>Kitap Türü</span></li>
    <li class="step2"><span>Kitap Bilgileri</span></li>
    <li class="step3 current"><span>Şablonlar</span></li>
    <li class="step4"><span>Çözünürlük</span></li>
</ol>


<div class="templates_holder">

<?php

foreach ($layouts as $layout)
{
	?>
	<?php $tum='<div class="template_box"> 
	    <div class="template_title">'.$layout->title.'</div>
	    <div class="template_thumbnail" ><img src="'.Yii::app()->request->baseUrl.'/css/images/layouts/'.$layout->book_id.'.png" /></div>
    </div>'; ?>
    
<?=CHtml::link($tum,array('book/selectTemplate',"layout"=>$layout->book_id,'book_id'=>$book_id))?>
<?php }?>

</div>