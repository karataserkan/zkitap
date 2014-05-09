<?php
/* @var $this OrganisationsController */
/* @var $dataProvider CActiveDataProvider */
 ?>
 <script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>
 <div id="content" class="col-lg-12">
	<!-- PAGE HEADER-->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-header">
				<h3 class="content-title pull-left"><?php _e('Hesabım') ?></h3>
			</div>
		</div>
	</div>
	<!-- /PAGE HEADER -->
	<div class="row">
 
        <div class="account_info_cards_container">
            <div class="account_info_cards">
            <div class="account_info_icon"><i class="fa fa-book"></i></div>
            <div class="account_info_data_number">17</div>
            <div class="account_info_data_type">Kitap</div>
            </div>
            
            <div class="account_info_cards">
            <div class="account_info_icon"><i class="fa fa-suitcase"></i></div>
            <div class="account_info_data_number">4</div>
            <div class="account_info_data_type">Çalışma Alanı</div>
            </div>
            
            <div class="account_info_cards">
            <div class="account_info_icon"><i class="fa fa-desktop"></i></div>
            <div class="account_info_data_number">1</div>
            <div class="account_info_data_type">Sunucu</div>
            </div>
            
            <div class="account_info_cards">
            <div class="account_info_icon"><i class="fa fa-file-text"></i></div>
            <div class="account_info_data_number">8</div>
            <div class="account_info_data_type">Yayın Kategorisi</div>
            </div>
            
            <div class="account_info_cards">
            <div class="account_info_icon"><i class="fa fa-turkish-lira"></i></div>
            <div class="account_info_data_number">5</div>
            <div class="account_info_data_type">Yayın Üretme Bütçesi</div>
            </div>
        </div>
        <!-- end of account_info_cards_container -->

	</div>
</div>