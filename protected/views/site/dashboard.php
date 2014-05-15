
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



    