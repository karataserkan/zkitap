<!--
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
-->



<div class="login_page_container">    


<div class="login_linden_information">
<a href="http://www.linden-tech.com/" target="_blank">
<div class="login_page_ribbon">
<div class="ribbon_rectangle"></div>
<div class="ribbon_arrow_down"></div>
</div>
<div class="login_linden_information_text">Seviye Dijital <font style="color:#FFC">Linden Dijital Yayıncılık A.Ş.</font> Tarafından Hazırlanmıştır. <br /> Bizi daha yakından tanımak için logomuza tıklayın.</div>
</a>
</div>
<!--- END OF login_linden_information -->



<video autoplay loop poster="../../../css/brands/linden/login_back.png" id="bgvid">
<source src="../css/brands/linden/back.webm" type="video/webm">
<source src="../css/brands/linden/back.mp4" type="video/mp4">
</video>

   <div class="login_overlay"></div>     

<div class="col-lg-12">
<div class="row">
<div class="col-md-1"></div>


<div class="col-md-7" style="height:725px;">
        <div class="login_page_reader_logo"></div>
        <div class="login_page_slogan"></div>
</div>


<div class="col-md-3">

						<section id="login_bg" class="visible" style="margin-top:100px;">
							<div class="login-box">
								
							<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'login-form',
								'enableClientValidation'=>true,
								'clientOptions'=>array(
									'validateOnSubmit'=>true,
								),
							)); ?>

									<form role="form">
									  <div class="form-group">
									  	<?php if ($loginError) {
								    		echo '<h4 class="alert alert-danger">'.$loginError.'</h4>';
								    	}?>
										<label for="exampleInputEmail1"><?php _e("E-Posta"); ?></label>
										<i class="fa fa-envelope"></i>
										<?php echo $form->textField($model,'email'); ?>										
									  </div>
									  
									  <div class="form-group"> 
										<label for="exampleInputPassword1"><?php _e("Şifre"); ?></label>
										<i class="fa fa-lock"></i>
										<?php echo $form->passwordField($model,'password'); ?>										
									  </div>
									  
									  <!-- <div class="form-group">
									  <label for="ytLoginForm_rememberMe"><input id="ytLoginForm_rememberMe" type="checkbox"  class="uniform"  value="0" name="LoginForm[rememberMe]"><?php _e("Beni Hatırla"); ?></label>
									  </div> -->

									  <div class="form-group">
										<button type="submit" class="btn btn-danger"><?php _e("Giriş"); ?></button>										
									  </div>
									</form>
                                    
                                    
                                    
                                    
                                    
                                    
									<div class="login-helpers">
										<a href="#" onclick="swapScreen('forgot_bg');return false;"><?php _e("Şifremi Unuttum"); ?></a> <br>
										<?php _e("Hala bizde hesabınız yok mu?"); ?> <a href="#" onclick="swapScreen('register_bg');return false;"><?php _e("Hemen kaydolun!"); ?></a>
									</div>
								<?php $this->endWidget(); ?>

							</div>						
						</section>
			<!--/LOGIN -->
            
            
            
			<!-- REGISTER -->
			<section id="register_bg" class="font-400" style="margin-top:100px;">
				<div class="container">
					<div class="row">
						<div class="">
							<div class="login-box">
								
								<?php $form=$this->beginWidget('CActiveForm', array(
									'id'=>'user-form',
									'enableAjaxValidation'=>false,
								)); ?>

								  <div class="form-group">
									<label for="exampleInputName"><?php _e("Adınız"); ?></label>
									<i class="fa fa-font"></i>
									<?php echo $form->textField($newUser,'name',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputUsername"><?php _e("Soyadınız"); ?></label>
									<i class="fa fa-user"></i>
									<?php echo $form->textField($newUser,'surname',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputEmail1"><?php _e("E-Posta"); ?></label>
									<i class="fa fa-envelope"></i>
									<?php echo $form->textField($newUser,'email',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group"> 
									<label for="exampleInputPassword1"><?php _e("Şifre"); ?></label>
									<i class="fa fa-lock"></i>
									<?php echo $form->passwordField($newUser,'password',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group"> 
									<label for="exampleInputPassword2"><?php _e("Şifreyi Tekrarla"); ?></label>
									<i class="fa fa-check-square-o"></i>
									<input size="60" maxlength="255" name="User[passwordR]" id="User_password_r" type="password">
								  </div>
								


								    

								  <div>
								  	<br>
									<!-- <label class="checkbox"> <input type="checkbox" class="uniform" value=""> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label> -->
									<button type="submit" class="btn btn-success" id="addUser"><?php _e("Kaydet");?></button>
								  </div>

								<?php $this->endWidget(); ?>
							
								

								<!-- SOCIAL REGISTER 
								<div class="divide-20"></div>
								<div class="center">
									<strong>Or register using your social account</strong>
								</div>
								<div class="divide-20"></div>
								<div class="social-login center">
									<a class="btn btn-primary btn-lg">
										<i class="fa fa-facebook"></i>
									</a>
									<a class="btn btn-info btn-lg">
										<i class="fa fa-twitter"></i>
									</a>
									<a class="btn btn-danger btn-lg">
										<i class="fa fa-google-plus"></i>
									</a>
								</div>
								/SOCIAL REGISTER -->
                                 
                                 
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('login_bg');return false;"> <?php _e("Giriş ekranına dön"); ?></a> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/REGISTER -->
            
            
			<!-- FORGOT PASSWORD -->
			<section id="forgot_bg" style="margin-top:100px;">
				<div class="container">
					<div class="row">
						<div class="">
							<div class="login-box">
								<?php if ($passResetSuccess) { ?>
									<div class="alert alert-success">
										<span><?php echo $passResetSuccess; ?></span>
									</div>
								<?php }else{
								?>
									<form role="form">
									  <div class="form-group">
										<label for="exampleInputEmail1" <?php echo ($passResetError)?'style="color:red"':''; ?>><?php _e("E-Posta adresinizi giriniz"); ?> <?php echo $passResetError; ?></label>
										<i class="fa fa-envelope"></i>
										<input name="Reset[email]" id="Reset_email" type="text" <?php echo ($passResetError)?'style="color:red"':''; ?>>
									  </div>
									  <div>
										<button type="submit" class="btn btn-info"><?php _e("Şifremi Yenile"); ?></button>
									  </div>
									</form>
								<?php } ?>
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('login_bg');return false;"><?php _e("Giriş ekranına dön"); ?></a> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- FORGOT PASSWORD -->
	
</div>
<!-- END OF COL-MD-3 -->


<div class="col-md-1"></div>

</div>
<!-- END OF ROW -->
</div>
<!-- END OF COL-LG-12 -->
</div>
<!-- END OF LOGIN_PAGE_CONTAINER -->



	<script>
		jQuery(document).ready(function() {		
			App.setPage("login_bg");  //Set current page
			App.init(); //Initialise plugins and elements

			var url=window.location.href;
			var isRequestUrl = url.search('#');
			if (isRequestUrl) {
				var splUrl=url.split('#');
				console.log(splUrl[1]);
				var page=splUrl[1];
				if (page=='signup') {
					swapScreen('register_bg');
				}else if(page=='forget')
				{
					swapScreen('forgot_bg');
				};
			};
			var pass;
			$('#User_password').keydown(function(){
				pass=$('#User_password').val();
				var len=pass.length;
				if (len<7) {
					$('#addUser').attr('disabled','disabled')
					$("[for='exampleInputPassword1']").text("Şifre/Minimum 8 karakter olmalıdır");
					$("[for='exampleInputPassword1']").addClass('text-danger').removeClass('text-success');
				}else{
					$('#addUser').removeAttr('disabled');
					$("[for='exampleInputPassword1']").text("Şifre");
					$("[for='exampleInputPassword1']").removeClass('text-danger').addClass('text-success');
				};
			});

			$('#User_password_r').keydown(function(){
				var sifreTekrar=$('#User_password_r').val();
				var len=sifreTekrar.length;
				
				if (sifreTekrar==pass) {
						$('#addUser').removeAttr('disabled');
						$("[for='exampleInputPassword2']").text("Şifreyi Tekrarla");
						$("[for='exampleInputPassword2']").removeClass('text-danger').addClass('text-success');
					}else{
						$('#addUser').attr('disabled','disabled');
						$("[for='exampleInputPassword2']").text("Şifreyi Tekrarla/Şifreler uyuşmuyor");
						$("[for='exampleInputPassword2']").addClass('text-danger').removeClass('text-success');
					};
			});
			var passResetSuccess="<?php echo $passResetSuccess ?>";
			if (passResetSuccess) {
				swapScreen('forgot_bg');
			};
		});
	</script>
	<script type="text/javascript">
		function swapScreen(id) {
			jQuery('.visible').removeClass('visible animated fadeInUp');
			jQuery('#'+id).addClass('visible animated fadeInUp');
		}
	</script>
	<!-- /JAVASCRIPTS -->
<script>
		// var preview = $("#upload-preview");

		// $(".file").change(function(event){
		//    var input = $(event.currentTarget);
		//    var file = input[0].files[0];
		//    var reader = new FileReader();
		//    reader.onload = function(e){
		//        image_base64 = e.target.result;
		//        document.getElementById('User_data').value = image_base64;
		//        preview.html("<img src='"+image_base64+"'/><br/>");
		//    };
		//    reader.readAsDataURL(file);
		//   });
		

  //       var video;
  //       var dataURL;

  //       //http://coderthoughts.blogspot.co.uk/2013/03/html5-video-fun.html - thanks :)
  //       function setup() {
  //           navigator.myGetMedia = (navigator.getUserMedia ||
  //           navigator.webkitGetUserMedia ||
  //           navigator.mozGetUserMedia ||
  //           navigator.msGetUserMedia);
  //           navigator.myGetMedia({ video: true }, connect, error);
  //       }

  //       function connect(stream) {
  //           video = document.getElementById("video");
  //           video.src = window.URL ? window.URL.createObjectURL(stream) : stream;
  //           video.play();
  //       }

  //       function error(e) { console.log(e); }

  //       addEventListener("load", setup);

  //       function captureImage() {
  //           var canvas = document.createElement('canvas');
  //           canvas.id = 'hiddenCanvas';
  //           //$('#video').hide();
  //           //add canvas to the body element
  //          // document.body.appendChild(canvas);
  //           //add canvas to #canvasHolder
  //         //  document.getElementById('canvasHolder').value=canvas;
  //           var ctx = canvas.getContext('2d');
  //           canvas.width = video.videoWidth/4;
  //           canvas.height = video.videoHeight/4;
  //           ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  //           //save canvas image as data url
  //           dataURL = canvas.toDataURL();
  //           //set preview image src to dataURL
  //           document.getElementById('preview').src = dataURL;
  //           // place the image value in the text box
  //           document.getElementById('User_data').value = dataURL;
  //       }

  //       //Bind a click to a button to capture an image from the video stream
  //       var el = document.getElementById("button");
  //       el.addEventListener("click", captureImage, false);

    </script>