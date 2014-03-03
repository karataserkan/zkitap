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
//burada kullanıcıya hakları vermek için seçilmiş olan user | book | type il link oluşturup yönlendiriyorum											
function sendRight(e){
    var b = e.id;
    var userId=$('#' + b + '> #user').val();
    var type=$('#' + b + '> #type').val();
    var bookId=$('#' + b + ' > #book').val();
    var link ='/site/right?userId='+userId+'&bookId='+bookId+'&type='+type;
    window.location.assign(link);
    }
</script>


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


<?php
$userid=Yii::app()->user->id;
$workspacesOfUser= $this->getUserWorkspaces();
foreach ($workspacesOfUser as $key => $workspace) {
        $workspace=(object)$workspace;
$all_books= $this->getWorkspaceBooks($workspace->workspace_id);
		foreach ($all_books as $key2 => $book) {
			$userType = $this->userType($book->book_id); ?>
					<?php if ($userType==='owner') { ?>
<!-- POPUP EDITORS -->
<div class="modal fade" id="box-config<?php echo $book->book_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title">Editörler</h4>
		</div>
		<div class="modal-body">
		 
		<?php 
			$users = $this->bookUsers($book->book_id);

			foreach ($users as $key => $user): 
				if ($user['type']=='owner' || $user['type']=='editor'){?>
				
				
					
				<div class="well well-sm">
					<div id="editor-name" class="col-md-10">
					<?php echo $user['name']." ".$user['surname']; ?>
					</div>
					<div id="editor-tag" class="col-md-1">
					<?php 
							if ($user['type']=='owner') {
								echo __('Sahibi');
							}
							elseif ($user['type']=='editor') {
								echo __('Editör');
							}
						?>
					</div>
					
					<div class="col-md-1">
						<?php 
							echo CHtml::link(CHtml::encode(''), array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id),
							  array(
								'submit'=>array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id, 'userId'=>$user['id'],'bookId'=>$book->book_id),
								//'params' => array('bookId'=>$book->book_id, 'user'=>$user['id'], 'del'=>'true'),
								'class' => 'fa fa-trash-o pull-right'
							  )
							);
							?>

					</div>
					
				<div class="clearfix"></div>	
				</div>	
		<?php } endforeach; ?>
		

		<div style="background-color:#fff; height: 60px; padding:5px; margin:10px; color:#333; text-align:left;">
			<?php
				//owner ya da editor eklemek için siteController 3 tane değerin post edilmesini bekliyor
				//user: eklenecek olan elemanın mail adresi
				//book: kitabın id'si
				//type: owner | editor | user

			?>
			<span class="editor-name" ><?php echo __('Kullanıcı Ekle');?>:</span>
			<br style="clear:both; margin-bottom:20px;">
			<form id="a<?php echo $book->book_id; ?>" method="post">
			<input id="book" value="<?php echo $book->book_id; ?>" style="display:none">
			<select id="user" class="book-list-textbox radius grey-9 float-left"  style=" width: 280px;">
				<?php
					$workspaceUsers = $this->workspaceUsers($workspace->workspace_id);
					
					foreach ($workspaceUsers as $key => $workspaceUser) {
						echo '<option value="'.$workspaceUser['userid'].'">'.$workspaceUser['name'].' '.$workspaceUser['surname'].'</option>';
					}
				 ?>
			</select>
			 <select id="type" class="book-list-textbox radius grey-9 float-left"  style=" width: 70px;" >
			  <option value="editor"><?php echo __('Editör');?></option>
			  <option value="owner"><?php echo __('Sahibi');?></option>
			</select>
			</form>
			<a href="#" onclick="sendRight(a<?php echo $book->book_id; ?>)" class="btn white radius float-right" style="margin-left:20px; width:50px; text-align:center;">
				Ekle
			</a>
		</div>

		</div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->
<?php } } } ?>

<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
										<h3 class="content-title pull-left"><?php _e('Kitaplarım') ?></h3>
										<a class="btn pull-right btn-primary" href="/book/newBook">
							<i class="fa fa-plus-circle"></i>
							<span>Kitap Ekle</span>
						</a>
									
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- FAQ -->
		<div class="row">
			<div id="filter-controls" class="btn-group">
			  <div class="hidden-xs">
				  <a href="#" class="btn btn-default" data-filter="*"><?php _e("Hepsi"); ?></a>
<?php 
$buttons=array('info','primary','success', 'warning', 'danger', 'inverse', 'primary', 'success', 'warning', 'danger', 'inverse');
$workspaces= $this->getUserWorkspaces();
foreach ($workspaces as $key => $workspace) { ?>
		<a href="#" class="btn btn-<?php echo $buttons[$key]; ?>" data-filter=".<?php echo $workspace['workspace_id']; ?>"><?php echo $workspace['workspace_name']; ?></a>		  
<?php } ?>
			  </div>
			  <div class="visible-xs">
				   <select id="e1" class="form-control">
						<option value="*"><?php _e("Hepsi"); ?></option>
					<?php $workspaces= $this->getUserWorkspaces();
							foreach ($workspaces as $key => $workspace) { ?>
						<option value=".<?php echo $workspace['workspace_id']; ?>"><?php echo $workspace['workspace_name']; ?></option>
					<?php } ?>
					</select>
			  </div>
		   </div>
	</div>

		<div class="row">
			<div id="filter-controls" class="btn-group">
			  <div class="hidden-xs">
				  <!-- <a href="#" class="btn btn-default" data-filter="*"><?php _e("Hepsi"); ?></a> -->
				  <a href="#" class="btn btn-info" data-filter=".owner"><?php _e("Sahibi"); ?></a>
				  <a href="#" class="btn btn-danger" data-filter=".editor"><?php _e("Editor"); ?></a>
			  </div>
			  <div class="visible-xs">
				   <select id="e1" class="form-control">
						<!-- <option value="*"><?php _e("Hepsi"); ?></option> -->
						<option value=".owner"><?php _e("Sahibi"); ?></option>
						<option value=".editor"><?php _e("Editor"); ?></option>
					</select>
			  </div>
		   </div>
	</div>
	<div class="separator"></div>
	<div id="filter-items" class="row">
<?php
$userid=Yii::app()->user->id;
$workspacesOfUser= $this->getUserWorkspaces();
foreach ($workspacesOfUser as $key => $workspace) {
        $workspace=(object)$workspace;
$all_books= $this->getWorkspaceBooks($workspace->workspace_id);
		foreach ($all_books as $key2 => $book) {
			$userType = $this->userType($book->book_id); ?>
				
			<div class="col-md-3 <?php echo $workspace->workspace_id; ?> <?php echo ($userType=='owner')? 'owner editor':''; ?> <?php echo ($userType=='editor')? 'editor':''; ?> item">
				<!-- BOX -->
				<div class="box" style="opacity: 1; z-index: 0;">
					<div class="box-title">
						<h4><i class="fa fa-book"></i><?php echo $book->title ?></h4>
						<div class="tools">
							<?php if ($userType==='owner') { ?>
							<a href="#box-config<?php echo $book->book_id; ?>" data-toggle="modal" class="config">
								<i class="fa fa-group"></i>
							</a>
							<?php $remove_book_id = ''; ?>
							<a class="remove_book" data-id="<?php echo $book->book_id; ?>" data-toggle="modal" data-target="#myModal">
								<i class="fa fa-times"></i>
							</a>
							<a class="copyThisBook" data-id="copyBook" data-toggle="modal" data-target="#copyBook" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-copy"></i></a>
							<a class="updateThisBookTitle" data-id="updateBookTitle" data-toggle="modal" data-target="#updateBookTitle" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-edit"></i></a>
							<?php } ?>
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
								<?php if ($userType==='owner' || $userType==='editor') { ?>
								<a href="<?php echo '/book/author/'.$book->book_id ?>" class="btn btn-info"><?php echo __('Düzenle');?></a>
								<a href="<?php echo '/EditorActions/ExportBook/'.$book->book_id; ?>" class="btn btn-success"><?php echo __('İndir');?></a>
								<?php
								}
								else {
									?>
									<a href="<?php echo '/EditorActions/ExportBook/'.$book->book_id; ?>" class="btn btn-success"><?php echo __('İndir');?></a>
								<?php } ?>
							</p>
								</div>
								</div>
					</div>
				</div>
				<!-- /BOX -->
			</div>
				
<?php } } ?>
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