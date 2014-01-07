<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/templatebook.css" media="all" />

</div> <!--header-->


<ol class="steps"> 
    <li class="step1 <?php echo $step_no==1  ? "current" : "" ?>"  ><span><?php _e('Kitap Türü') ?></span></li>
    <li class="step2 <?php echo $step_no==2  ? "current" : "" ?>"><span><?php _e('Kitap Bilgileri') ?> </span></li>
    <li class="step3 <?php echo $step_no==3  ? "current" : "" ?>"><span><?php _e('Şablonlar') ?></span></li>
    <li class="step4 <?php echo $step_no==4  ? "current" : "" ?>"><span><?php _e('Çözünürlük') ?></span></li>
</ol>
