<?php

/* @var $this BookController */
/* @var $model Book */
/* @var $page page_id */
/*
$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->title,
);
*/
/*
$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->book_id)),
	array('label'=>'Delete Book', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->book_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Book', 'url'=>array('admin')),
);
*/



$page=Page::model()->findByPk($page_id); 
if($page==null) 
		{ 

			$chapter=Chapter::model()->find('book_id=:book_id', array(':book_id' => $model->book_id ));
			$page=Page::model()->find('chapter_id=:chapter_id', array(':chapter_id' => $chapter->chapter_id ));

 
		} 





 
$current_chapter=Chapter::model()->findByPk($page->chapter_id);
$current_page=Page::model()->findByPk($page->page_id);
  
?>
	
	
	
<script type="text/javascript">
window.lindneo.currentPageId='<?php echo $current_page->page_id; ?>';
window.lindneo.tsimshian.init(); 
window.lindneo.tsimshian.changePage(window.lindneo.currentPageId); 
</script>
	
	
	
		
	

	<label id="options" class="dropdown-label">
					<select id="general-options" class="radius">
						<option selected> Seçenekler </option>
						<option>Seçenek 1</option>
						<option>Seçenek 2</option>
						<option>Seçenek 3</option>
						<option>Seçenek 4</option>
					</select>
					</label>
					
					
					<input type="text" id="search" class="search radius" placeholder="Ara">
					
	
	
	
	
	<label class="dropdown-label" id="user">
					<select id="user-account" class="radius icon-users">
						<option selected> Kullanıcı Adı </option>
						<option>Seçenek 1</option>
						<option>Seçenek 2</option>
						<option>Seçenek 3</option>
						<option>Seçenek 4</option>
					</select>
					</label>
					
					
	<a href="<?php echo $this->createUrl("EditorActions/ExportBook", array('bookId' => $model->book_id ));?>" class="btn bck-light-green white radius" id="header-buttons"><i class="icon-publish"> Yayınla</i></a>
<!--	<a href="#" class="btn bck-light-green white radius" id="header-buttons"><i class="icon-save"> Kaydet</i></a>
 -->
	<div id='book_title'><?php echo $model->title; ?></div>
	
	</div> <!--Header -->
	

	
			<div class="styler_box">
			<!-- <ul id="text-styles" ></ul> -->
				<a id="undo" class="icon-undo dark-blue size-20"></a>
				<a id="redo" class="icon-redo grey-8 size-20"></a>
				
				<div class="vertical-line"></div>
				
					
					
					<input type="color" class="color-picker-box radius" placeholder="e.g. #bbbbbb" />
					
					<label class="dropdown-label">
					<select id="font-type" class="radius">
						<option selected="" value="Arial"> Arial </option>
						<option value="helvetica" >Helvetica</option>
						<option value="Open Sans" >Open Sans</option>
						<option value="Times New Roman" >Times New Roman</option>
						<option value="Courier New" >Courier New</option>
					</select>
					</label>
					
					<label class="dropdown-label">
						<select id="font-size" class="radius">
						<option selected="" value="8"> 8 </option>
						<option value="10" >10</option>
						<option value="12" >12</option>
						<option value="14" >14</option>
						<option value="16" >16</option>
						<option value="18" >18</option>
					</select>	
					</label>					
				<div class="vertical-line"></div>
				
				<a id="font-bold"  href="#" class="dark-blue radius toolbox-items"><i class="icon-font-bold  size-15"></i></a>
				<a id="font-italic"  href="#" class="dark-blue radius toolbox-items"><i class="icon-font-italic size-15"></i></a>
				<a id="font-underline"  href="#" class="dark-blue radius toolbox-items"><i class="icon-font-underline size-15"></i></a>
				<div class="vertical-line"></div>
				<a id="text-align-left"  href="#" class="dark-blue radius toolbox-items"><i class="icon-text-align-left size-15"></i></a>
				<a id="text-align-center"  href="#" class="dark-blue radius toolbox-items"><i class="icon-text-align-center  size-15"></i></a>
				<a id="text-align-right"  href="#" class="dark-blue radius toolbox-items"><i class="icon-text-align-right  size-15"></i></a>
				<div class="vertical-line"></div>
				<a id="make-list-bullet"  href="#" class="dark-blue radius toolbox-items"><i class="icon-list-bullet size-15"></i></a>
				<a id="make-list-number"  href="#" class="dark-blue radius toolbox-items"><i class="icon-list-number size-15"></i></a>
				<div class="vertical-line"></div>
				<a id="text-left-indent"  href="#" class="dark-blue radius toolbox-items"><i class="icon-left-indent size-15"></i></a>
				<a id="text-right-indent"  href="#" class="dark-blue radius toolbox-items"><i class="icon-right-indent size-15"></i></a>
				<div class="vertical-line"></div>
					<label class="dropdown-label">
						<i class="icon-leading grey-6"></i>
							<select id="font-size" class="radius">
								<option selected="" value="8"> 100 </option>
								<option value="0" >0</option>
								<option value="10" >10</option>
								<option value="20" >20</option>
								<option value="30" >30</option>
								<option value="40" >40</option>
								<option value="50" >50</option>
								<option value="60" >60</option>
								<option value="70" >70</option>
								<option value="80" >80</option>
								<option value="90" >90</option>
								<option value="100" >100</option>
							</select>	
					</label>
				<div class="vertical-line"></div>
				
					<label class="dropdown-label">
				<i class="icon-opacity grey-6"></i>
						<select id="font-size" class="radius">
						<option selected="" value="8"> 100 </option>
						<option value="0" >0</option>
						<option value="10" >10</option>
						<option value="20" >20</option>
						<option value="30" >30</option>
						<option value="40" >40</option>
						<option value="50" >50</option>
						<option value="60" >60</option>
						<option value="70" >70</option>
						<option value="80" >80</option>
						<option value="90" >90</option>
						<option value="100" >100</option>
					</select>	
					</label>
					<div class="vertical-line"></div>
				
				<a href="#" class="bck-dark-blue white toolbox-items radius" id="pop-align"><i class="icon-align-center size-20"></i></a>
				<a href="#" class="bck-dark-blue white toolbox-items radius" id="pop-arrange"><i class="icon-send-backward size-15"></i></a>
				
				<a href="#" class="btn white btn radius " id="pop-image">Add Image</a>
				<a href="#" class="btn white btn radius " id="pop-video">Add video</a>
				
				<a href="#" class="btn grey white radius">Grupla</a>
			
		
							
			
			
	<?php if(isset($chapter)) { ?>
		<a href='?r=page/create&chapter_id=<?php echo (isset($this->current_chapter) ? $this->current_chapter->chapter_id :  $chapter->chapter_id); ?>' >Add Page</a>
	<?php } ?>
			</div>
		
		<div style="height:83px;"></div>
		
		<!-- popuplar -->
		
		<script >
	$(function(){
 
 $('a[id^="pop-"]').click(function() {
  
  var  a = $(this).attr("id");
       $("#"+a+"-popup").toggle("blind", 400);
       
  });
 
  $('.popup').draggable();
  
   $('.popup').click(function(){
  $(this).parent().append(this);
   });
    
	
 $('.popup-close').click(function(){
  var  b = $(this).parents().eq(1);
  	$(b).hide("blind", 400);
		
   });
   
   
  });
		
	</script>
	
	
<!--  align popup -->	
<div class="popup" id="pop-align-popup">
<div class="popup-header">
Hizala
<div class="popup-close">x</div>
</div>
<!--  arrange popup -->
<div class="popup-inner-title">Dikey</div>
	<div class="popup-even">
		<i class="icon-align-left size-20 dark-blue"></i>
		<i class="icon-align-center size-20 dark-blue"></i>
		<i class="icon-align-right size-20 dark-blue"></i>
	</div>
	<div class="horizontal-line "></div>
	<div class="popup-inner-title">Yatay</div>
	<div class="popup-even">
		<i class="icon-align-top size-20 dark-blue"></i>
		<i class="icon-align-middle size-20 dark-blue"></i>
		<i class="icon-align-bottom size-20 dark-blue"></i>
	</div>
	<div class="horizontal-line "></div>
	<div class="popup-inner-title">Boşluklar</div>
	<div class="popup-even">
		<i class="icon-vertical-gaps size-20 dark-blue"></i>
		<i class="icon-horizontal-gaps size-20 dark-blue"></i>
	</div>
<!--  arrange popup -->
</div>
<!-- end align popup -->

	
<!--  arrange popup -->

<div class="popup" id="pop-arrange-popup">
<div class="popup-header">
Katman
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<i class="icon-bring-front size-20 dark-blue"><a> En Üste Çıkart</a></i>
	<i class="icon-bring-front-1 size-20 dark-blue"><a> Üste Çıkart</a></i>
	<div class="horizontal-line "></div>
	<i class="icon-send-back size-20 dark-blue"><a> En Alta İndir</a></i>
	<i class="icon-send-backward size-20 dark-blue"><a> Alta İndir</a></i>
<!-- popup content-->
</div>
<!--  end arrange popup -->		


<!--  add image popup -->	
<div class="popup" id="pop-image-popup">
<div class="popup-header">
Görsel Ekle
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<div style="clear:both"></div>
		<div class="add-image-drag-area"> </div>
		<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	


<!--  end add image popup -->		

<!--  add video popup -->	
<div class="popup" id="pop-video-popup">
<div class="popup-header">
Video Ekle
<div class="popup-close">x</div>
</div>

<!-- popup content-->
	<div class="gallery-inner-holder">
		<form id="video-url">
		<input class="input-textbox" type="url" value="URL Adresini Giriniz">
		<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
		</form>
	</div>		
	
<!-- popup content-->
</div>	
<!--  end add image popup -->		
		
		
		

<!-- popuplar -->
	
		
		
<div id='components' >
		<!--<div class="components-header">MEDYA</div>
		<a href="#" ctype="galery" class="radius component grey-9"><i class="icon-m-galery  size-20"></i> Galeri</a>
		<a href="#" ctype="text" class="radius component grey-9"><i class="icon-m-text size-20"></i> Text</a>
		<a href="#" ctype="sound" class="radius component grey-9"><i class="icon-m-sound size-20"></i> Ses</a>
		<a href="#" ctype="image" class="radius component grey-9"><i class="icon-m-image size-20"></i> Görsel</a>
			-->
		<ul class="component_holder">
		
			<li class="left_bar_titles">Medya</li>
			<li ctype="image" class="component icon-m-image">&nbsp;&nbsp;&nbsp;&nbsp;Görsel</li>
			<li ctype="sound" class="component icon-m-sound">&nbsp;&nbsp;&nbsp;&nbsp;Ses</li>
			<li ctype="video" class="component icon-m-video">&nbsp;&nbsp;&nbsp;&nbsp;Video</li>
			<li class="left_bar_titles">Uygulama</li>
			<li ctype="galery" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;Galeri</li>
			<li ctype="quiz"  class="component icon-m-quiz">&nbsp;&nbsp;&nbsp;&nbsp;Quiz</li>
			<li ctype="listbox"  class="component icon-m-listbox">&nbsp;&nbsp;&nbsp;&nbsp;Yazı Kutusu</li>
			<li ctype="popup" class="component icon-m-popup">&nbsp;&nbsp;&nbsp;&nbsp;Pop-up</li>
			<li class="left_bar_titles">Araçlar</li>
			<li ctype="text" class="component icon-m-text">&nbsp;&nbsp;&nbsp;&nbsp;Yazı</li>
			<li ctype="grafik" class="component icon-m-charts">&nbsp;&nbsp;&nbsp;&nbsp;Grafik</li>
			<li ctype="shape" class="component icon-m-shape">&nbsp;&nbsp;&nbsp;&nbsp;Şekil</li>
		</ul>	
			
			
		<div>Zoom:	<div id='zoom-pane'></div>
			</div>	
	</div>

<div id='chapters_pages_view' class="chapter-view" >








	<?php 
	$page_NUM=0;

	$chapters=Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" => array(':book_id' => $model->book_id )));
	//print_r($chapters);
	foreach ($chapters as $key => $chapter) {
			
			$pagesOfChapter=Page::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $chapter->chapter_id )) );
					$chapter_page=0;
					?>
<div class='chapter' chapter_id='<?php echo $chapter->chapter_id; ?>'>
<input type="text" class="chapter-title" placeholder="chapter title" value=" <?php echo $chapter->title; ?>">
<a class="btn red white size-15 radius icon-delete page-chapter-delete  delete-chapter hidden-delete" style="float: right; margin-top: -23px;"></a>
 <!-- <?php echo $chapter->title; ?>  chapter title-->
					<ul class="pages" >
							<?php
							
			foreach ($pagesOfChapter as $key => $pages) {
				
				/* if( $pages->page_id	<div style='	<div style='clear:both;'>


	</div>clear:both;'>


	</div>
					==
					$page->page_id ){
					$this->current_page=$page;
					$this->current_chapter=$chapter;
				}*/
				$page_NUM++;
				?> 
					
					<li class='page' chapter_id='<?php echo $pages->chapter_id; ?>' page_id='<?php echo $pages->page_id; ?>' chapter_id='<?php echo $pages->page_id; ?>'   >
						<a class="btn red white size-15 radius icon-delete page-chapter-delete delete-page hidden-delete" style="margin-left: 38px;"></a>
						<a href='<?php echo $this->createUrl("book/author", array('bookId' => $model->book_id, 'page'=>$pages->page_id ));?>' >

								
							<span class="page-number" >s <?php echo $page_NUM; ?></span>
						</a>	
					</li>
				<?php
				$chapter_page++;
			}
									?>
						</ul>
						</div>
			<?php

	}
	//$this->current_chapter=null;
	?>
	<div id="add-button" class="bck-dark-blue size-25 icon-add white" style="position: fixed; bottom: 0px; right: 0px; width: 140px; text-align: center;"></div>
	
	<script>
	
$( "#add-button" ).hover(
  function() {
    $( this ).append( $(   	'<span id="add-buttons" class="add-button-container">  	    	<a class="add-button-cp white" href="?r=page/create&chapter_id=<?php echo $current_chapter->chapter_id; ?>"> Sayfa ekle </a>  	    	<a class="add-button-cp white" href="?r=chapter/create&book_id=<?php echo $model->book_id; ?>"> Bölüm ekle </a>     	</span>'    	) );
 },
 function(){
			 $('#add-buttons').remove();
    }
   
);



</script>
		
</div>

<div id='author_pane_container' style=' width:100%'>
	<div id='author_pane' style='position:relative;width:1240px; margin: 0 auto; '> <!-- Outhor Pane -->
		<div id='ruler' class="hruler" >
			<?php for ($k=0;$k<150;$k++) {
				echo "<div class='cm'>$k|</div>";
			}
			?>
			
		</div><!-- ruler -->
		
		<div id='guide'> 
		</div> <!-- guide -->
		<div id='editor_view_pane' style=' padding:5px 130px;margin:5px;float:left;'>
			
					<div id='current_page' page_id='<?php echo $page->page_id ;?>' style='background:white;border:thin solid black;zoom:1;padding:1cm; margin-top:5px;  height:700px;width:600px;position:relative' >
						
					</div>


		</div><!-- editor_pane -->



	 
	</div> <!-- Outhor Pane -->
	<div style='float:right;clear:both;'>
		&nbsp;

	</div>
</div><!-- Outhor Pane Container -->




