<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

</div>


<div style="height:42px;"></div>
<div style="position: fixed; width: 100%; height: 100%; background-color: #056380; padding:20px; overflow-y: scroll;">








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
							<!-- Editor options popupunu açan buton -->
							<a href="#" class="btn white radius float-right book-editors-settings"id="boook-editors-settings" ><i class="icon-settings" style="font-weight:normal; margin-right:5px;"></i>Editörler</a>
					<!-- Editor options popupunu açan buton -->
								
							</div>

							<div class="book-list-box-text-container" style="text-align:right;">
								<?php
									if ($userType==='owner') {
										?>
										
										<!--
												buraya hakları düzenlemek için popup eklenecek
												
												!!!!!!!!!!!!!! (can: aşağıda, editor options  yazan commentler arasında)!!!!!!!!!!!!!!
												
										-->
															
										
										
										
									<?php
									/*  kullanıcıları popup içerisinde listeliyorum */
										$users = bookUsers($book->book_id);
										foreach ($users as $key => $user) {




										}
										//owner ya da editor eklemek için siteController 3 tane değerin post edilmesini bekliyor
										//user: eklenecek olan elemanın mail adresi
										//book: kitabın id'si
										//type: owner | editor | user


										

									?>


										

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

								<a href="<?php echo Yii::app()->createUrl('EditorActions/ExportBook', array('bookId'=>$book->book_id) ); ?>" class="btn bck-light-green white radius" id="header-buttons"><i class="icon-publish"> Indir</i></a>
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

				<!-- editor options-->
				<center id="popup-close-area" class="book-editors-options-box">
				<div id="close-div" style="background-color:#123456; width:100% height:#123456; position:fixed;"> </div>
				<div class="book-editors-options-box-container">
				<h2>Kitap Editörleri<a id="close-option-box"class="icon-close white size-15 delete-icon float-right" ></a></h2>
				<div class="editor-list">

				<!-- editorlerin olduğu satır burası burayı çoğalt-->
				<div id="editor-list-istems" class="editor-list-item">
				<span id="editor-name" class="editor-name">
				Can Deniz Güngörmüş
				</span>
				<a id="delete-editor"class="icon-close size-15 delete-icon" ></a>
				<span id="editor-tag" style="color:#477738; float:right;">
				sahibi
				</span>
				</div>
				<!-- editorlerin olduğu satır burası burayı çoğalt-->

				<!-- editorlerin olduğu satır burası burayı çoğalt-->
				<div id="editor-list-istems" class="editor-list-item">
				<span id="editor-name" class="editor-name">
				Can Deniz Güngörmüş
				</span>
				<a id="delete-editor"class="icon-close size-15 delete-icon" ></a>
				<span id="editor-tag" style="color:#fbae3c; float:right;">
				editör
				</span>
				</div>
				<!-- editorlerin olduğu satır burası burayı çoğalt-->
				</div>

				<div style="background-color:#fff; height: 60px; padding:5px; margin:10px; color:#333; text-align:left;">

				<span class="editor-name" >Kullanıcı Ekle(e-posta adresi):</span>
				<br style="clear:both; margin-bottom:20px;">

				<input type="text" class="book-list-textbox radius grey-9 float-left"  style=" width: 300px;  "value="e-posta adresi"> 
				<a href="" class="btn white radius float-right" style="margin-left:20px; width:50px; text-align:center;" id="pop-video">Ekle</a>
				</div>

				</div>
				</center>
				<!-- editor options-->


				
<script>
	
 $( "#boook-editors-settings" ).click(function() {
  $( ".book-editors-options-box" ).show( "fast" );
  
  $( "#close-option-box" ).click(function() {
  $( ".book-editors-options-box" ).hide( "fast" );
  });

});
	
</script>




