<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

</div>

<div class="booklistcontainer">

<a href='?r=book/create' 
class='book_create'/>New Book</a>

<?php
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
	    		<h1><?php echo $workspace->workspace_name; ?></h1>
	    		<a href='?r=book/create&workspace=<?php echo $workspace->workspace_id; ?> class='book_create'/>New Book</a>
	    		<div class='book_list'>
	    			<?php 
					
	    			$all_books= Book::model()->findAll('workspace_id=:workspace_id', 
	    				array(':workspace_id' => $workspace->workspace_id  ) ); 
	    			foreach ($all_books as $key => $book) {
	    				
	    				?>
						
						<!-- kitap kutusu-->
						<div class="book-list-box radius" id="book-list-box">
							<div class="book-list-box-book-cover"></div>
							<div class="book-list-box-text-container">
								Kitabın Adı<input type="text" class="book-list-textbox radius grey-9 float-right" value="<?php echo $book->title ?>">
							</div>

							<div class="book-list-box-text-container">
								Yazar Adı<input type="text" class="book-list-textbox radius grey-9 float-right" value="<?php echo $book->author ?>">
								
							</div>

							<div class="book-list-box-text-container">
								Kitap Editörleri <a href="#" class="btn icon-settings white btn radius float-right" id="book-editors-settings"></a> 
									<label class="dropdown-label">
										<select id="font-type" class="book-list-textbox radius grey-9">
													<option selected="" value="k1"> kullanıcı 1 </option>
													<option value="k2" >kullanıcı 2</option>
													<option value="k3" >kullanıcı 3</option>
										</select>
									</label>
								
							</div>
							<div class="book-list-box-text-container" style="text-align:right;">
								<a href="<?php echo Yii::app()->createUrl('book/delete', array('bookId'=>$book->book_id) ); ?>" class="btn red radius white icon-delete " style="font-weight:normal;" id="pop-video"></a>
								<a href="<?php echo Yii::app()->createUrl('book/author', array('bookId'=>$book->book_id) ); ?>" class="btn white btn radius " id="pop-video">Düzenle</a>
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



<!-- seçenekler popup-->

<!-- seçenekler popup-->

<!--	
$( "#book-editors-settings" ).toggle(
	  function() {
		$( this ).after( $( '<span class="settings-box"> a asdfasd fasd fasd fasd fa</span>'  ) );
	 },
	  function() {
		$(".settings-box").remove()
	 },
	);-->
<script>
	
	$( "#book-editors-settings" ).click(function() {
    $( "#book-list-box" ).after('<span class="settings-box" id="settings-box"> a asdfasd fasd fasd fasd fa</span>');
	
	$( "#book-editors-settings" ).click(function() {
	$( ".settings-box" ).remove();
  
});
  
});
	
	
</script>






