<?php
$step_no=3;
include 'newBookSteps.php';
?>
</div>
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