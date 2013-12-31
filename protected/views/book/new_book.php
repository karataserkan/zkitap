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

<a href="?r=book/newBook&bookType=epub"><div class="epub"></div></a>

<a href="?r=book/newBook&bookType=pdf"><div class="pdf"></div></a>

</div>