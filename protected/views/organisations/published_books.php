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
<?php 
$workspaces=$this->getUserWorkspaces();
?>

<!-- POPUP EDITORS -->
<div class="modal fade" id="copyBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Kitabı Kopyala"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="copy" method="post" class="form-horizontal">
		 		<div class="form-group">
					<label  class="col-md-3 control-label">
					<?php _e("Çalışma Alanları"); ?>
					</label>
					<div class="col-md-9">
			 			<span id="workspaces">
						 	<?php 
						 	foreach ($workspaces as $key => $workspace) { ?>
				 				<div class="radio SelectWorkspace" id="uniform-<?php echo $workspace["workspace_id"]; ?>">
				 					<span>
				 						<input class="uniform" id="<?php echo $workspace["workspace_id"]; ?>" value="<?php echo $workspace["workspace_id"]; ?>" type="radio" name="CopyBook">
				 					</span>
				 				</div>
				 				<label for="<?php echo $workspace["workspace_id"]; ?>"><?php echo $workspace["workspace_name"]; ?></label>
				 				<br>
						 	<?php }
						 	?>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="PublishBookForm_contentTitle">Eser Adı<span class="required">*</span></label>
					<div class="col-md-4">
						<input class="form-control" name="contentTitle" placeholder="Lütfen bir isim girin!" id="newContentTitle" type="text">															
					</div>
				</div>	
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="copy_book"><?php _e("Kopyala"); ?></a>
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
										<h3 class="content-title pull-left"><?php _e('Yayınlanan Eserler') ?></h3>
									
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- FAQ -->
<?php
$userid=Yii::app()->user->id;

		foreach ($books as $key2 => $book) { ?>
				
			<div class="col-md-3 item">
				<!-- BOX -->
				<div class="box" style="opacity: 1; z-index: 0;">
					<div class="box-title">
						<h4><i class="fa fa-book"></i><?php echo $book->title ?></h4>
						<div class="tools">
							<a class="copyThisBook" data-id="copyBook" data-toggle="modal" data-target="#copyBook" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-copy"></i></a>
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
<script type="text/javascript">
var bookId="";
$(document).on("click",".copyThisBook",function(e){
	bookId = $(this).attr('book-id');
});

$(document).on("click",".updateThisBookTitle",function(e){
	bookId = $(this).attr('book-id');
});

var workspaceId="";
$(document).on("click",".SelectWorkspace",function(e){
	$(".SelectWorkspace span").removeClass("checked");
	$(this).children("span").addClass("checked");
	workspaceId=$(this).children("span").children("input").val();
});

$("#copy_book").click(function(){
	var title=$("#newContentTitle").val();
	var link ="/book/copyBook?bookId="+bookId+"&workspaceId="+workspaceId+'&title='+title;
    window.location.assign(link);
});

$("#update_book_title").click(function(){
	var title=$("#updateContentTitle").val();
	var link ="/book/updateBookTitle?bookId="+bookId+'&title='+title;
    window.location.assign(link);
});
</script>