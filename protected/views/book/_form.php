<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/templatebook.css" media="all" />

</div> <!--header-->


<ol class="steps">
    <li class="step1"><span>Kitap Türü</span></li>
    <li class="step2 current"><span>Kitap Bilgileri</span></li>
    <li class="step3"><span>Şablonlar</span></li>
    <li class="step4"><span>Çözünürlük</span></li>
</ol>

<div class="form create-book-container white">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'book-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); 
	/*
	<div class="row">
		<?php echo $form->labelEx($model,'book_id'); ?>
		<?php echo $form->textField($model,'book_id',array('size'=>44,'maxlength'=>44)); ?>
		<?php echo $form->error($model,'book_id'); ?>
	</div>
	*/
	?>
	<div class="row">
		<h1>Kitap Bilgileri</h1>
	
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'workspace_id'); ?>

		<?php // echo $form->textField($model,'workspace_id',array('size'=>44,'maxlength'=>44)); 
		$userid=Yii::app()->user->id;
		//$workspacesOfUser= new WorkspacesUsers();

		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->join("user u","x.userid=u.id")
	    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
		
		$workspace_id_value = CHtml::listData($workspacesOfUser, 
                'workspace_id', 'workspace_name');    
		//print_r($workspace_id_value);

	   /* foreach ($workspacesOfUser as $key => $workspace) {
	    	$workspace_id_value[$workspace['workspace_id']]=$workspace['workspace_name'];

	    }
	    */
	    echo  $form->dropDownList($model,'workspace_id', $workspace_id_value
              ,$workspace_id_value
              );
		?>
		<?php echo $form->error($model,'workspace_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'publish_time'); ?>
		<?php echo $form->textField($model,'publish_time'); ?>
		<?php echo $form->error($model,'publish_time'); ?>
	</div>
-->
<!--
	<div class="row">
		<?php echo $form->labelEx($model,'data'); ?>
		<?php echo $form->textField($model,'data'); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>
	-->
	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<!-- <?php //echo $form->textField($model,'created'); ?>-->
		<?php echo $model->created; ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->