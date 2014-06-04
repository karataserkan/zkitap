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
            
           
        </div>
        <!-- end of account_info_cards_container -->

	</div>
    <div class="row"><br><br></div>
    <div class="row">
        <div class="col-md-3">
            <div class="box border green">
                <div class="box-title">
                    <h4><i class="fa fa-briefcase"></i><?php echo $organisation->organisation_name ?></h4>
                </div>    
                <div class="box-body">
                    <a class="btn btn-primary" href="#"  data-toggle="modal" data-id="organisationTitleModal" data-target="#organisationTitleModal"> <i class="fa fa-edit"> </i> <?php _e('İsim Değiştir'); ?></a>
                </div>
            </div>
        <div>
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