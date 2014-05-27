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
                <a class="btn pull-right brand_color_for_buttons" id='addNewBookBtn' href="/organisations/selectPlan/<?php echo $id?>">
                    <i class="fa fa-plus-circle"></i>
                    <span><?php _e('Bakiye Ekle') ?></span>
                </a>
			</div>
		</div>
	</div>
	<!-- /PAGE HEADER -->
	<div class="row">
 
        <div class="account_info_cards_container">
            <a href="/site/index">
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-book"></i></div>
                    <div class="account_info_data_number"><?php echo $book; ?></div>
                    <div class="account_info_data_type">Kitap</div>
                </div>
            </a>

            <a href="/organisations/workspaces?organizationId=<?php echo $id?>">
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-suitcase"></i></div>
                    <div class="account_info_data_number"><?php echo $workspace; ?></div>
                    <div class="account_info_data_type">Çalışma Alanı</div>
                </div>
            </a>
            
            <a href="/organisationHostings/index?organisationId=<?php echo $id?>">
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-desktop"></i></div>
                    <div class="account_info_data_number"><?php echo $host; ?></div>
                    <div class="account_info_data_type">Sunucu</div>
                </div>
            </a>
            
            <a href="/organisations/bookCategories/<?php echo $id?>">
                <div class="account_info_cards">
                    <div class="account_info_icon"><i class="fa fa-file-text"></i></div>
                    <div class="account_info_data_number"><?php echo $category; ?></div>
                    <div class="account_info_data_type">Yayın Kategorisi</div>
                </div>
            </a>
            
            <a href="/site/index">
            <div class="account_info_cards">
            <div class="account_info_icon"><i class="fa fa-dollar"></i></div>
            <div class="account_info_data_number"><?php echo $budget; ?></div>
            <div class="account_info_data_type">Yayın Üretme Bütçesi</div>
            </div>
            </a>
        </div>
        <!-- end of account_info_cards_container -->

	</div>
</div>