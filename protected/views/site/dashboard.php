
<?php

$this->pageTitle=Yii::app()->name." - ". __("Kontrol Paneli");
?>


<script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
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
<!-- Dashboard Grafik Arayüzü -->

<div class="clearfix">
										<h3 class="content-title pull-left">Dashboard</h3>
										<!-- DATE RANGE PICKER -->
										<span class="date-range pull-right">
											<div class="btn-group">
												<a class="js_update btn btn-default" href="#">Today</a>
												<a class="js_update btn btn-default" href="#">Last 7 Days</a>
												<a class="js_update btn btn-default hidden-xs" href="#">Last month</a>
												
												<a id="reportrange" class="btn reportrange">
													<i class="fa fa-calendar"></i>
													<span>Custom</span>
													<i class="fa fa-angle-down"></i>
												</a>
											</div>
										</span>
										<!-- /DATE RANGE PICKER -->
									</div>
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
														<span class="percent">59%</span>
													<canvas height="121" width="121" style="height: 110px; width: 110px;"></canvas></div>
													<a href="#" class="title">New Visitors <i class="fa fa-angle-right"></i></a>
												</div>
												<div class="col-md-4 text-center">
													<div id="dash_pie_2" class="piechart" data-percent="73">
														<span class="percent">73%</span>
													<canvas height="121" width="121" style="height: 110px; width: 110px;"></canvas></div>
													<a href="#" class="title">Bounce Rate <i class="fa fa-angle-right"></i></a>
												</div>
												<div class="col-md-4 text-center">
													<div id="dash_pie_3" class="piechart" data-percent="90">
														<span class="percent">90%</span>
													<canvas height="121" width="121" style="height: 110px; width: 110px;"></canvas></div>
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
										<div id="chart-revenue" style="height: 240px; padding: 0px; position: relative;"><canvas class="flot-base" width="756" height="264" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 688px; height: 240px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 98px; top: 227px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 80px; text-align: center;">2</div><div style="position: absolute; max-width: 98px; top: 227px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 199px; text-align: center;">4</div><div style="position: absolute; max-width: 98px; top: 227px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 319px; text-align: center;">6</div><div style="position: absolute; max-width: 98px; top: 227px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 438px; text-align: center;">8</div><div style="position: absolute; max-width: 98px; top: 227px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 554px; text-align: center;">10</div><div style="position: absolute; max-width: 98px; top: 227px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 674px; text-align: center;">12</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; top: 217px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 13px; text-align: right;">0</div><div style="position: absolute; top: 163px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 7px; text-align: right;">25</div><div style="position: absolute; top: 110px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 7px; text-align: right;">50</div><div style="position: absolute; top: 57px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 7px; text-align: right;">75</div><div style="position: absolute; top: 4px; font-style: normal; font-variant: normal; font-weight: 400; font-size: 10px; line-height: 11.5px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); left: 2px; text-align: right;">100</div></div></div><canvas class="flot-overlay" width="756" height="264" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 688px; height: 240px;"></canvas></div>
									</div>
								</div>
							</div>
							<!-- /COLUMN 2 -->
						</div>
<!-- /Dashboard Grafik Arayüzü -->

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
	             <div class="editor_mybooks_book_type tip" style="border:0" data-original-title="<?php _e('Çalışma Durumu') ?>"><?php if ($userType=='owner') {_e('Sahibi');} ?><?php if ($userType=='editor') { _e('Editör'); } ?><?php if ($userType!='owner' && $userType!='editor') { _e('Editör veya sahibi değilsiniz'); } ?></div>						
	             <div class="clearfix"></div>			
	             <div class="reader_market_book_name tip" data-original-title="Eser İsmi"><?php echo $book->title ?></div>						
	             <div class="clearfix"></div>						
	             <div class="reader_book_card_writer_name tip" data-original-title="<?php _e('Yazarın adı') ?>"><?php echo $book->author ?></div>											
	         </div>				
	     </div>


<?php } }?>
</div>
<!--/PAGE -->



    