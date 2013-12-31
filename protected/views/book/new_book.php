<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/templatebook.css" media="all" />
</div> <!--header-->




<ol class="steps">
    <li class="step1 current"><span>Kitap Türü</span></li>
    <li class="step2"><span>Kitap Bilgileri</span></li>
    <li class="step3"><span>Şablonlar</span></li>
    <li class="step4"><span>Çözünürlük</span></li>
</ol>



<div class="new_book_page_content">

<div class="epub"><a href="#"><?=CHtml::link('Epub',array('book/newBook',"bookType"=>'epub'))?></a></div>

<div class="pdf"><a href="#"><?=CHtml::link('Pdf',array('book/newBook',"bookType"=>'pdf'))?></a></div>

</div>