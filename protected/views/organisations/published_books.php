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


<!-- POPUP EDITORS -->
<div class="modal fade" id="remove_bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Yayından Kaldır"); ?></h4>
		</div>
		<div class="modal-body">
		 	Eseri yayından kaldırmak istiyor musunuz? Onay verdiğinizde eser yayınlanmış kategorisinden kaldırılıp düzenlenme aşamasına gönderilecek. Ayrıca eserler okuyuculardan da kaldırılacak.
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary" id="remove_book"><?php _e("Kaldır"); ?></a>
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
<div class="clearfix"></div>
<div id="filter-items" class="mybooks_page_book_filter row">
<?php
$userid=Yii::app()->user->id;
		foreach ($books as $key2 => $book) { 
			$userType = $this->userType($book->book_id);
			?>
			<div class="reader_book_card">
	         <div class="reader_book_card_book_cover">
	         
	      <?php 
				$thumbnailSrc="/css/images/default-cover.jpg";
				$bookData=json_decode($book->data,true);
				 if (isset($bookData['thumbnail'])) {
				 	$thumbnailSrc=$bookData['thumbnail'];
				 }

			?>
	         					
	             <div class="editor_mybooks_book_settings">
	                 <i class="fa fa-trash-o tip removeBookModal" data-original-title="Yayından Kaldır" data-id="remove_bookModal" data-toggle="modal" data-target="#remove_bookModal" book-id="<?php echo $book->book_id; ?>"></i>
	                 <i class="fa fa-copy tip copyThisBook" data-original-title="Çoğalt" data-id="copyBook" data-toggle="modal" data-target="#copyBook" book-id="<?php echo $book->book_id; ?>"></i>
	             </div>
	             <img src="<?php echo $thumbnailSrc; ?>" />
	         </div>					
	         <div class="reader_book_card_info_container">
	             <div class="editor_mybooks_book_type tip" style="border:0" data-original-title="<?php _e('Kitap Erişim İzini') ?>"><?php if ($userType=='owner') {_e('Sahibi');} ?><?php if ($userType=='editor') { _e('Editör'); } ?><?php if ($userType!='owner' && $userType!='editor') { _e('Diğer'); } ?></div>						
	             <div class="clearfix"></div>			
	             <div class="reader_market_book_name tip" data-original-title="Eser İsmi"><?php echo $book->title ?></div>						
	             <div class="clearfix"></div>						
	             <div class="reader_book_card_writer_name tip" data-original-title="<?php _e('Yazarın adı') ?>"><?php echo $book->author ?></div>											
	         </div>				
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

var bookId2="";
$(document).on("click",".removeBookModal",function(e){
	bookId2 = $(this).attr('book-id');
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

$("#remove_book").click(function(){
	var link ="/organisations/removeFromCategory?id="+bookId2;
    window.location.assign(link);
});

</script>
<script type="text/javascript">
	$().ready(function(){
		if( $('.reader_book_card').length==0 ) {
			tripStart();
		}
	});
</script>