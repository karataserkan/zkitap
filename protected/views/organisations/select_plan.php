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
				<h3 class="content-title pull-left"><?php _e('Plan Seç') ?></h3>
                
			</div>
		</div>
	</div>
	<!-- /PAGE HEADER -->
	<div class="row">
 		<div class="box-body" style="margin-left:-20px;">
										<ul class="pricing_table row">
											
											<li class="price_block col-md-3 select_plan">
												<h3 class="trial_plan"><?php _e('Başlangıç Paketi') ?></h3>
												<div class="price trial_price">
													<div class="price_figure">
														<span class="price_number"><?php _e('Ücretsiz') ?></span>
													</div>
												</div>
												<ul class="features">
													<li><?php _e('%s Alan','20MB') ?></li>
													<li><?php _e('%s Kitap Oluşturma','50') ?></li>
													<li><?php _e('%s Çalışma Alanı',__("Sınırsız")) ?></li>
													<li><?php _e('%s Araç','16') ?></li>
													<li><?php _e('Web Destek') ?></li>
													
												</ul>
												<div class="footer">
													<a  <?php echo ($current==3 || $current==4 || $current==2)? 'disabled':''; ?> href="/organisations/addBalance?plan=1&organisation=<?php echo $organisation ?>" class="btn btn-info"><?php _e('Satın Al') ?></a>
												</div>
											</li>


											



											<li class="price_block col-md-3 select_plan">
												<h3 class="individual_plan"><?php _e('Temel Paket') ?></h3>
												<div class="price individual_price">
													<div class="price_figure">
														<span class="price_number"><?php _e('%s$','49.99') ?></span>
														<span class="price_tenure"><?php _e('Aylık') ?></span>
													</div>
												</div>
												<ul class="features">
													<li><?php _e('%s Alan','1GB') ?></li>
													<li class="alert-success"><?php _e('%s Epub3 Aktarma',__("Sınırsız")) ?></li>
													<li><?php _e('%s Kitap Oluşturma','50') ?></li>
													<li><?php _e('%s Çalışma Alanı',__("Sınırsız")) ?></li>
													<li><?php _e('%s Araç','16') ?></li>
													<li><?php _e('Web Destek') ?></li>
													<li class="alert-success"><?php _e('Mail Destek') ?></li>
													
												</ul>
												<div class="footer">
													<a <?php echo ($current==3 || $current==4)? 'disabled':''; ?> href="/organisations/addBalance?plan=2&organisation=<?php echo $organisation ?>" class="btn btn-info"><?php _e('Satın Al') ?></a>
												</div>
											</li>


											<li class="price_block col-md-3 select_plan">
												<h3 class="business_plan"><?php _e('Ayrıcalıklı Paket') ?></h3>
												<div class="price business_price">
													<div class="price_figure">
														<span class="price_number"><?php _e('%s$','199.99') ?></span>
														<span class="price_tenure"><?php _e('Aylık') ?></span>
													</div>
												</div>
												<ul class="features">
													<li><?php _e('%s Alan','1GB') ?></li>
													<li class="alert-success"><?php _e('Apple Store, Google Play, Amazon, iBooks Store Marketlerinde Yayınlama') ?></li>
													<li><?php _e('%s Epub3 Aktarma',__("Sınırsız")) ?></li>
													<li><?php _e('%s Kitap Oluşturma','50') ?></li>
													<li><?php _e('%s Çalışma Alanı',__("Sınırsız")) ?></li>
													<li><?php _e('%s Araç','16') ?></li>
													<li><?php _e('Web Destek') ?></li>
													<li><?php _e('Mail Destek') ?></li>
													<li><?php _e('Telefonla Destek') ?></li>
													
												</ul>
												<div class="footer">
													<a <?php echo ($current==4)? 'disabled':''; ?> href="/organisations/addBalance?plan=3&organisation=<?php echo $organisation ?>" class="btn btn-info"><?php _e('Satın Al') ?></a>
												</div>
											</li>


											<li class="price_block col-md-3 select_plan">
												<h3 class="corporate_plan"><?php _e('Kurumsal Paket') ?></h3>
												<div class="price corporate_price">
													<div class="price_figure">
														<span class="price_number"><?php _e('%s$','299.99') ?></span>
														<span class="price_tenure"><?php _e('Aylık') ?></span>
													</div>
												</div>
												<ul class="features">
													<li class="alert-success"><?php _e('%s Alan','2GB') ?></li>
													<li class="alert-success"><?php _e('Size Özel Tasarlanmış Kütüphaneniz') ?></li>
													<li><?php _e('Apple Store, Google Play, Amazon, iBooks Store Marketlerinde Yayınlama') ?></li>
													<li><?php _e('%s Epub3 Aktarma',__("Sınırsız")) ?></li>
													<li><?php _e('%s Kitap Oluşturma','50') ?></li>
													<li><?php _e('%s Çalışma Alanı',__("Sınırsız")) ?></li>
													<li><?php _e('%s Araç','16') ?></li>
													<li><?php _e('Web Destek') ?></li>
													<li><?php _e('Mail Destek') ?></li>
													<li><?php _e('Telefonla Destek') ?></li>
													<li class="alert-success"><?php _e('8 Saat Eğitim ve Danışmanlık Hizmeti') ?></li>
													
												</ul>
												<div class="footer">
													<a href="/organisations/addBalance?plan=4&organisation=<?php echo $organisation ?>" class="btn btn-info"><?php _e('Satın Al') ?></a>
												</div>
											</li>
										</ul>
									</div>
	</div>
</div>