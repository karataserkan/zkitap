
<?php

$this->pageTitle=Yii::app()->name." - ". __("Kontrol Paneli");
?>


<script>
	jQuery(document).ready(function() {	
		$('#li_dashboard').addClass('current');	
		App.setPage("index");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>

<!-- PAGE -->
<div id="content" class="col-lg-12">
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h3 class="content-title pull-left">Kontrol Paneli</h3>
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->
<div class="row">
 
        <div class="account_info_cards_container" style="width:1380px">
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-building-o"></i></div>
                    <div class="account_info_data_number"><?php echo $organisation; ?></div>
                    <div class="account_info_data_type">Organizasyon</div>
                </div>

                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-book"></i></div>
                    <div class="account_info_data_number"><?php echo $book; ?></div>
                    <div class="account_info_data_type">Kitap</div>
                </div>

                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-suitcase"></i></div>
                    <div class="account_info_data_number"><?php echo $workspace; ?></div>
                    <div class="account_info_data_type">Çalışma Alanı</div>
                </div>
            
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-desktop"></i></div>
                    <div class="account_info_data_number"><?php echo $host; ?></div>
                    <div class="account_info_data_type">Sunucu</div>
                </div>
            
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-file-text"></i></div>
                    <div class="account_info_data_number"><?php echo $category; ?></div>
                    <div class="account_info_data_type">Yayın Kategorisi</div>
                </div>
            
            <div class="account_info_cards">
	            <div class="account_info_icon"><i class="fa fa-dollar"></i></div>
	            <div class="account_info_data_number"><?php echo $budget; ?></div>
	            <div class="account_info_data_type">Yayın Üretme Bütçesi</div>
            </div>
        </div>
        <!-- end of account_info_cards_container -->

	</div>
	<br><br>
<div class="separator"></div>
<?php /*?><!-- Dashboard Grafik Arayüzü -->

<!-- DASHBOARD CONTENT -->
						<div class="row">
							<!-- COLUMN 1 -->
							<div class="col-md-6">
								<div class="row">
								  <div class="col-lg-6">
									 <div class="dashbox panel panel-default">
										<div class="panel-body">
										   <div class="panel-left red">
												<i class="fa fa-instagram fa-3x"></i>
										   </div>
										   <div class="panel-right">
												<div class="number">6718</div>
												<div class="title">Likes</div>
												<span class="label label-success">
													26% <i class="fa fa-arrow-up"></i>
												</span>
										   </div>
										</div>
									 </div>
								  </div>
								  <div class="col-lg-6">
									 <div class="dashbox panel panel-default">
										<div class="panel-body">
										   <div class="panel-left blue">
												<i class="fa fa-twitter fa-3x"></i>
										   </div>
										   <div class="panel-right">
												<div class="number">2724</div>
												<div class="title">Followers</div>
												<span class="label label-warning">
													5% <i class="fa fa-arrow-down"></i>
												</span>
										   </div>
										</div>
									 </div>
								  </div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="quick-pie panel panel-default">
											<div class="panel-body">
												<div class="col-md-4 text-center">
													<div id="dash_pie_1" class="piechart" data-percent="59">
														<span class="percent"></span>
													</div>
													<a href="#" class="title">New Visitors <i class="fa fa-angle-right"></i></a>
												</div>
												<div class="col-md-4 text-center">
													<div id="dash_pie_2" class="piechart" data-percent="73">
														<span class="percent"></span>
													</div>
													<a href="#" class="title">Bounce Rate <i class="fa fa-angle-right"></i></a>
												</div>
												<div class="col-md-4 text-center">
													<div id="dash_pie_3" class="piechart" data-percent="90">
														<span class="percent"></span>
													</div>
													<a href="#" class="title">Brand Popularity <i class="fa fa-angle-right"></i></a>
												</div>
											</div>
										</div>
									</div>
							   </div>
							</div>
							<!-- /COLUMN 1 -->
							
							<!-- COLUMN 2 -->
							<div class="col-md-6">
								<div class="box solid grey">
									<div class="box-title">
										<h4><i class="fa fa-dollar"></i>Revenue</h4>
										<div class="tools">
											<span class="label label-danger">
												20% <i class="fa fa-arrow-up"></i>
											</span>
											<a href="#box-config" data-toggle="modal" class="config">
												<i class="fa fa-cog"></i>
											</a>
											<a href="javascript:;" class="reload">
												<i class="fa fa-refresh"></i>
											</a>
											<a href="javascript:;" class="collapse">
												<i class="fa fa-chevron-up"></i>
											</a>
											<a href="javascript:;" class="remove">
												<i class="fa fa-times"></i>
											</a>
										</div>
									</div>
									<div class="box-body">
										<div id="chart-revenue" style="height:240px"></div>
									</div>
								</div>
							</div>
							<!-- /COLUMN 2 -->
						</div>
					   <!-- /DASHBOARD CONTENT -->
					   <!-- HERO GRAPH -->
						<div class="row">
							<div class="col-md-12">
								<!-- BOX -->
								<div class="box border green">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i> <span class="hidden-inline-mobile">Traffic & Sales</span></h4>
									</div>
									<div class="box-body">
										<div class="tabbable header-tabs">
											<ul class="nav nav-tabs">
												 <li><a href="#box_tab2" data-toggle="tab"><i class="fa fa-search-plus"></i> <span class="hidden-inline-mobile">Select & Zoom Sales Chart</span></a></li>
												 <li class="active"><a href="#box_tab1" data-toggle="tab"><i class="fa fa-bar-chart-o"></i> <span class="hidden-inline-mobile">Traffic Statistics</span></a></li>
											 </ul>
											 <div class="tab-content">
												 <div class="tab-pane fade in active" id="box_tab1">
													<!-- TAB 1 -->
													<div id="chart-dash" class="chart"></div>
													<hr class="margin-bottom-0">
												   <!-- /TAB 1 -->
												 </div>
												 <div class="tab-pane fade" id="box_tab2">
													<div class="row">
														<div class="col-md-8">
															<div class="demo-container">
																<div id="placeholder" class="demo-placeholder"></div>
															</div>
														</div>
														<div class="col-md-4">
															<div class="demo-container" style="height:100px;">
																<div id="overview" class="demo-placeholder"></div>
															</div>
															<div class="well well-bottom">
																<h4>Month over Month Analysis</h4>
																<ol>
																	<li>Selection support makes it easy to construct flexible zooming schemes.</li>
																	<li>With a few lines of code, the small overview plot to the right has been connected to the large plot.</li>
																	<li>Try selecting a rectangle on either of them.</li>
																</ol>
															</div>
														</div>
													</div>
												</div>
											 </div>
										</div>
									</div>
								</div>
								<!-- /BOX -->
							</div>
						</div>
						<!-- /HERO GRAPH -->

<!-- /Dashboard Grafik Arayüzü --><?php */?>

	<div id="filter-items" class="mybooks_page_book_filter row">
<?php
if (!empty($books)&&$books) {
foreach ($books as $key2 => $book) {
$userType = $this->userType($book->book_id);
?>
<div class="reader_book_card">
	         <div class="reader_book_card_book_cover">
	         
	      <?php 
				$thumbnailSrc="/css/images/default-cover.jpg";
				$bookData=json_decode($book->data,true);
				 if (isset($bookData['thumbnail'])) {
				 	$thumbnailSrc=$bookData['thumbnail'];
				 }

			?>
	         	
	             <img src="<?php echo $thumbnailSrc; ?>" />
	         </div>					
	         <div class="reader_book_card_info_container">
	             <div class="editor_mybooks_book_type tip" style="border:0" data-original-title="<?php _e('Kitap Erişim İzini') ?>"><?php if ($userType=='owner') {_e('Sahibi');} ?><?php if ($userType=='editor') { _e('Editör'); } ?><?php if ($userType!='owner' && $userType!='editor') { _e('Diğer'); } ?></div>						
	             <div class="clearfix"></div>			
	             <div class="reader_market_book_name tip" data-original-title="Eser İsmi"><?php echo $book->title ?></div>						
	             <div class="clearfix"></div>						
	             <div class="reader_book_card_writer_name tip" data-original-title="<?php _e('Yazarın adı') ?>"><?php echo $book->author ?></div>											
	         </div>				
	     </div>


<?php } }?>
</div>
<!--/PAGE -->



    