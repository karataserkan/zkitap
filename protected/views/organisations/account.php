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


        <div class="myprofile_information_container">
        
        <div class="myprofile_picture_container">
        <div class="change_profile_picture"><a href="#"><i class="fa fa-edit"></i></a></div>
        <img src="/css/images/avatar.png">
        </div>
        
        
        
        <div class="myprofile_information_part">
        
        <div class="myprofile_information_components">
        <p>HESABIN</p>
        <button class="btn btn-success">Değişiklikleri Kaydet</button>
        </div>
        
        <div class="myprofile_information_components">
        <p>İsim</p>
        <div class="myprofile_info_edit"><i class="fa fa-edit"></i> <form id="myprofile_info_edit"><input placeholder="Erkan Öğümsöğütlü" /></form></div>
        </div>
        
        <div class="myprofile_information_components">
        <p>Kullanıcı Adı</p>
        <div class="myprofile_info_edit"><i class="fa fa-edit"></i> <form id="myprofile_info_edit"><input placeholder="erkanogumsogutlu" /></form></div>
        </div>
        
        <div class="myprofile_information_components">
        <p>E-Mail Adres</p>
        <div class="myprofile_info_edit"><i class="fa fa-edit"></i> <form id="myprofile_info_edit"><input placeholder="erkan@linden-tech.com" /></form></div>
        </div>
        
        
        <div class="myprofile_information_components">
        
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3 class="panel-title"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Şifreni Değiştir</a> </h3>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body"> 
                        <div><p>Eski Şifre:</p> <input name="LoginForm[password]" id="LoginForm_password" type="password"></div><br />
                        <div><p>Yeni Şifre:</p> <input name="LoginForm[password]" id="LoginForm_password" type="password"></div><br />
                        <div> <p>Yine Şifre Tekrarı:</p> <input name="LoginForm[password]" id="LoginForm_password" type="password"></div>
                  </div>
                </div>
            </div>
        </div>
        
        </div>
        </div>
        <!-- end of myprofile_information_part -->


	</div>
</div>