<div class="row">
					
		


<script>
	jQuery(document).ready(function() {	
		$('#li_dashboard').addClass('current');	
		App.setPage("index");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>

<!-- PAGE -->
<div id="content" class="col-lg-12" style="min-height:1300px !important">
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h3 class="content-title pull-left"><?php echo __("Yönetici Paneli"); ?> - <?php echo __("Organizasyonlar"); ?></h3>
		</div>
	</div>
</div>
<?php
// the pagination widget with some options to mess
$this->widget('CLinkPager', array(
                                    'currentPage'=>$pages->getCurrentPage(),
                                    'itemCount'=>$item_count,
                                    'pageSize'=>$page_size,
                                    'maxButtonCount'=>5,
                                    'htmlOptions'=>array('class'=>'pagination pagination-sm'),
                                    'firstPageLabel'=>'&lt;&lt;',
			                        'prevPageLabel'=>'&lt;',
			                        'nextPageLabel'=>'&gt;',        
			                        'lastPageLabel'=>'&gt;&gt;',
			                                        
                        			'header'=>"",  
                                )) ;
?>
<!-- /PAGE HEADER -->



<?php 
//var_dump($query1);
foreach($query1 as $q){
	$q=(object)$q;
?>
<div> 
	<h2><?php echo $q->organisation_name; ?> </h2>
	<a href="<?php echo Yii::app()->createUrl("organisations/account/$q->organisation_id" ); ?>" >Sayfa</a> - 
	<a href="<?php echo Yii::app()->createUrl("organisations/users", array("organisationId" => $q->organisation_id ) ); ?>" >Kullanıcılar</a>  - 
	<a href="<?php echo Yii::app()->createUrl("organisations/workspaces", array("organisationId" => $q->organisation_id ) ); ?>" >Çalışma Alanı</a>  - 
	<a href="<?php echo Yii::app()->createUrl("organisationHostings/index", array("organisationId" => $q->organisation_id ) ); ?>" >Sunucu</a>  - 
	<a href="<?php echo Yii::app()->createUrl("organisations/bookCategories/$q->organisation_id" ); ?>" >Yayın Kategorisi</a> - 
	<a href="<?php echo Yii::app()->createUrl("organisations/aCL/$q->organisation_id" ); ?>" >ACL</a> - 
	<a href="<?php echo Yii::app()->createUrl("organisations/publishedBooks/$q->organisation_id" ); ?>" >Yayınlanan Eserler</a>
</div>
<?php
} // loop to get data
?>

	</div>
</div>