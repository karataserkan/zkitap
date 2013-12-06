<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

</div>


<div style="height:42px;"></div>
<div id='allWorkspaces' style="position: fixed; width: 100%; height: 100%; background-color: #056380; padding:20px; overflow-y: scroll;">








<?php
		
	/**
	* this returns the user type for $bookId
	* return owner | editor | user | false
	*/
	function userType($bookId)
	{
		$userid=Yii::app()->user->id;

		$bookOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("book_users")
	    ->where("book_id=:book_id", array(':book_id' => $bookId))
	    ->andWhere("user_id=:user_id", array(':user_id' => $userid))
	    ->queryRow();
	    
	    return ($bookOfUser) ? $bookOfUser['type'] : false;
	}


	//kitabın kullanıcılarını return ediyorum
	function bookUsers($bookId)
	{
		$bookUsers = Yii::app()->db->createCommand()
		->select ("*")
		->from("book_users")
		->where("book_id=:book_id", array(':book_id' => $bookId))
		->join("user","user_id=id")
		->queryAll();

		return $bookUsers;
	}

	function workspaceUsers($workspace_id)
	{
		$workspaceUsers = Yii::app()->db->createCommand()
		->select ("*")
		->from("workspaces_users")
		->where("workspace_id=:workspace_id", array(':workspace_id' => $workspace_id))
		->join("user","userid=id")
		->queryAll();

		return $workspaceUsers;
	}

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$userid=Yii::app()->user->id;
		//$workspacesOfUser= new WorkspacesUsers();

		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->join("user u","x.userid=u.id")
	    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
		

	    foreach ($workspacesOfUser as $key => $workspace) {
	    	$workspace=(object)$workspace;
	    	?>
	    	<div class='workspace'>
	    		<h1 class="float-left white"><?php echo $workspace->workspace_name; ?></h1>
	    		<a href='?r=book/create' class="btn white btn radius " style="margin-left:20px;">Yeni Kitap</a>
				
					
				
				<div style="clear:both"></div>
	    		<div class='book_list'>
	    			<?php 
					
	    			$all_books= Book::model()->findAll('workspace_id=:workspace_id', 
	    				array(':workspace_id' => $workspace->workspace_id  ) ); 
	    			foreach ($all_books as $key => $book) {
	    				$userType = userType($book->book_id);

	    				?>
						
						<!-- kitap kutusu-->
						<div class="book-list-box radius" id="book-list-box">
							<div class="book-list-box-book-cover"><img src="/css/images/default-cover.jpg" alt="Book Cover" ></div>
							<div class="book-list-box-text-container">
								Kitabın Adı<input type="text" class="book-list-textbox radius grey-9 float-right" value="<?php echo $book->title ?>">
							</div>

							<div class="book-list-box-text-container">
								Yazar Adı<input type="text" class="book-list-textbox radius grey-9 float-right" value="<?php echo $book->author ?>">
								
							</div>

							<div class="book-list-box-text-container">
								<?php 
								if ($userType==='owner') { ?>
									<a href="#" popup="<?php echo $book->book_id; ?>" class="btn white radius float-right book-editors-settings"id="boook-editors-settings" ><i class="icon-settings" style="font-weight:normal; margin-right:5px;"></i>Editörler</a>	
								<?php }
								?>
								</div>

							<div class="book-list-box-text-container" style="text-align:right;">
								<?php
									if ($userType==='owner') {
										?>
										
						
										<!-- Editor options popupunu açan buton -->
										
										<!-- Editor options popupunu açan buton -->
										<!--
												buraya hakları düzenlemek için popup eklenecek
												
												!!!!!!!!!!!!!! (can: aşağıda, editor options  yazan commentler arasında)!!!!!!!!!!!!!!
												
										-->
										<?php //echo $book->book_id; ?>
										
										<!-- editor options-->
										<center id="popup-close-area" class="book-editors-options-box" popup="pop-<?php echo $book->book_id; ?>" style="position:relative">
										<div id="close-div" style="background-color:#123456; width:100% height:#123456; position:fixed;"> </div>
										<div class="book-editors-options-box-container">
										<h2>Kitap Editörleri<a popup="close-<?php echo $book->book_id; ?>" id="close-option-box"class="icon-close white size-15 delete-icon float-right" ></a></h2>
										<div class="editor-list">
										<?php 
											$users = bookUsers($book->book_id);

											foreach ($users as $key => $user): 
												if ($user['type']=='owner' || $user['type']=='editor'){?>
												<div id="editor-list-istems" class="editor-list-item">
													<span id="editor-name" class="editor-name">
													<?php echo $user['name']." ".$user['surname']; ?>
													</span>
													
														<?php 
															echo CHtml::link(CHtml::encode(''), array('site/index'),
															  array(
															    'submit'=>array('site/index', 'bookId'=>$book->book_id, 'user'=>$user['id'], 'del'=>'true'),
															    'params' => array('bookId'=>$book->book_id, 'user'=>$user['id'], 'del'=>'true'),
															    'class' => 'icon-close size-15 delete-icon'
															  )
															);
															?>

													
													<span id="editor-tag" style="color:#477738; float:right;">
														<?php 
															if ($user['type']=='owner') {
																echo "sahibi";
															}
															elseif ($user['type']=='editor') {
																echo "editör";
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
											<span class="editor-name" >Kullanıcı Ekle:</span>
											<br style="clear:both; margin-bottom:20px;">
											<form id="a<?php echo $book->book_id; ?>" method="post">
											<input id="book" value="<?php echo $book->book_id; ?>" style="display:none">
											<select id="user" class="book-list-textbox radius grey-9 float-left"  style=" width: 280px;">
												<?php
													$workspaceUsers = workspaceUsers($workspace->workspace_id);
													
													foreach ($workspaceUsers as $key => $workspaceUser) {
														echo '<option value="'.$workspaceUser['userid'].'">'.$workspaceUser['name'].' '.$workspaceUser['surname'].'</option>';
													}
												 ?>
											</select>
											 <select id="type" class="book-list-textbox radius grey-9 float-left"  style=" width: 70px;" >
											  <option value="editor">Editör</option>
											  <option value="owner">Sahibi</option>
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


										<?php 
										echo CHtml::link(CHtml::encode(''), array('book/delete', 'bookId'=>$book->book_id),
										  array(
										    'submit'=>array('book/delete', 'bookId'=>$book->book_id),
										    'class' => 'delete','confirm'=>'kitap silinecek. Onaylıyor musun?',
										    'class' => 'btn red radius white icon-delete'
										  )
										);
										?>

										<a href="<?php echo Yii::app()->createUrl('book/author', array('bookId'=>$book->book_id) ); ?>" class="btn white btn radius " id="pop-video">Düzenle</a>
										<?php
									}
									elseif ($userType==='editor') {
										?>
										<a href="<?php echo Yii::app()->createUrl('book/author', array('bookId'=>$book->book_id) ); ?>" class="btn white btn radius " id="pop-video">Düzenle</a>
										<?php
									}
								?>

								<a href="<?php echo Yii::app()->createUrl('EditorActions/ExportBook', array('bookId'=>$book->book_id) ); ?>" class="btn bck-light-green white radius" ><i class="icon-download"> İndir</i></a>
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

				


				





<script>
//burada kullanıcıya hakları vermek için seçilmiş olan user | book | type il link oluşturup yönlendiriyorum
//ekaratas start											
function sendRight(e){
    var b = e.id;
    var userId=$('#' + b + '> #user').val();
    var type=$('#' + b + '> #type').val();
    var bookId=$('#' + b + ' > #book').val();
    var link ='?r=site/right&userId='+userId+'&bookId='+bookId+'&type='+type;
    window.location.assign(link);
    }
    //ekaratas end
</script>