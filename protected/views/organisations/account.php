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
                <div class="action_bar_spacer"></div> 
                <h4 class="pull-left org_name_top" href="#"><i class="fa fa-briefcase"></i> <?php echo $organisation->organisation_name ?></h4>
                
                <a class="btn pull-right brand_color_for_buttons org_name_edit" data-toggle="modal" data-id="organisationTitleModal" data-target="#organisationTitleModal">
					<i class="fa fa-edit"></i>
					<span>Organizasyon İsmini Değiştir</span>
				</a>
                
            </div>
		</div>
	</div>
	<!-- /PAGE HEADER -->
 
        <div class="account_info_cards_container">
        	<div class="account_info_plan_cards_container">                
                <div class="account_info_plan_cards">
                    <div class="account_info_plan_title business_plan">Geçerli Planınız</div>
                    <div class="account_info_plan">Kurumsal Paket</div>
                </div>
                
                <div class="account_info_plan_cards">
                    <div class="account_info_plan_title business_plan">Bitiş<br>Tarihi</div>
                    <div class="account_info_plan_last_date">13-07-2014</div>
                </div>
                
                <div class="account_info_plan_cards">
                    <div class="account_info_plan_title business_plan">Kalan<br>Gün</div>
                    <div class="account_info_plan_day_left">32</div>
                </div>
           </div>     
            <!-- end of account_info_plan_cards_container -->
            
            <div class="account_spacer"></div>
            
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
            
           
        </div>
        <!-- end of account_info_cards_container -->

    <div class="row"><br><br><br /><br><br><br /><br><br><br /><br><br><br /><br><br><br /></div>
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

<!-- Modal -->
<div class="modal fade" id="organisationTitleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php _e("Organizasyon"); ?></h4>
      </div>
      <div class="modal-body">
        <?php _e("Organizasyon İsmi: "); ?>
      <input type="text" name="organisationTitle" id="organisationTitle" value="<?php echo $organisation->organisation_name; ?>">
      <br>
      <div class="alert alert-danger" id="organisationTitleFeedback" style="display:none">
          
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="changeTitle"><?php _e("Kaydet") ?></a>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç") ?></button>      
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $("#changeTitle").click(function(){
        var title=$("#organisationTitle").val();
        var organisation="<?php echo $organisation->organisation_id; ?>";
        $.ajax({
              type: "POST",
              data: {title: title, organisation:organisation},
              url: '/organisations/changeTitle',
            }).done(function(res){
                console.log(res);
                if (res=="0") {
                    window.location.reload();
                }
                else{
                    $("#organisationTitleFeedback").show();
                    $("#organisationTitleFeedback").text("Beklenmeyen bir hata oluştu. Lütfen tekrar deneyiniz.");
                };
            });
    });
</script>
