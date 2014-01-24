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



<!-- PAGE -->
	<section>
			<!-- HEADER -->
			<header>
				<!-- NAV-BAR -->
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div id="logo">
								<a href="index.html"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/img/logo/logo.png" height="40" alt="logo name" /></a>
							</div>
						</div>
					</div>
				</div>
				<!--/NAV-BAR -->
			</header>
			<!--/HEADER -->
			<!-- LOGIN -->
			<section id="login_bg" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box">
								
							<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'login-form',
								'enableClientValidation'=>true,
								'clientOptions'=>array(
									'validateOnSubmit'=>true,
								),
							)); ?>
	
									<h2 class="bigintro">Sign In</h2>
									<div class="divide-40"></div>
									<form role="form">

									

									
									  <div class="form-group">
										<label for="exampleInputEmail1"><?php echo $form->labelEx($model,'email'); ?></label>
										<i class="fa fa-envelope"></i>
										<?php echo $form->textField($model,'email'); ?>
										
									  </div>
									  
									  <div class="form-group"> 
										<label for="exampleInputPassword1"><?php echo $form->labelEx($model,'password'); ?></label>
										<i class="fa fa-lock"></i>
										<?php echo $form->passwordField($model,'password'); ?>
										
									  </div>
									  
									  <div class="form-group">
									  	
									  	
									  	<label for="ytLoginForm_rememberMe"><input id="ytLoginForm_rememberMe" type="checkbox"  class="uniform"  value="0" name="LoginForm[rememberMe]"><?php _e("Beni Hatırla"); ?></label>
									  </div>

									  <div class="form-group">
										<button type="submit" class="btn btn-danger"><?php _e("Giriş"); ?></button>
										
									  </div>
									
									</form>
									<!-- SOCIAL LOGIN -->
									<div class="divide-20"></div>
									<div class="center">
										<strong>Or login using your social account</strong>
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
									<!-- /SOCIAL LOGIN -->
									<div class="login-helpers">
										<a href="#" onclick="swapScreen('forgot_bg');return false;">Forgot Password?</a> <br>
										Don't have an account with us? <a href="#" onclick="swapScreen('register_bg');return false;">Register
											now!</a>
									</div>
								<?php $this->endWidget(); ?>

							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/LOGIN -->
			<!-- REGISTER -->
			<section id="register_bg" class="font-400">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box">
								<h2 class="bigintro">Register</h2>
								<div class="divide-40"></div>
								
								
								<?php $form=$this->beginWidget('CActiveForm', array(
									'id'=>'user-form',
									'enableAjaxValidation'=>false,
								)); ?>

								  <div class="form-group">
									<label for="exampleInputName"><?php echo $form->labelEx($newUser,'name'); ?></label>
									<i class="fa fa-font"></i>
									<?php echo $form->textField($newUser,'name',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputUsername"><?php echo $form->labelEx($newUser,'surname'); ?></label>
									<i class="fa fa-user"></i>
									<?php echo $form->textField($newUser,'surname',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group">
									<label for="exampleInputEmail1"><?php echo $form->labelEx($newUser,'email'); ?></label>
									<i class="fa fa-envelope"></i>
									<?php echo $form->textField($newUser,'email',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group"> 
									<label for="exampleInputPassword1"><?php echo $form->labelEx($newUser,'password'); ?></label>
									<i class="fa fa-lock"></i>
									<?php echo $form->passwordField($newUser,'password',array('size'=>60,'maxlength'=>255)); ?>
								  </div>
								
								  <div class="form-group"> 
									<label for="exampleInputPassword2"><?php _e("Şifreyi Tekrarla"); ?></label>
									<i class="fa fa-check-square-o"></i>
									<input size="60" maxlength="255" name="User[passwordR]" id="User_password_r" type="password">
								  </div>
								
									<div class="box-body">
										<div class="panel-group" id="accordion">
										  <div class="panel panel-default">
											 <div class="panel-heading">
												<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="text-info">Fotograf Yükle</span> </a> </h3>
											 </div>
											 <div id="collapseOne" class="panel-collapse collapse in">
												<div class="panel-body"> 
													<div class="upload-preview" id="upload-preview">

													</div>
													<input class="file" name="logo" type="file"/>
												</div>
											 </div>
										  </div>
										  <div class="panel panel-default">
											 <div class="panel-heading">
												<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="text-info">Fotograf Çek</span></a> </h3>
											 </div>
											 <div id="collapseTwo" class="panel-collapse collapse">
												<div class="panel-body"> 
													<video id="video" style="width:200px; height:200px"></video>
											        <a id="button" class="btn btn-success">Fotograf Çek</a>

												        <!-- target for the canvas-->
												        <div id="canvasHolder"></div>

												        <!--preview image captured from canvas-->
												        <img id="preview" src="http://www.clker.com/cliparts/A/Y/O/m/o/N/placeholder-hi.png" width="160" height="120" />

												        
												        <input id="User_data" type="text" name="User[data]" style="display:none" />
												</div>
											 </div>
										  </div>
									   </div>
									</div>

								    

								  <div>
								  	<br>
									<!-- <label class="checkbox"> <input type="checkbox" class="uniform" value=""> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label> -->
									<button type="submit" class="btn btn-success"><?php _e("Kaydet");?></button>
								  </div>

								<?php $this->endWidget(); ?>
							
								

								<!-- SOCIAL REGISTER -->
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
								<!-- /SOCIAL REGISTER -->
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('login_bg');return false;"> Back to Login</a> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/REGISTER -->
			<!-- FORGOT PASSWORD -->
			<section id="forgot_bg">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box">
								<h2 class="bigintro">Reset Password</h2>
								<div class="divide-40"></div>
								<form role="form">
								  <div class="form-group">
									<label for="exampleInputEmail1">Enter your Email address</label>
									<i class="fa fa-envelope"></i>
									<input name="Reset[email]" id="Reset_email" type="text">
								  </div>
								  <div>
									<button type="submit" class="btn btn-info">Send Me Reset Instructions</button>
								  </div>
								</form>
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('login_bg');return false;">Back to Login</a> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- FORGOT PASSWORD -->
	</section>
	<!--/PAGE -->
	
	<script>
		jQuery(document).ready(function() {		
			App.setPage("login_bg");  //Set current page
			App.init(); //Initialise plugins and elements
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
		var preview = $("#upload-preview");

		$(".file").change(function(event){
		   var input = $(event.currentTarget);
		   var file = input[0].files[0];
		   var reader = new FileReader();
		   reader.onload = function(e){
		       image_base64 = e.target.result;
		       document.getElementById('User_data').value = image_base64;
		       preview.html("<img src='"+image_base64+"'/><br/>");
		   };
		   reader.readAsDataURL(file);
		  });
		

        var video;
        var dataURL;

        //http://coderthoughts.blogspot.co.uk/2013/03/html5-video-fun.html - thanks :)
        function setup() {
            navigator.myGetMedia = (navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);
            navigator.myGetMedia({ video: true }, connect, error);
        }

        function connect(stream) {
            video = document.getElementById("video");
            video.src = window.URL ? window.URL.createObjectURL(stream) : stream;
            video.play();
        }

        function error(e) { console.log(e); }

        addEventListener("load", setup);

        function captureImage() {
            var canvas = document.createElement('canvas');
            canvas.id = 'hiddenCanvas';
            //$('#video').hide();
            //add canvas to the body element
           // document.body.appendChild(canvas);
            //add canvas to #canvasHolder
          //  document.getElementById('canvasHolder').value=canvas;
            var ctx = canvas.getContext('2d');
            canvas.width = video.videoWidth/4;
            canvas.height = video.videoHeight/4;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            //save canvas image as data url
            dataURL = canvas.toDataURL();
            //set preview image src to dataURL
            document.getElementById('preview').src = dataURL;
            // place the image value in the text box
            document.getElementById('User_data').value = dataURL;
        }

        //Bind a click to a button to capture an image from the video stream
        var el = document.getElementById("button");
        el.addEventListener("click", captureImage, false);

    </script>