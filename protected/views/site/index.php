<?php if($verifiedEmail!=0) { ?>
<!-- POPUP email verification -->
<div class="modal fade" id="confirmEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close confirmationClose" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("E-posta Doğrula"); ?></h4>
		</div>
		<div class="modal-body">
			<div class="alert alert-info" id="confirmEmailFeed">
				<?php _e("E-posta adresinize gönderilen linke tıklayarak epostanızı doğrulayabilirsiniz."); ?>
			</div>
	      	<a type="button" class="btn btn-primary" id="reSendEmailVerId"><?php _e("Tekrar Gönder"); ?></a>
		</div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default confirmationClose" data-dismiss="modal" ><?php _e("Kapat"); ?></button>
	      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->
<script type="text/javascript">
	$('#reSendEmailVerId').click(function(){
		var feed=$("#confirmEmailFeed");
		$.ajax({
              type: "GET",
              //data: {title: title, organisation:organisation},
              url: '/user/reSendEmailVerification',
            }).done(function(res){
                console.log(res);
                if (res=="0") {
                	feed.append("<br><br>E-posta adresinize yeni doğrulama linkiniz gönderildi.");
                	$('#reSendEmailVerId').removeClass("btn-primary").addClass("btn-success").text("Gönderildi");
                }else{
                	feed.append("<br><br>Yeni doğrulama linkiniz gönderilirken bir hata oluştu. Lütfen tekrar deneyiniz!");
                };
            });
	});
</script>
<?php } ?>
<?php if ($confirmation !=0 AND $confirmation !=3): ?>

<!-- POPUP verification -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close confirmationClose" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e("Aktive et"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="copy" method="post" class="form-horizontal">
		 		<div class="form-group alert" id="confirmationFeedback">
						
		 		</div>
				<div class="form-group" id="confirmationTel">
					<label class="control-label col-md-3" for="telNumber">Tel: <span class="required">*</span></label>
					<div class="col-md-6">
						<input class="form-control" name="telNumber" id="telNumber" type="tel">
					</div>
					<!-- <div class="col-md-6">
						<input class="form-control" name="telNumber" id="telNumber" type="text">															
					</div> -->
				</div>	
				<div class="form-group" id="confirmationCode">
					<label class="control-label col-md-3" for="confirmId">Aktivasyon Kodu: <span class="required">*</span></label>
					<div class="col-md-6">
						<input class="form-control" name="confirmId" id="confirmId" type="text">															
					</div>
					<div class="col-md-3" id="refreshCode">
						<a href="#" class="btn btn-primary"><i class="fa fa-refresh"> </i></a>	
		 			</div>
				</div>
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<a type="button" class="btn btn-primary" id="sendConfirmationId"><?php _e("Gönder"); ?></a>
	      	<a type="button" class="btn btn-primary" id="checkConfirmationId"><?php _e("Onayla"); ?></a>
	        <button type="button" class="btn btn-default confirmationClose" data-dismiss="modal" ><?php _e("Kapat"); ?></button>
	      </div>
		</div>
	  </div>
	</div>
 
<!-- POPUP END -->


<script type="text/javascript">

	$(document).ready(function() {
		$("#telNumber").intlTelInput();

		var confirmation="<?php echo $confirmation ?>";
		console.log(confirmation);
		var confirmationFeedback=$('#confirmationFeedback');
		var refreshCode=$('#refreshCode');
		var sendConfirmationId=$('#sendConfirmationId');
		var confirmationCode=$('#confirmationCode');
		var checkConfirmationId=$('#checkConfirmationId');
		var confirmationTel=$('#confirmationTel');

		refreshCode.hide();
		confirmationFeedback.hide();


		$('#confirmTelButton').click(function(){
			if (confirmation==2) {
			  		confirmationFeedback.show();
			  		refreshCode.show();
			  		confirmationFeedback.removeClass('alert-danger').removeClass('alert-success');
			  		confirmationFeedback.addClass('alert-warning');
			  		confirmationFeedback.text("Daha önce aktivasyon kodu almışsınız. Hesabınızı aktive etmek için telefonunuza gelen aktivasyon kodunu girin.");
					sendConfirmationId.hide();
	  				confirmationTel.hide();
				}else{
			  		checkConfirmationId.hide();
			  		confirmationCode.hide();
				};

				$('#confirm').addClass('in');
				$('#confirm').show();
		});

		var mytheme = 'future';
		var mypos = 'messenger-on-bottom';
		//Set theme
		Messenger.options = {
			extraClasses: 'messenger-fixed '+mypos,
			theme: mytheme
		}
		var msg;
		msg = Messenger().post({
		  message: 'Telefon ile hesabınızı aktif hale getirmediniz.',
		hideAfter: 150,
		  type: 'error',
		  actions: {
			cancel: {
			  label: 'Aktive et',
			  action: function() {
			  	
			  	if (confirmation==2) {
			  		confirmationFeedback.show();
			  		refreshCode.show();
			  		confirmationFeedback.removeClass('alert-danger').removeClass('alert-success');
			  		confirmationFeedback.addClass('alert-warning');
			  		confirmationFeedback.text("Daha önce aktivasyon kodu almışsınız. Hesabınızı aktive etmek için telefonunuza gelen aktivasyon kodunu girin.");
					sendConfirmationId.hide();
	  				confirmationTel.hide();
				}else{
			  		checkConfirmationId.hide();
			  		confirmationCode.hide();
				};

				$('#confirm').addClass('in');
				$('#confirm').show();
				Messenger().hideAll()
			  }
			},
			open: {
			  label: 'Kapat',
			  action:function() {
			  	Messenger().hideAll()
			  }
			}
		  }
		});

		
		refreshCode.click(function(){
			checkConfirmationId.hide();
	  		confirmationCode.hide();
	  		sendConfirmationId.show();
			confirmationTel.show();
			confirmationFeedback.hide();
	  		refreshCode.hide();

		});

		$('.confirmationClose').click(function(){
			$('#confirm').removeClass('in');
			$('#confirm').hide();
		});

		sendConfirmationId.click(function(){
		  	var telNumber=$('#telNumber').val();
		  	$.ajax({
			  type: "POST",
			  data: {tel: telNumber},
			  url: '/user/sendConfirmationId',
			}).done(function(res){
				if (res==0) {
					checkConfirmationId.show();
				  	confirmationCode.show();
				  	sendConfirmationId.hide();
				  	confirmationTel.hide();
					confirmationFeedback.show();
					confirmationFeedback.show();
					confirmationFeedback.removeClass('alert-danger').removeClass('alert-warning');
					confirmationFeedback.addClass('alert-success');
					confirmationFeedback.text('Aktivasyon kodu telefonunuza gönderildi.');
				}else{
					confirmationFeedback.removeClass('alert-success').removeClass('alert-warning');
					confirmationFeedback.addClass('alert-danger');
					confirmationFeedback.text('Beklenmedik bir hata oluştu. Lütfen tekrar deneyin');
				}
				console.log(res);
			});
		});

		checkConfirmationId.click(function(){
			var confirmId=$('#confirmId').val();
		  	$.ajax({
			  type: "POST",
			  data: {code: confirmId},
			  url: '/user/checkConfirmationId',
			}).done(function(res){
				console.log(res);
				if (res==0) {
					sendConfirmationId.hide();
					confirmationCode.hide();
					checkConfirmationId.hide();
					confirmationTel.hide();
					confirmationFeedback.show();
					confirmationFeedback.removeClass('alert-danger').removeClass('alert-warning');
					confirmationFeedback.addClass('alert-success');
					confirmationFeedback.text('Hesabınız başarıyla aktive edildi.');
				}else{
					confirmationFeedback.show();
					confirmationFeedback.removeClass('alert-success').removeClass('alert-warning');
					confirmationFeedback.addClass('alert-danger');
					confirmationFeedback.text('Geçersiz bir kod girdiniz. Lütfen tekrar deneyin.');
				};
			});
		});
	});
</script>


<?php endif; ?>



<script type="text/javascript">
	

	
$(document).ready(function() {
		$('#li_book').addClass('current');
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
	  location.reload();
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
    var userId=$('#' + b + ' #user').val();
    var newUser=$('#' + b + ' #newUser').val();
    var type=$('#' + b + ' #type').val();
    var bookId=$('#' + b + ' > #book').val();
    if (newUser) {
    	var link ='/site/right?userId='+newUser+'&bookId='+bookId+'&type='+type+'&newUser=1';
    }else{
    	var link ='/site/right?userId='+userId+'&bookId='+bookId+'&type='+type;
    };
    window.location.assign(link);
    //console.log(link);
    }
</script>







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
					<div class="col-md-6">
						<input class="form-control" name="contentTitle" placeholder="Lütfen bir isim girin!" id="updateContentTitle" type="text">															
					</div>
				</div>	
				<div class="form-group">
					<label class="control-label col-md-3" for="contentAuthor">Yazar Adı<span class="required">*</span></label>
					<div class="col-md-6">
						<input class="form-control" name="contentAuthor" placeholder="Yazarın Adını Girin!" id="updateContentAuthor" type="text">															
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
		  <h4 class="modal-title" id="book_data"></h4>
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
			$bookUsers=$this->bookUsers($book->book_id);
			$numberOfOwner=0;
			foreach ($bookUsers as $key => $bookUser) {
				if ($bookUser['type']=='owner'){
					$numberOfOwner++;
				}
			}

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
						if ($user['type']=='editor' || $numberOfOwner > 1) {
							echo CHtml::link(CHtml::encode(''), array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id),
							  array(
								'submit'=>array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id, 'userId'=>$user['id'],'bookId'=>$book->book_id),
								//'params' => array('bookId'=>$book->book_id, 'user'=>$user['id'], 'del'=>'true'),
								'class' => 'fa fa-trash-o pull-right'
							  )
							);
							}
							?>

					</div>
					
				<div class="clearfix"></div>	
				</div>	
		<?php } endforeach; ?>
		

		<div class="alert alert-info">
			<?php
				//owner ya da editor eklemek için siteController 3 tane değerin post edilmesini bekliyor
				//user: eklenecek olan elemanın mail adresi
				//book: kitabın id'si
				//type: owner | editor | user

			?>
			<form class="form-horizontal" role="form" id="a<?php echo $book->book_id; ?>">
			<h4 class="editor-name" ><?php echo __('Kullanıcı Ekle');?>:</h4>
			<input id="book" value="<?php echo $book->book_id; ?>" style="display:none">
			
			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Kayıtlı kullanıcılar: '); ?></label>
				<div class="col-sm-7">
					<select id="user" class="form-control">
						<option value="0"><?php _e("Seç"); ?></option>
						<?php
							$workspaceUsers = $this->workspaceUsers($workspace->workspace_id);
							
							foreach ($workspaceUsers as $key => $workspaceUser) {
								if ($workspaceUser['userid'] != Yii::app()->user->id) {
									echo '<option value="'.$workspaceUser['userid'].'">'.$workspaceUser['name'].' '.$workspaceUser['surname'].'</option>';
								}
							}
						 ?>
					</select>
				</div>
			</div>

			<h4 class="" style="text-align: center;"><?php _e("Veya"); ?></h4>


			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Yeni kullanıcı: '); ?></label>
				<div class="col-sm-7">
					<input class="form-control" id="newUser" type="text" placeholder="email">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label"><?php _e('Kullanıcı Tipi: '); ?></label>
				<div class="col-sm-7">
					 <select id="type" class="form-control">
					  <option value="editor"><?php echo __('Editör');?></option>
					  <option value="owner"><?php echo __('Sahibi');?></option>
					</select>
				</div>
			</div>
			
			<div class="form-group" style="padding-left:130px">
				<a class="btn btn-primary" href="#" onclick="sendRight(a<?php echo $book->book_id; ?>)" class="btn white radius float-right" style="margin-left:20px; width:50px; text-align:center;">
					Ekle
				</a>
			</div>
		</form>
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
								<div class="page-header" style="overflow:visible; padding-bottom:50px;">
										<h3 class="content-title pull-left"><?php _e('Kitaplarım') ?></h3>
                                        
                                        <div class="action_bar_spacer"></div>
                                        
                                        <ul class="mybooks_category_actions">
                                            <li class="dropdown mybooks_page_categories">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kategoriler <i class="fa fa-chevron-down"></i></a>
                                                    <ul class="dropdown-menu" id="filter-controls">
                                                        <li><a href="#" data-filter="*"><?php _e("Hepsi"); ?></a></li>
                                                        <li><a href="#" data-filter=".owner"><?php _e("Sahibi"); ?></a></li>
                                                        <li><a href="#" data-filter=".editor"><?php _e("Editör"); ?></a></li>
                                                        <li class="mybooks_page_category_divider"></li>
                                                        <?php 
														$workspaces= $this->getUserWorkspaces();
														foreach ($workspaces as $key => $workspace) { ?>
																<li><a href="#" data-filter=".<?php echo $workspace['workspace_id']; ?>"><?php echo $workspace['workspace_name']; ?></a></li>
														<?php } ?>
                                                    </ul>
                                            </li>
                                        </ul>
                                        
										<a class="btn pull-right brand_color_for_buttons" id='addNewBookBtn' href="/book/bookCreate" <?php echo ($confirmation !=0 AND $confirmation !=3 AND $verifiedEmail!=0)? "disabled":""; ?>>
											<i class="fa fa-plus-circle"></i>
											<span><?php _e('Kitap Ekle') ?></span>
										</a>
										<?php if($confirmation !=0 AND $confirmation !=3) { ?>
										<a class="btn pull-right btn-danger" id="confirmTelButton" data-toggle="modal" data-target="#confirm" data-id="confirm" href="#">
											<span><?php _e('Telefon doğrula') ?></span>
										</a>
										<?php } ?>
										<?php if($verifiedEmail!=0) { ?>
										<a class="btn pull-right btn-danger" data-toggle="modal" data-target="#confirmEmail" data-id="confirmEmail"  href="#">
											<span><?php _e('E-posta doğrula') ?></span>
										</a>
										<?php } ?>
										
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- FAQ -->
		
		<div class="mybooks_page_category_viewer">Hepsi</div>
        
        <div class="separator"></div>
        
<script type="text/javascript">
	$('#filter-controls>li>a').click(function(){
		$('.mybooks_page_category_viewer').html($(this).html());
	});
</script>
	<div id="filter-items" class="mybooks_page_book_filter row">
    
    
    
    
    
    <div class="clearfix"></div>
   
    
<?php
$userid=Yii::app()->user->id;
$workspacesOfUser= $this->getUserWorkspaces();
foreach ($workspacesOfUser as $key => $workspace) {
        $workspace=(object)$workspace;
		$all_books= $this->getWorkspaceBooks($workspace->workspace_id);
		foreach ($all_books as $key2 => $book) {
			$userType = $this->userType($book->book_id); 

			$book_update_data = array(
								'book_name'=>$book->title,
							   'book_author'=>$book->author
							    );
			?>
				
				<!-- book card -->
				<div class="reader_book_card <?php echo $workspace->workspace_id; ?> <?php echo ($userType=='owner')? 'owner editor':''; ?> <?php echo ($userType=='editor')? 'editor':''; ?>">
		            <div class="reader_book_card_book_cover">					
		                <div class="<?php echo ($userType==='owner' || $userType==='editor' || $userType==='user') ? 'editor_mybooks_book_settings' : '' ; ?>">
		                    <?php if ($userType==='owner') { ?>
		                    <a href="#box-config<?php echo $book->book_id; ?>" data-toggle="modal" class="config"><i class="fa fa-users tip" data-original-title="Editörler"></i></a>
		                    <a class="remove_book" data-id="<?php echo $book->book_id; ?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash-o tip" data-original-title="Sil"></i></a>
		                    <a class="copyThisBook" data-id="<?php echo $workspace->workspace_name; ?>" data-name="<?php echo $book->title; ?>" data-toggle="modal" data-target="#copyBook" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-copy tip" data-original-title="Çoğalt"></i></a>
		                    <a class="updateThisBookTitle" data-id="<?php echo base64_encode(json_encode($book_update_data)); ?>" data-toggle="modal" data-target="#updateBookTitle" book-id="<?php echo $book->book_id; ?>"><i class="fa fa-edit tip" data-original-title="Düzenle"></i></a>
		                    <?php } ?>
		                    <?php if ($userType==='owner' || $userType==='editor') { ?>
		                    <?php } ?>
		                </div>
		                <?php 
							$thumbnailSrc="/css/images/deneme_cover.jpg";
							$bookData=json_decode($book->data,true);
							 if (isset($bookData['thumbnail'])) {
							 	$thumbnailSrc=$bookData['thumbnail'];
							 }

						?>
		                <img src="<?php echo $thumbnailSrc; ?>" />
		            </div>					
		            <div class="reader_book_card_info_container">
		                <div class="editor_mybooks_book_type tip" data-original-title="<?php _e('Kitap Erişim İzini') ?>" style="<?php echo ($userType=='owner')? 'border-color:#D9583B':'' ; ?><?php echo ($userType=='editor')? 'border-color:#41A693':'' ; ?><?php echo ($userType!='editor' and $userType!='owner')? 'border:0':'' ; ?>"><?php if ($userType=='owner') {_e('Sahibi');} ?><?php if ($userType=='editor') { _e('Editör'); } ?><?php if ($userType!='owner' && $userType!='editor') { _e('Diğer'); } ?></div>
		                <div class="clearfix"></div>			
		                <div class="reader_market_book_name tip" data-original-title="<?php _e('Kitabın adı'); echo ': '.$book->title ?>"></i>
		                	<?php echo ($userType==='owner' || $userType==='editor') ? '<a href="/book/author/'.$book->book_id.'">':'' ;?>
		                		<?php echo $book->title ?>
		                	<?php echo ($userType==='owner' || $userType==='editor') ? '</a>':'' ;?>
		                </div>						
		                <div class="clearfix"></div>						
		                <div class="reader_book_card_writer_name tip" data-original-title="<?php _e('Yazarın adı'); echo ': '.$book->author ?>"><?php echo $book->author ?></div>											
		            </div>				
		        </div>
		        <!-- book card -->

			
				
<?php } } ?>

<script type="text/javascript">
	$().ready(function(){
		if( $('.reader_book_card').length==0 ) {
			tripStart();
		}
	});
</script>
			</div>	
				
				<!-- /Page Content -->
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sil</h4>
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
	workspace_name = $(this).data('id');
	book_name = $(this).data('name');
	var book_copy_data = workspace_name + " / " + book_name;
	$("#book_data").html(book_copy_data);
	
});
$(document).on("click",".updateThisBookTitle",function(e){
	bookId = $(this).attr('book-id');
	var id=$(this).data("id");
	book_update_data = JSON.parse(atob(id));

	$("#updateContentTitle").val(book_update_data.book_name);
	$("#updateContentAuthor").val(book_update_data.book_author);
	console.log(book_update_data);
});

var workspaceId="";
$(document).on("click",".SelectWorkspace",function(e){
	$(".SelectWorkspace span").removeClass("checked");
	$(this).children("span").addClass("checked");
	workspaceId=$(this).children("span").children("input").val();
});

$("#copy_book").click(function(){
	$("#copy_book").removeClass("btn-primary").addClass("btn-success").attr("disabled","disabled");
	var title=$("#newContentTitle").val();
	var link ="/book/copyBook?bookId="+bookId+"&workspaceId="+workspaceId+'&title='+title;
    window.location.assign(link);
});


$("#update_book_title").click(function(){
	var title=$("#updateContentTitle").val();
	var author=$("#updateContentAuthor").val();
	var link ="/book/updateBookTitle?bookId="+bookId+'&title='+title+'&author='+author;
    window.location.assign(link);
});


</script>

<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
