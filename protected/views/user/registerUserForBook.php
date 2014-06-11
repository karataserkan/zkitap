
<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
										<h3 class="content-title pull-left"><?php _e('Davet') ?></h3>
								</div>
							</div>
						</div>
<div class="row">
<h3>
<?php 
	_e("Eser çalışma isteğini kabul ediyor musunuz? Üye Olun.");
?>
</h3>
</div>

<div class="row col-md-5 login-box">
	<div style="display:none" id="signUpSent" class="alert alert-info"><h3>Lütfen Bekleyiniz...</h3></div>
	<form id="user-form" action="/user/registerUser" class="form-horizontal" method="POST">
	  <div class="form-group">
		<label for="exampleInputName"><?php _e("Adınız"); ?></label>
		<i class="fa fa-font"></i>
		<input size="60" maxlength="255" name="User[name]" type="text">
	  </div>
	
	  <div class="form-group">
		<label for="exampleInputUsername"><?php _e("Soyadınız"); ?></label>
		<i class="fa fa-user"></i>
		<input size="60" maxlength="255" name="User[surname]" type="text">
	  </div>
	
	  <div class="form-group">
		<label for="exampleInputEmail1"><?php _e("E-Posta"); ?></label>
		<i class="fa fa-envelope"></i>
		<input size="60" maxlength="255" name="User[email]" type="text">
	  </div>
	
	  <div class="form-group"> 
		<label for="exampleInputPassword1"><?php _e("Şifre"); ?></label>
		<i class="fa fa-lock"></i>
		<input size="60" maxlength="255" name="User[password]" type="password">
	  </div>
	
	  <div class="form-group"> 
		<label for="exampleInputPassword2"><?php _e("Şifreyi Tekrarla"); ?></label>
		<i class="fa fa-check-square-o"></i>
		<input size="60" maxlength="255" name="User[passwordR]" type="password">
		<input size="60" maxlength="255" value="<?php echo $key; ?>" name="User[key]" type="hidden">
	  </div>
	  <div>
	  	<br>
		<!-- <label class="checkbox"> <input type="checkbox" class="uniform" value=""> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label> -->
		<button type="submit" class="btn btn-success" id="addUser"><?php _e("Kaydet");?></button>
	  </div>
	</form>
</div>




<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>