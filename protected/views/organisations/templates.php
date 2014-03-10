<script type="text/javascript">
	$(document).ready(function() {
var data_id = '';
  $('.remove_book').click(function () {

    

    if (typeof $(this).data('id') !== 'undefined') {

      data_id = $(this).data('id');
    }

    $('#book_id').val(data_id);
  });
  $("#delete_book").click(function(){
  	href="<?php echo '/book/delete/'.$book->book_id ?>"
  	$.ajax({
	  url: "/book/delete/"+data_id,
	}).done(function() {
	  $('#myModal').modal('hide');
	});
  });
});
</script>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->

<!-- POPUP EDITORS -->
<div class="modal fade" id="updateBookTitle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Eseri Güncelle"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="copy" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="contentTitle">Eser Adı<span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="contentTitle" placeholder="Lütfen bir isim girin!" id="updateContentTitle" type="text">															
					</div>
				</div>	
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="update_book_title"><?php _e("Güncelle"); ?></a>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç"); ?></button>
	      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->

<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
										<h3 class="content-title pull-left"><?php _e('Templates') ?></h3>
										<a class="btn pull-right btn-primary" href="/book/createTemplate/<?php echo $workspace_id;?>">
							<i class="fa fa-plus-circle"></i>
							<span>Template Ekle</span>
						</a>
									
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- FAQ -->
<?php
$userid=Yii::app()->user->id;

		foreach ($templates as $key2 => $book) { ?>
				
			<div class="col-md-3 item">
				<!-- BOX -->
				<div class="box" style="opacity: 1; z-index: 0;">
					<div class="box-title">
						<h4><i class="fa fa-book"></i><?php echo $book->title ?></h4>
						<div class="tools">
							<?php $remove_book_id = ''; ?>
							<a class="remove_book" data-id="<?php echo $book->book_id; ?>" data-toggle="modal" data-target="#myModal">
								<i class="fa fa-times"></i>
							</a>
							<a class="updateThisBookTitle" data-id="updateBookTitle" data-toggle="modal" data-target="#updateBookTitle" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-edit"></i></a>
							<a href="javascript:;" class="collapse">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="box-body bg" style="display: block;">
						<!-- beyaz içerik yeri -->
						<div class="row">
								
								<div class="col-md-4 ">
									<?php 
										$thumbnailSrc="/css/images/default-cover.jpg";
										$bookData=json_decode($book->data,true);
										 if (isset($bookData['thumbnail'])) {
										 	$thumbnailSrc=$bookData['thumbnail'];
										 }

									?>
									<img src="<?php echo $thumbnailSrc; ?>" alt="Book Cover" style="width:110px; height:170px">
								</div>
								
								<div class="col-md-8 form-vertical">
								<div class="form-group">											
								<input class="form-control" type="text" name="placeholder" readonly="" placeholder="<?php echo $book->title ?>" >
								</div>
								<div class="form-group">
								<input class="form-control" type="text" name="placeholder" readonly="" placeholder="<?php echo $book->author ?>">
								</div>
								<p class="btn-toolbar text-right">
								<a href="<?php echo '/book/author/'.$book->book_id ?>" class="btn btn-info"><?php echo __('Düzenle');?></a>
								<a href="<?php echo '/EditorActions/ExportBook/'.$book->book_id; ?>" class="btn btn-success"><?php echo __('İndir');?></a>
							</p>
								</div>
								</div>
					</div>
				</div>
				<!-- /BOX -->
			</div>
				
<?php } ?>
			</div>	
				
				<!-- /Page Content -->
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        Silmek istediğinizden emin misiniz?
      </div>
      <input type="hidden" name="book_id" id="book_id" value="">
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" id="delete_book">Evet</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Hayır</button>      
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
var bookId="";

$(document).on("click",".updateThisBookTitle",function(e){
	bookId = $(this).attr('book-id');
});

var workspaceId="";
$(document).on("click",".SelectWorkspace",function(e){
	$(".SelectWorkspace span").removeClass("checked");
	$(this).children("span").addClass("checked");
	workspaceId=$(this).children("span").children("input").val();
});


$("#update_book_title").click(function(){
	var title=$("#updateContentTitle").val();
	var link ="/book/updateBookTitle?bookId="+bookId+'&title='+title;
    window.location.assign(link);
});
</script>