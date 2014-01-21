<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


</div>


<div style="height:42px;"></div>
<div id='allWorkspaces' style="position: fixed; width: 100%; height: 100%; background-color: #056380; padding:20px; overflow-y: scroll;">

<?php
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$userid=Yii::app()->user->id;
		//$workspacesOfUser= new WorkspacesUsers();

		$workspacesOfUser= $this->getUserWorkspaces();

		$organization = $this->organization();
		if($organization)
		{
		?>
		<a href='/organisations/index/<?php echo $organization["organisation_id"]?>' class="btn white radius " style="margin-left:20px;"><?php echo __('Organizasyon');?></a>
		<?php
		}

	    foreach ($workspacesOfUser as $key => $workspace) {
	    	$workspace=(object)$workspace;
	    	?>
	    	<div class='workspace'>
	    		<h1 class="float-left white"><?php echo $workspace->workspace_name; ?></h1>
	    		
	    		<a href='/book/newBook' class="btn white radius " style="margin-left:20px;">
	    			<?php 
	    			echo __('Yeni Kitap');

	    			?>
	    		</a>
				
					
				
				<div style="clear:both"></div>
	    		<div class='book_list'>
	    			<?php 
					
	    			$all_books= $this->getWorkspaceBooks($workspace->workspace_id);
	    			foreach ($all_books as $key => $book) {
	    				$userType = $this->userType($book->book_id);

	    				?>
						
						<!-- kitap kutusu-->
						<div class="book-list-box radius" id="book-list-box">
							<div class="book-list-box-book-cover"><img src="/css/images/default-cover.jpg" alt="Book Cover" ></div>
							<div class="book-list-box-text-container">
								<?php echo __('Kitabın Adı');?><input type="text" class="book-list-textbox radius grey-9 float-right" value="<?php echo $book->title ?>">
							</div>

							<div class="book-list-box-text-container">
								<?php echo __('Yazar Adı');?><input type="text" class="book-list-textbox radius grey-9 float-right" value="<?php echo $book->author ?>">
								
							</div>

							<div class="book-list-box-text-container">
								<?php 
								if ($userType==='owner') { ?>
									<a href="#" popup="<?php echo $book->book_id; ?>" class="btn white radius float-right book-editors-settings"id="boook-editors-settings" ><i class="icon-users"></i><?php echo __('Editörler');?></a>	
								<?php }
								?>
								</div>

							<div class="book-list-box-text-container" style="text-align:right;">
								<?php
									if ($userType==='owner') {
										?><a href="<?php echo '/book/delete/'.$book->book_id ?>" class="btn red radius white icon-delete" id="pop-video"><?php echo __('Sil');?></a> <?php
										
										?>

										<a href="<?php echo '/book/author/'.$book->book_id ?>" class="btn white btn radius " id="pop-video"><?php echo __('Düzenle');?></a>
										<?php
									}
									elseif ($userType==='editor') {
										?>
										<a href="<?php echo '/book/author/'.$book->book_id ?>" class="btn white btn radius " id="pop-video"><?php echo __('Düzenle');?></a>
										<?php
									}
								?>

								<a href="<?php echo '/EditorActions/ExportBook/'.$book->book_id; ?>" class="btn bck-light-green white radius" ><i class="icon-download"></i><?php echo __('İndir');?></a>
										<!-- editor options-->
										<center id="popup-close-area" popup="pop-<?php echo $book->book_id; ?>" style="display:none; position:relative">
											<div id="close-div" style="background-color:#123456; width:100% height:#123456; position:fixed;"> </div>
											<div class="book-editors-options-box-container">
											<h2><?php echo __('Kitap Editörleri');?><a popup="close-<?php echo $book->book_id; ?>" id="close-option-box"class="icon-close white size-15 delete-icon float-right" ></a></h2>
											<div class="editor-list">
											<?php 
												$users = $this->bookUsers($book->book_id);

												foreach ($users as $key => $user): 
													if ($user['type']=='owner' || $user['type']=='editor'){?>
													<div id="editor-list-istems" class="editor-list-item">
														<span id="editor-name" class="editor-name">
														<?php echo $user['name']." ".$user['surname']; ?>
														</span>
														
															<?php 
																echo CHtml::link(CHtml::encode(''), array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id),
																  array(
																	'submit'=>array("site/removeUser?userId=".$user['id']."&bookId=".$book->book_id, 'userId'=>$user['id'],'bookId'=>$book->book_id),
																	//'params' => array('bookId'=>$book->book_id, 'user'=>$user['id'], 'del'=>'true'),
																	'class' => 'icon-close size-15 delete-icon'
																  )
																);
																?>

														
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
										</center>

										
										<script>
										$("[popup='<?php echo $book->book_id; ?>']").click(function(){
											$("[popup='pop-<?php echo $book->book_id; ?>']").show("fast").draggable({containment: "#allWorkspaces"});
										});
										$("[popup='close-<?php echo $book->book_id; ?>']").click(function(){
											$("[popup='pop-<?php echo $book->book_id; ?>']").hide("fast");
										});
										</script>
										<!-- editor options-->


							</div>
						</div>

						
						
						<!-- kitap kutusu-->
												
						<!--<a href='<?php echo Yii::app()->createUrl('book/author', array('bookId'=>$book->book_id) ); ?>' />
	    					<div class='book' style='display:inline; float:left; width:200px; height:300px;border:thin solid #000;margin:10px;padding:10px; background:#eee;'>
	    							
	    						<h2><?php echo $book->title ?></h2>
	    						<h3>Yazar: <?php echo $book->author ?></h3>
	    					</div>
						</a>	
						-->
	    				
	    				<?php

	    			}
	    			?>
	    		</div>
	    	</div>
			<hr>
	    	<?php
	    }
?>

</div>

<?php 
	
	//echo CDateFormatter::formatDateTime(time(),'medium');
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
