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
<?php if ($plan) {
    $planName=__('Başlangıç Paketi');
    if ($plan->transaction_explanation==2) {
        $planName=__('Temel Paket');
     }elseif ($plan->transaction_explanation==3) {
        $planName=__('Ayrıcalıklı Paket');
     }elseif ($plan->transaction_explanation==4) {
        $planName=__('Kurumsal Paket');
     }
 }
?>
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
    <div class="row"><br><br></div>
    <div class="row">
        <div class="col-md-3">
            <div class="box border <?php 
                                    if($remainDay<5){
                                        echo 'red';
                                    }elseif($remainDay<10){
                                        echo 'orange';
                                    }
                                    else{
                                        echo 'green';
                                    }
                                    ?>">
                <div class="box-title">
                    <h4><i class="fa fa-briefcase"></i>Plan</h4>
                </div>
                <div class="box-body">
                    <?php if ($plan) { ?>
                        <?php _e('Geçerli planınız: '); echo $planName; ?><br>
                        <?php _e('Planınızın biteceği tarih: '); echo $lastDay; ?><br>
                        <?php _e('Kalan gün: '); echo $remainDay; ?><br><br>
                        <a class="btn btn-primary" id='addNewBookBtn' href="/organisations/selectPlan?id=<?php echo $id?>&current=<?php echo $plan->transaction_explanation?>">
                            <i class="fa fa-plus-circle"></i>
                            <span><?php _e('Yükselt/Yenile') ?></span>
                        </a>
                    <?php }else{ ?>
                        <?php _e('Geçerli planınız bulunmamaktadır'); ?><br><br>
                        <a class="btn btn-primary" id='addNewBookBtn' href="/organisations/selectPlan?id=/<?php echo $id?>">
                            <i class="fa fa-plus-circle"></i>
                            <span><?php _e('Ekle') ?></span>
                        </a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>