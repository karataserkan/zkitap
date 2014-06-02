<script>
	jQuery(document).ready(function() {		
		App.setPage("gallery");  //Set current page
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- PAGE -->
<div id="content" class="col-lg-12">
<!-- PAGE HEADER-->
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h3 class="content-title pull-left"><?php _e("Eposta Doğrulama"); ?></h3>
		</div>
	</div>
</div>
<div class="row">
    <div class="alert alert-<?php echo ($result=='0')? 'success':'danger'; ?>">
        <h4>
        <?php 
        if ($result=='0') {
                _e("E-posta adresiniz başarılı bir şekilde doğrulandı.");
        }else{
                _e("E-posta adresiniz doğrulanırken bir hata oluştu. Lütfen tekrar deneyiniz!");
        }
        ?>
        </h4>
    </div>
    <a class="btn btn-primary" href="/site/login"><?php _e("Giriş Yap"); ?></a>
</div>
</div>
