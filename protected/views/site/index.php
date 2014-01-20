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
<div id="content" class="col-lg-12">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<div class="clearfix">
										<h3 class="content-title pull-left"><?php echo $workspace->workspace_name; ?></h3>
										<a class="btn pull-right btn-primary" href="/book/newBook">
							<i class="fa-plus"></i>
							<span>Kitap Ekle</span>
						</a>
									</div>
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- FAQ -->
			
<?php
		foreach ($all_books as $key2 => $book) {
			$userType = $this->userType($book->book_id); ?>
				
			<div class="col-md-3 ">
				<!-- BOX -->
				<div class="box" style="opacity: 1; z-index: 0;">
					<div class="box-title">
						<h4><i class="fa fa-book"></i><?php echo $book->title ?></h4>
						<div class="tools">
							<?php if ($userType==='owner') { ?>
							<a href="#box-config<?php echo $book->book_id; ?>" data-toggle="modal" class="config">
								<i class="fa fa-group"></i>
							</a>
							<a href="<?php echo '/book/delete/'.$book->book_id ?>" class="remove">
								<i class="fa fa-times"></i>
							</a>
<!-- POPUP EDITORS -->
<div class="modal fade" id="box-config<?php echo $book->book_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title">Box Settings</h4>
		</div>
		<div class="modal-body">
		  <div class="editor-list">
		<?php 
			$users = $this->bookUsers($book->book_id);

			foreach ($users as $key => $user): 
				if ($user['type']=='owner' || $user['type']=='editor'){?>
				<div class="row">
					<span id="editor-name" class="editor-name">
					<?php echo $user['name']." ".$user['surname']; ?>
					</span>
					<span>
						<?php 
							echo CHtml::link(CHtml::encode('x'), array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id),
							  array(
								'submit'=>array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id, 'userId'=>$user['id'],'bookId'=>$book->book_id),
								//'params' => array('bookId'=>$book->book_id, 'user'=>$user['id'], 'del'=>'true'),
								'class' => 'close'
							  )
							);
							?>

					</span>
					<span id="editor-tag" style="color:#477738; float:right;">
						<?php 
							if ($user['type']=='owner') {
								echo __('Sahibi');
							}
							elseif ($user['type']=='editor') {
								echo __('Editör');
							}
						?>
					</span>
				</div>	
		<?php } endforeach; ?>
		</div>

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
									<img src="/css/images/default-cover.jpg" alt="Book Cover">
								</div>
								
								<div class="col-md-7 form-horizontal">
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
				
<?php } ?>
			</div>	
				
				<!-- /Page Content -->
</div>