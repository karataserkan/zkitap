



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
			<h3 class="content-title pull-left"><?php echo __("Yönetici Paneli"); ?></h3>
		</div>
	</div>
</div>


<!-- /PAGE HEADER -->

 
        <div class="col-md-6">
								<div class="box border red">
									<div class="box-title">
										<h4><i class="fa fa-bitbucket"></i><?php echo __("Organizasyonlar"); ?></h4>
									</div>
									<div class="box-body big">
										<div class="jumbotron">
										  <h1><?php echo __("Organizasyonlar"); ?></h1>
										  <p><?php echo __("Organizasyonları yönetmek için lütfen tıklayınız"); ?></p>
										  <p><a href='<?php echo Yii::app()->createUrl('management/organisations'); ?>' class="btn btn-primary btn-lg" role="button"><?php echo __("Organizasyonlar"); ?></a></p>
										</div>
									</div>
								</div>
							</div>

	

	 <div class="col-md-6">
								<div class="box border red">
									<div class="box-title">
										<h4><i class="fa fa-bitbucket"></i><?php echo __("Kullanıcılar"); ?></h4>
									</div>
									<div class="box-body big">
										<div class="jumbotron">
										  <h1><?php echo __("Kullanıcılar"); ?></h1>
										  <p><?php echo __("Kullanıcıları yönetmek için lütfen tıklayınız"); ?></p>
										  <p><a class="btn btn-primary btn-lg" role="button"><?php echo __("Kullanıcılar"); ?></a></p>
										</div>
									</div>
								</div>
							</div>


	 <div class="col-md-6">
								<div class="box border red">
									<div class="box-title">
										<h4><i class="fa fa-bitbucket"></i><?php echo __("Çalışma Alanları"); ?></h4>
									</div>
									<div class="box-body big">
										<div class="jumbotron">
										  <h1><?php echo __("Çalışma Alanları"); ?></h1>
										  <p><?php echo __("Çalışma Alanlarını yönetmek için lütfen tıklayınız"); ?></p>
										  <p><a class="btn btn-primary btn-lg" role="button"><?php echo __("Çalışma Alanları"); ?></a></p>
										</div>
									</div>
								</div>
							</div>
	 <div class="col-md-6">
							<div class="box border red">
								<div class="box-title">
									<h4><i class="fa fa-bitbucket"></i><?php echo __("Kitaplar"); ?></h4>
								</div>
								<div class="box-body big">
									<div class="jumbotron">
									  <h1><?php echo __("Kitaplar"); ?></h1>
									  <p><?php echo __("Kitapları yönetmek için lütfen tıklayınız"); ?></p>
									  <p><a class="btn btn-primary btn-lg" role="button"><?php echo __("Kitaplar"); ?></a></p>
									</div>
								</div>
							</div>
						</div>
	<br><br>




    

	</div>