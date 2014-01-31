
<?php

$this->pageTitle=Yii::app()->name." - ". __("Kontrol Paneli");
?>



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
			<h3 class="content-title pull-left">Kontrol Paneli</h3>
		</div>
	</div>
</div>
<!-- /PAGE HEADER -->
<div class="row">
<div class="col-md-8">
	<div class="box border blue">
		<div class="box-title">
			<h4><i class="fa fa-dot-circle-o"></i>Linden Editör</h4>
			<div class="tools">
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="box-body big">
			<div class="jumbotron">
			  <h1>Linden</h1>
			  <p>Linden Editör.</p>
			  <p><a class="btn btn-primary btn-lg" role="button">Devamı</a></p>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-4">
 <div class="dashbox panel panel-default">
	<div class="panel-body">
	   <div class="panel-left red">
			<i class="fa fa-book fa-3x"></i>
	   </div>
	   <div class="panel-right">
			<div class="number">15</div>
			<div class="title">Kitap</div>
	   </div>
	</div>
 </div>
</div>
<div class="col-lg-4">
 <div class="dashbox panel panel-default">
	<div class="panel-body">
	   <div class="panel-left red">
			<i class="fa fa-desktop fa-3x"></i>
	   </div>
	   <div class="panel-right">
			<div class="number">1</div>
			<div class="title">Sunucu</div>
	   </div>
	</div>
 </div>
</div>
<div class="col-lg-4">
 <div class="dashbox panel panel-default">
	<div class="panel-body">
	   <div class="panel-left red">
			<i class="fa fa-suitcase fa-3x"></i>
	   </div>
	   <div class="panel-right">
			<div class="number">3</div>
			<div class="title">Çalışma Alanı</div>
	   </div>
	</div>
 </div>
</div>
<div class="col-lg-4">
 <div class="dashbox panel panel-default">
	<div class="panel-body">
	   <div class="panel-left red">
			<i class="fa fa-turkish-lira fa-3x"></i>
	   </div>
	   <div class="panel-right">
			<div class="number">1000 TL</div>
			<div class="title">Hesapta</div>
	   </div>
	</div>
 </div>
</div>
</div>
<div class="separator"></div>
<div class="row">
<?php
if (!empty($books)&&$books) {
foreach ($books as $key2 => $book) { $userType = $this->userType($book['book_id']); ?>
<div class="col-md-3">
	<!-- BOX -->
	<div class="box" style="opacity: 1; z-index: 0;">
		<div class="box-title">
			<h4><i class="fa fa-book"></i><?php echo $book['title'] ?></h4>
			<div class="tools">
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
			</div>
		</div>
		<div class="box-body bg" style="display: block;">
			<!-- beyaz içerik yeri -->
			<div class="row">
				<div class="col-md-4 ">
					<img src="/css/images/default-cover.jpg" alt="Book Cover">
				</div>
				<div class="col-md-8 form-vertical">
					<div class="form-group">											
						<input class="form-control" type="text" name="placeholder" readonly="" placeholder="<?php echo $book['title'] ?>" >
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="placeholder" readonly="" placeholder="<?php echo $book['author'] ?>">
					</div>
					<p class="btn-toolbar text-right">
						<a href="<?php echo '/book/author/'.$book['book_id'] ?>" class="btn btn-info"><?php echo __('Düzenle');?></a>
						<a href="<?php echo '/EditorActions/ExportBook/'.$book['book_id']; ?>" class="btn btn-success"><?php echo __('İndir');?></a>
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- /BOX -->
</div>
<?php } }?>
</div>
<!--/PAGE -->



    