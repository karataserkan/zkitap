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
			
			<!-- FORGOT PASSWORD -->
			<section id="forgot_bg" class="visible">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box">
								<h2 class="bigintro"><?php _e("Şifre Sıfırla"); ?></h2>
								<div class="divide-40"></div>
								<form role="form" method="post">
								  <div class="form-group">
									<label for="Reset_password"><?php _e("Yeni Şifre"); ?></label>
									<i class="fa fa-envelope"></i>
									<input name="Reset[password]" id="Reset_password" type="password">
								  </div>
								  <div class="form-group">
									<label for="Reset_password2"><?php _e("Yeni Şifre Tekrarı"); ?></label>
									<i class="fa fa-envelope"></i>
									<input name="Reset[password2]" id="Reset_password2" type="password">
								  </div>
								  <div>
									<button type="submit" class="btn btn-info"><?php _e("Kaydet"); ?></button>
								  </div>
								</form>
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




