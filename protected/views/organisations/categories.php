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
<?php 
$modalCategories=$categories;

foreach ($modalCategories as $key => $modal) {?>
<div class="modal fade" id="editCategory<?php echo $modal->category_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title"><?php _e('Yayın kategorisi düzenle'); ?></h4>
			</div>
			<div class="modal-body">
				<form action="/organisations/updateBookCategory" method="post">
					<div class="form-group">
						<label for="category" class="control-label col-md-2"><?php _e("İsim"); ?><span class="required">*</span></label>
						<div class="col-md-6">
							<input class="form-control" name="categoryName" id="categoryName" type="text" placeholder="<?php echo $modal->category_name; ?>">
							<input class="form-control" name="categoryId" id="categoryId" type="text" value="<?php echo $modal->category_id; ?>" style="display:none">
							<input class="form-control" name="organisation" id="organisation" type="text" value="<?php echo $organisationId; ?>" style="display:none">
						</div>
					</div>
					<div class="form-group">
						<button type="submit"><?php _e("Kaydet"); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	
<!-- end foreach -->
<?php }
?>
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title"><?php _e('Yayın kategorisi ekle'); ?></h4>
			</div>
			<div class="modal-body">
				<form action="/organisations/createBookCategory" method="post">
					<div class="form-group">
						<label for="category" class="control-label col-md-2"><?php _e("İsim"); ?><span class="required">*</span></label>
						<div class="col-md-6">
							<input class="form-control" name="category" id="category" type="text">
							<input class="form-control" name="organisation" id="organisation" type="text" value="<?php echo $organisationId; ?>" style="display:none">
						</div>
					</div>
					<br><br>
					<div class="form-group">
						<label for="category" class="control-label col-md-2"><?php _e("süreli"); ?></label>
						<div class="col-md-6">
							<input class="uniform" id="periodical" type="checkbox" name="periodical">
						</div>
					</div>
					<div class="form-group">
						<button type="submit"><?php _e("Kaydet"); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

 <div id="content" class="col-lg-12">
	<!-- PAGE HEADER-->
	<div class="row">
		<div class="col-sm-12">
			<div class="page-header">
				<h3 class="content-title pull-left"><?php _e('Yayın Kategorileri') ?></h3>
			</div>
		</div>
	</div>
	<!-- /PAGE HEADER -->
	<div class="row">
	<?php 
		if ($categories) {
			foreach ($categories as $key => $category) { ?>
				<li>
					<span style="line-height:2;"><?php echo $category->category_name;?></span><br>
					<a href="/organisations/deleteCategory?category_id=<?php echo $category->category_id; ?>&organisationId=<?php echo $organisationId; ?>" class="float-right"><i class="fa-times"> </i><?php _e('Sil'); ?></a>
					<a href="#editCategory<?php echo $category->category_id?>" data-toggle="modal" class="config"><i class="fa-edit"> </i><?php _e('Düzenle'); ?></a>
					<hr>
				</li>
			<!-- end foreach -->
			<?php }
		}
		else
		{
		?>
		<p><?php _e('Henüz kayıtlı bir süreli yayın kategoriniz bulunmamaktadır.'); ?></p>
		<!-- end else -->
		<?php } ?>
	</div>
	<div class="row">
		<a href="#addCategory" data-toggle="modal" class="config"><?php _e('Ekle'); ?></a>
	</div>
</div>