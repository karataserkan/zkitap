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
			if($component_id) {
				$highlight_component=Component::model()->findByPk( $component_id);
				$page=Page::model()->findByPk($highlight_component->page_id);
			}else {
				$chapter=Chapter::model()->find('book_id=:book_id', array(':book_id' => $model->book_id ));
				$page=Page::model()->find('chapter_id=:chapter_id', array(':chapter_id' => $chapter->chapter_id ));
			}
 
		} 




 
$current_chapter=Chapter::model()->findByPk($page->chapter_id);
$current_page=Page::model()->findByPk($page->page_id);
$current_user=User::model()->findByPk(Yii::app()->user->id);

?>
	
	
	
<script type="text/javascript">
	
	window.lindneo.currentPageId='<?php echo $current_page->page_id; ?>';
	window.lindneo.currentBookId='<?php echo $model->book_id; ?>';

	window.lindneo.user={};
	window.lindneo.user.username='<?php echo Yii::app()->user->name; ?>';
	window.lindneo.user.name='<?php echo $current_user->name . " ". $current_user->surname; ?>';


	window.lindneo.tsimshian.init(); 

	window.lindneo.tsimshian.changePage(window.lindneo.currentPageId); 
	window.lindneo.highlightComponent='<?php echo $highlight_component->id; ?>';

</script>
	
	
	
		
	

	
					<select id="general-options" class="radius">
						<option selected value=''> Hiçbiri </option>
						<option value='rehber'> Rehber</option>
						<option value='cetvel'>Cetvel</option>
						<option value='rehber+cetvel'>Rehber & Cetvel</option>
						
					</select>
					<script type="text/javascript">

					</script>
				
					<!--
					<form action='' id='searchform' style="float:left;">

					<input type="text" id="search" name='component' class="search radius" placeholder="Ara">
					<input type="hidden" name='r' value='book/author'>
					<input type="hidden" name='bookId' value='<?php echo $model->book_id; ?>'>
					</form>
					-->
	
	
	

					<select id="user-account" class="radius icon-users">
						<option selected> Kullanıcı Adı </option>
						<option>Seçenek 1</option>
						<option>Seçenek 2</option>
						<option>Seçenek 3</option>
						<option>Seçenek 4</option>
					</select>
					
					
	<a href="<?php echo $this->createUrl("EditorActions/ExportPdfBook", array('bookId' => $model->book_id ));?>" class="btn bck-light-green white radius" > <i class="icon-publish"> PDF Yayınla</i></a>				
	<a href="<?php echo $this->createUrl("EditorActions/ExportBook", array('bookId' => $model->book_id ));?>" class="btn bck-light-green white radius" id="header-buttons"><i class="icon-publish"> Yayınla</i></a>
<!--	<a href="#" class="btn bck-light-green white radius" id="header-buttons"><i class="icon-save"> Kaydet</i></a>
 -->
	<div id='book_title'><?php echo $model->title; ?></div>
	
	</div> <!--Header -->
	
			<div id='headermenu'>
			<ul>
			   <li><a style="height:40px;" href="<?php echo $this->createUrl('site/index');  ?>"><img  src="/css/linden_logo.png" height="30px;" style="padding-top:5px;"></a></li>
			   <li><a contenteditable="true"> <?php echo $model->title; ?></a></li>
			   <li class='has-sub'><a href='#'><span>Dosya</span></a>
					<ul>
			         <li><a href="<?php echo $this->createUrl('site/index');  ?>"><span><i class="icon-book"></i>Kitaplarım</span></a></li>
			         <li><a href="<?php echo $this->createUrl('site/index');  ?>"><span><i class="icon-folder-open"></i>Pdf İçe Aktar </span></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/ExportPdfBook", array('bookId' => $model->book_id ));?>"> <i class="icon-doc-inv"></i>PDF Yayınla</i></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/ExportBook", array('bookId' => $model->book_id ));?>"><i class="icon-publish"></i>Yayınla</a></li>
					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>Düzenle</span></a>
			      <ul>
			         <li><a href='#' id="undo"><i class="icon-undo size-10"></i><span>Geri Al</span></a></li>
			         <li><a href='#' id="redo"><i class="icon-redo size-10"></i><span>İleri Al</span></a></li>
			         <li><a href='#' id="generic-cut"><i class="generic-cut icon-cut size-20"></i><span>Kes</span></a></li>
			         <li><a href='#' id="generic-copy"><i class="generic-copy icon-copy size-20"></i><span>Kopyala</span></a></li>
			         <li><a href='#' id="generic-paste"><i class="generic-paste icon-paste size-20"></i><span>Yapıştır</span></a></li>
			         <li class='last'><a href='#'><span>Location</span></a></li>
			      </ul>
			   </li>

			   <li class='has-sub'><a href='#'><span><?php _e('Görünüm') ?> </span></a>
					<ul>
				     <li class="onoff"><a href='#' ><input type="checkbox" name="cetvel" id="cetvelcheck" class="css-checkbox" /><label for="cetvelcheck" class="css-label"><?php _e('Cetvel') ?></label></a></li>
			         <li class="onoff"><a href='#' ><input type="checkbox" name="rehber" id="rehbercheck" class="css-checkbox" /><label for="rehbercheck" class="css-label"><?php _e('Rehber') ?></label></a></li>
			         <li class="onoff"><a href='#' ><input type="checkbox" name="yorumlar" id="yorumlarcheck" class="css-checkbox" /><label for="yorumlarcheck" class="css-label"><?php _e('Yorumlar') ?></label></a></li>
			        </ul>
			   </li>
				
			    
			   <li><a href='#'>
			   <form action='/book/author/<?php echo $model->book_id; ?>' id='searchform' style="float:left;" method="post">
					<input type="text" id="searchn" name='component' class="search radius ui-autocomplete-input" placeholder="Ara" autocomplete="on">
				</form>
			   <!--
			   <input type="text" id="searchn" name="component" style="display:none;" class="search radius ui-autocomplete-input" placeholder="Ara" autocomplete="on">
			   -->
			   <span id="search_btn">&nbsp;&nbsp;&nbsp;<i class="icon-zoom size-15"></i></span></a></li>
			  
			 
			   <li style="float:right; " class='has-sub'>
			  
					<a id='login_area' style='float:right;'>
						<?php
						if(Yii::app()->user->isGuest){
							echo CHtml::link(array('site/login'));
						}else{
							echo CHtml::link('('.Yii::app()->user->name.')',array('site/logout'));
						}
						?>
					</a>   
			      <ul>

			      	<?php if (!Yii::app()->user->isGuest) {?>
			         <li><a href='/index.php?r=user/profile'><span><?php _e('Profil') ?></span></a></li>
			         <?php echo " <li>". CHtml::link(__("Çıkış"),"/site/logout") ."</li>"; ?>
					<?php 
						foreach (Yii::app()->params->availableLanguages  as $lang_id => $lang_name) {
							$_GET['language']=$lang_id;
							$lang_link_params = array_merge(array($this->route),$_GET ) ;

							echo " <li>". CHtml::link("<span>".$lang_name."</span>",$lang_link_params ) ."</li>";

						}
					?>
			         <?php } ?>
			      </ul>
			   </li>
			   
			   <li class="left-border" style="float:right; height:37px; min-width:50px; text-align:center; padding-top: 5px; ">
			  <i id="save_status" class="size-30"></i>
			   </li>
			</ul>
			<script>
			$("#search_btn").click(function(){
			$("#searchn").toggle();
			})
			</script>


			</div>
			<div class="styler_box">
			<!-- <ul id="text-styles" ></ul> -->
                        <div class="generic-options float-left"  style="display:inline-block; margin-right:5px;">

				<a id="undo" class="toolbox-items icon-undo dark-blue size-15"></a>
				<a id="redo" class="toolbox-items icon-redo grey-8 size-15"></a>
			</div>
			<div class="vertical-line responsive_2"></div>
						
			<div class="text-options table-options toolbox" style="display:inline-block;">
					
					
					<input class='tool color' rel='color' type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" />
				
					<select class='tool select' rel='fast-style' id="fast-style" class="radius">
						<option value="">Serbest</option>
						<option value="h1" >Başlık</option>
						<option value="h2" >Alt Başlık</option>
						<option value="h3" >Kucuk Başlık</option>
						<option value="p"  >Paragraf</option>
						<option value="blockqoute" >Alıntı</option>
					</select>
					
					<select class='tool select' rel='font-family' id="font-family" class="radius">
						<option selected="" value="Arial"> Arial </option>
						<option value="SourceSansPro" >Source Sans Pro</option>
						<option value="AlexBrushRegular" >Alex Brush Regular</option>
						<option value="ChunkFiveRoman" >ChunkFive Roman</option>
						<option value="Aller" >Aller</option>
						<option value="Cantarell" >Cantarell</option>
						<option value="Exo" >Exo</option>
						<option value="helvetica" >Helvetica</option>
						<option value="Open Sans" >Open Sans</option>
						<option value="Times New Roman" >Times New Roman</option>
						<option value="georgia" >Georgia</option>
						<option value="Courier New" >Courier New</option>
					</select>
				
					
					
						<select class='tool select' rel='font-size' id="font-size" class="radius">
						<option selected="" value="8px"> 8 </option>
						<?php for ($font_size_counter=10; $font_size_counter<=250;$font_size_counter+=2){
							echo "<option value='{$font_size_counter}px' >{$font_size_counter}</option>";
						} ?>


					</select>	
								
				<div class="vertical-line"></div>
				<div id="checkbox-container" style="display:inline-block">
					<input type="checkbox" id="font-bold" rel='font-weight' activeVal='bold' passiveVal='normal'  class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label class="icon-font-bold  size-15" for="font-bold"></label>
					<input type="checkbox" id="font-italic" rel='font-style' activeVal='italic' passiveVal='normal'  class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label class="icon-font-italic size-15" for="font-italic"></label>
					<input type="checkbox" id="font-underline" rel='text-decoration' activeVal='underline' passiveVal='none'  class="dark-blue radius toolbox-items btn-checkbox tool checkbox">
					<label class="icon-font-underline size-15" for="font-underline"></label>				</div>
 
				
				<div class="vertical-line"></div>

				<input type='radio' rel='text-align' name='text-align' activeVal='left' id="text-align-left"  href="#" class="dark-blue radius toolbox-items radio tool"><label for='text-align-left' class="icon-text-align-left size-15"></label>
				<input type='radio' rel='text-align' name='text-align' activeVal='center' id="text-align-center"  href="#" class="dark-blue radius toolbox-items  radio tool"><label for='text-align-center' class="icon-text-align-center  size-15"></label>
				<input type='radio' rel='text-align' name='text-align' activeVal='right' id="text-align-right"  href="#" class="dark-blue radius toolbox-items  radio tool"><label for='text-align-right' class="icon-text-align-right  size-15"></label>

				<div class="vertical-line"></div>
				<!--
				<input type='checkbox' rel='text-listing' name='listing' activeVal='bullet' id="make-list-bullet"   class="dark-blue radius toolbox-items tool checkbox"><label for='make-list-bullet' class="icon-list-bullet size-15" ></label>
				<input type='checkbox' rel='text-listing' name='listing' activeVal='number' id="make-list-number"   class="dark-blue radius toolbox-items tool checkbox" ><label for='make-list-number' class="icon-list-number size-15"></label>

				<script type="text/javascript">
				$('#make-list-bullet').change(function(){ if( $(this).is(':checked')==true  ) $('#make-list-number').prop('checked',false);   });
				$('#make-list-number').change(function(){ if( $(this).is(':checked')==true ) $('#make-list-bullet').prop('checked',false);   });

				
				</script>

				<div class="vertical-line"></div>
				
				<!-- indent sonra eklenecek -->
				<!--
				<a id="text-left-indent"  href="#" class="dark-blue radius toolbox-items "><i class="icon-left-indent size-15"></i></a>
				<a id="text-right-indent"  href="#" class="dark-blue radius toolbox-items "><i class="icon-right-indent size-15"></i></a>
				
				<div class="vertical-line"></div>
				-->
				<!-- leading sonra eklenecek -->
				<!-- 
						<i class="icon-leading grey-6"></i>
							<select id="leading" class="radius">
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
				
				<div class="vertical-line"></div>
				-->
				
					<i class="icon-opacity grey-6"></i>
							<select class='tool-select tool select' rel='opacitypop' rel='color' id="font-size" class="radius">
								
								<option value="0" >0</option>
								<option value="0.10" >10</option>
								<option value="0.20" >20</option>
								<option value="0.30" >30</option>
								<option value="0.40" >40</option>
								<option value="0.50" >50</option>
								<option value="0.60" >60</option>
								<option value="0.70" >70</option>
								<option value="0.80" >80</option>
								<option value="0.90" >90</option>
								<option selected="selected"  value="1" >100</option>
							</select>	
				
					<div class="vertical-line"></div>
			</div>
			
			
			<div class="image-options toolbox" style="display:inline-block;">
				<div class="vertical-line"></div>
				
						<i class="icon-opacity grey-6"></i>
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius">
								
								<option value="0" >0</option>
								<option value="0.10" >10</option>
								<option value="0.20" >20</option>
								<option value="0.30" >30</option>
								<option value="0.40" >40</option>
								<option value="0.50" >50</option>
								<option value="0.60" >60</option>
								<option value="0.70" >70</option>
								<option value="0.80" >80</option>
								<option value="0.90" >90</option>
								<option selected="selected"  value="1" >100</option>
							</select>	
							
			</div>

			<div class="popup-options toolbox" style="display:inline-block;">
				<div class="vertical-line"></div>
				
						<i class="icon-opacity grey-6"></i>
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius">
								
								<option value="0" >0</option>
								<option value="0.10" >10</option>
								<option value="0.20" >20</option>
								<option value="0.30" >30</option>
								<option value="0.40" >40</option>
								<option value="0.50" >50</option>
								<option value="0.60" >60</option>
								<option value="0.70" >70</option>
								<option value="0.80" >80</option>
								<option value="0.90" >90</option>
								<option selected="selected"  value="1" >100</option>
							</select>	
							
			</div>

			<div class="link-options toolbox" style="display:inline-block;">
				<div class="vertical-line"></div>
				
						<i class="icon-opacity grey-6"></i>
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius">
								
								<option value="0" >0</option>
								<option value="0.10" >10</option>
								<option value="0.20" >20</option>
								<option value="0.30" >30</option>
								<option value="0.40" >40</option>
								<option value="0.50" >50</option>
								<option value="0.60" >60</option>
								<option value="0.70" >70</option>
								<option value="0.80" >80</option>
								<option value="0.90" >90</option>
								<option selected="selected"  value="1" >100</option>
							</select>	
							
			</div>
			
			<div class="shape-options toolbox"  style="display:inline-block;">
				<div class="vertical-line"></div>
				<input class='tool-color tool color' rel='fillStyle' type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" />
				<div class="vertical-line"></div>
				
						<i class="icon-opacity grey-6"></i>
								<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius">
								
								<option value="0" >0</option>
								<option value="0.10" >10</option>
								<option value="0.20" >20</option>
								<option value="0.30" >30</option>
								<option value="0.40" >40</option>
								<option value="0.50" >50</option>
								<option value="0.60" >60</option>
								<option value="0.70" >70</option>
								<option value="0.80" >80</option>
								<option value="0.90" >90</option>
								<option selected="selected"  value="1" >100</option>
							</select>	
					
				
			</div>
			<div class="generic-options toolbox float-left"  style="display:inline-block;">
			<!--	<a href="#" class="bck-dark-blue white toolbox-items radius" id="pop-align"><i class="icon-align-center size-20"></i></a> -->
				<a href="#" class="bck-dark-blue white toolbox-items radius responsive_2" id="pop-arrange"><i class="icon-send-backward size-15"></i></a>
			<!--	<a href="#" class="btn grey white radius">Grupla</a>    -->
			</div>
			
			<div class="generic-options responsive_1"  style="display:inline-block;">
				<a href="#" class="toolbox-items" id="pop-align"><i class="icon-align-center dark-blue size-20"></i></a>
				<div class="vertical-line responsive_2"></div>
				<a href="#" class="toolbox-items" id="generic-disable" ><i class="icon-lock size-25 dark-blue"></i></a>
				<a href="#" class="toolbox-items" id="generic-undisable" ><i class="icon-lock-open-alt size-25 dark-blue"></i></a>
				<div class="vertical-line responsive_2"></div>
				<a href="#" class="toolbox-items" id="generic-cut"><i class="icon-cut size-25 dark-blue"></i></a>
				<a href="#" class="toolbox-items" id="generic-copy"><i class="icon-copy size-25 dark-blue"></i></a>
				<a href="#" class="toolbox-items" id="generic-paste"><i class="icon-paste size-25 dark-blue"></i></a>

				
			</div>
				
			
			
			
			<span class="example btn white radius " data-dropdown="#dropdown-1">Diğer</span>
			<span class="example second_dropdown btn white radius" data-dropdown="#dropdown-2">Diğer</span>
			
			
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
  
	$(function() {
    $( "#tabss" ).tabs();
	});
		
	</script>
	
	
<!--  align popup -->	
<div class="popup" id="pop-align-popup">
<div class="popup-header">
Hizala
<div class="popup-close">x</div>
</div>
<!--  popup content -->
<div class="popup-inner-title">Dikey</div>
        <div class="popup-even">
                <i rel="component_alignment" action="vertical_align_left" class="toolbox-btn icon-align-left size-20 dark-blue"></i>
                <i rel="component_alignment" action="vertical_align_center" class="toolbox-btn icon-align-center size-20 dark-blue"></i>
                <i rel="component_alignment" action="vertical_align_right" class="toolbox-btn icon-align-right size-20 dark-blue"></i>
        </div>
        <div class="horizontal-line "></div>
        <div class="popup-inner-title">Yatay</div>
        <div class="popup-even">
                <i rel="component_alignment" action="horizontal_align_top" class="toolbox-btn icon-align-top size-20 dark-blue"></i>
                <i rel="component_alignment" action="horizontal_align_middle" class="toolbox-btn icon-align-middle size-20 dark-blue"></i>
                <i rel="component_alignment" action="horizontal_align_bottom" class="toolbox-btn icon-align-bottom size-20 dark-blue"></i>
        </div>
        <div class="horizontal-line "></div>
        <div class="popup-inner-title">Boşluklar</div>
        <div class="popup-even">
                <i rel="component_alignment" action="vertical_align_gaps" class="toolbox-btn icon-vertical-gaps size-20 dark-blue"></i>
                <i rel="component_alignment" action="horizontal_align_gaps" class="toolbox-btn icon-horizontal-gaps size-20 dark-blue"></i>
        </div>
<!--  popup content -->
</div>
<!-- end align popup -->

	
<!--  arrange popup -->

<div class="popup" id="pop-arrange-popup">
<div class="popup-header">
Katman
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<i rel='zindex' action='top' class="toolbox-btn icon-bring-front size-20 dark-blue"><a> En Üste Çıkart</a></i>
	<i rel='zindex' action='higher' class="toolbox-btn icon-bring-front-1 size-20 dark-blue"><a> Üste Çıkart</a></i>
	<div class="horizontal-line "></div>
	<i rel='zindex' action='lower' class="toolbox-btn icon-send-backward size-20 dark-blue"><a> Alta İndir</a></i>
	<i rel='zindex' action='bottom' class="toolbox-btn icon-send-back size-20 dark-blue"><a> En Alta İndir</a></i>
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

	
<!--  add sound popup -->	
<div class="popup" id="pop-sound-popup">
<div class="popup-header">
Ses Ekle
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<div style="clear:both"></div>
		<div class="add-image-drag-area"> </div>
		<input class="input-textbox" type="url" value="sesin adını yazınız">
		<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add sound popup -->		


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
<!--  end add video popup -->		
		
		

<!--  add galery popup -->	
<div class="popup" id="pop-galery-popup">
<div class="popup-header">
Galeri Ekle
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<div style="clear:both"></div>
			<div style="margin-bottom:20px;">
				<label class="dropdown-label" id="leading">
						Görsel Adedi:
							<select id="leading" class="radius">
								<option selected="" value="8"> 1 </option>
								<option value="0" >2</option>
								<option value="10" >3</option>
								<option value="20" >4</option>
								<option value="30" >5</option>
								<option value="40" >6</option>
								<option value="50" >7</option>
								<option value="60" >8</option>
								<option value="70" >9</option>
								<option value="80" >10</option>
							</select>	
					</label>
					
			</div>
			<div class="add-image-drag-area"> </div>
		<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add galery popup -->	

	
<!--  add quiz popup -->	
<div class="popup" id="pop-quiz-popup">
<div class="popup-header">
Quiz Ekle
<div class="popup-close">x</div>
</div>

<!-- popup content-->
	<div class="gallery-inner-holder">
		<label class="dropdown-label" id="leading">
				Şık Sayısı:
					<select id="leading" class="radius">
						<option value="0" >2</option>
						<option value="10" >3</option>
						<option selected="" value="20" >4</option>
						<option value="30" >5</option>
					</select>	
		</label> 
		</br>
		<label class="dropdown-label" id="leading">
				Doğru Cevap:
					<select id="leading" class="radius">
						<option value="0" >A</option>
						<option value="10" >B</option>
						<option selected="" value="20" >C</option>
						<option value="30" >D</option>
					</select>	
		</label> 

		</br></br>
		<div class="quiz-inner">
			Soru kökü:
			<form id="video-url">
			<textarea class="popup-text-area">Soru kökünü buraya yazınız.
			</textarea> </br>
			<!--burası çoğalıp azalacak-->
			1. Soru:
			<form id="video-url">
			<textarea class="popup-choices-area">
			</textarea> </br>
			
			2. Soru:
			<form id="video-url">
			<textarea class="popup-choices-area">
			</textarea> </br>
			
			3. Soru:
			<form id="video-url">
			<textarea class="popup-choices-area">
			</textarea> </br>
		</div>
		
		<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
		</form>
		
		
	</div>		
	
<!-- popup content-->
</div>	
<!--  end add quiz popup -->		
	
	
<!--  add popup popup -->	
<div class="popup" id="pop-popup-popup">
<div class="popup-header">
Açılır Kutu Ekle
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<textarea class="popup-text-area">Açılır kutunun içeriğini yazınız.
		</textarea> </br>
		<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add popup popup -->	
	
		
<!--  add chart popup -->	
<div class="popup" id="pop-chart-popup">
<div class="popup-header">
Grafik Ekle
<div class="popup-close">x</div>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		
			<label class="dropdown-label" id="leading">
							Grafik Çeşidi: 
								<select id="Graph Type" class="radius">
									<option selected="" value="8"> Pasta </option>
									<option value="80" >Çubuk</option>
								</select>	
			</label>
			<div class="pie-chart" >
			Dilim sayısı: 
				<input type="text" class="pie-chart-textbox radius grey-9 " value="1">
					<!-- yeni dilimler eklendikçe aşağıdaki div çoğalacak-->
					<div class="pie-chart-slice-holder">
						1. Dilim </br>
						%<input type="text" class="pie-chart-textbox radius grey-9 " value="1"></br>
						Etiket<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1">
						<input type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" />
					</div>
					<!-- dilim-->
					<div class="pie-chart-slice-holder">
						2. Dilim </br>
						%<input type="text" class="pie-chart-textbox radius grey-9 " value="1"></br>
						Etiket<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1">
						<input type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" />
						</div>
								
			</div>
			<div class="bar-chart" >
				<div class="pie-chart-slice-holder">
					X doğrusu adı: 
					<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1"></br>
					Y doğrusu adı: 
					<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1"></br>
					Sütun Sayısı: 	<input type="text" class="pie-chart-textbox radius grey-9 " value="1"></br>
				</div>
				<!--burası çoğaltılacak-->
				<div class="pie-chart-slice-holder">
					1. sütun adı: 
					<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1"></br>
					1. sütun değeri: 
					<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1"></br>
				</div>
				<!--end burası çoğaltılacak-->
				
				<!--burası çoğaltılacak-->
				<div class="pie-chart-slice-holder">
					2. sütun adı:
					<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1"></br>
					2. sütun değeri: 
					<input type="text" class="pie-chart-textbox-wide radius grey-9 " value="1"></br>
				</div>
				<!--end burası çoğaltılacak-->
					
			</div>
					
	<a href="#" class="btn bck-light-green white radius" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>		
	
<!-- popup content-->
</div>	
<!--  end add chart popup -->
		
<!--  shape popup -->	
<div class="popup" id="pop-shape-popup">
<div class="popup-header">
Şekil Ekle
<div class="popup-close">x</div>
</div>
<!--  popup content -->
</br>
	<div class="popup-even">
		<i class="icon-s-circle size-20 dark-blue"></i>
		<i class="icon-s-triangle size-20 dark-blue"></i>
		<i class="icon-s-square size-20 dark-blue"></i>
		<i class="icon-s-line size-20 dark-blue"></i>
	</div>
<!--  popup content -->
</div>
<!-- end align popup -->

		
		
		
		

<!-- popuplar -->
	
		
		
<div class='components' >
		<!--<div class="components-header">MEDYA</div>
		<a href="#" ctype="galery" class="radius component grey-9"><i class="icon-m-galery  size-20"></i> Galeri</a>
		<a href="#" ctype="text" class="radius component grey-9"><i class="icon-m-text size-20"></i> Text</a>
		<a href="#" ctype="sound" class="radius component grey-9"><i class="icon-m-sound size-20"></i> Ses</a>
		<a href="#" ctype="image" class="radius component grey-9"><i class="icon-m-image size-20"></i> Görsel</a>
			-->
		<ul class="component_holder">
		
			<li class="left_bar_titles"></li>
			
			<li ctype="image" class="component icon-m-image">&nbsp;&nbsp;&nbsp;&nbsp;Görsel</li>
			<li ctype="sound" class="component icon-m-sound">&nbsp;&nbsp;&nbsp;&nbsp;Ses</li>
			<li ctype="video" class="component icon-m-video">&nbsp;&nbsp;&nbsp;&nbsp;Video</li>
			
			<li class="left_bar_titles"></li>
			
			<li ctype="galery" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;Galeri</li>
			<li ctype="quiz"  class="component icon-m-quiz">&nbsp;&nbsp;&nbsp;&nbsp;Quiz</li>
			<li ctype="side-text"  class="component icon-m-listbox">&nbsp;&nbsp;&nbsp;&nbsp;Yazı Kutusu</li>
			<li ctype="link" class="component icon-m-link ui-draggable">&nbsp;&nbsp;&nbsp;&nbsp;Link</li>
			<li ctype="popup" class="component icon-m-popup">&nbsp;&nbsp;&nbsp;&nbsp;Pop-up</li>
			
			<li class="left_bar_titles"></li>

			<li ctype="text" class="component icon-m-text">&nbsp;&nbsp;&nbsp;&nbsp;Yazı</li>
			<li ctype="grafik" class="component icon-m-charts">&nbsp;&nbsp;&nbsp;&nbsp;Grafik</li>
			<li ctype="shape" class="component icon-m-shape">&nbsp;&nbsp;&nbsp;&nbsp;Şekil</li>
			<li ctype="table" class="component icon-t-merge">&nbsp;&nbsp;&nbsp;&nbsp;Tablo</li>
			
			
			<li class="left_bar_titles"></li>
		</ul>	
			
			
		
		<i class="icon-zoom grey-5" style="margin:5px;"></i>	<div id='zoom-pane' class="zoom" style="margin-top: 10px; max-width:150px;"></div>
		</br>
				
			
		
<!-- chat  -->
	<a class="chat_button"><i class="icon-chat-inv"></i><span class="text-visible">Yazışma</span></a>
		<div class="chat_window">
		
	<div class="chat_inline_holder">

<div class="chat_sent_messages">


</div>
<!-- chat_sent_messages SON -->



<div class="chat_text_box_holder">
<textarea placeholder="Mesajınızı yazın."></textarea>
<input type="submit" value="Gönder"> 
</div>
<!-- chat_text_box_holder SON -->
</div>
<!-- chat_inline_holder SON -->
		
		
		
		</div>
		<!-- chat_window END -->

<!-- chat  -->
		
		<script>
		$( ".chat_button" ).click(function() {
		$( ".chat_window" ).toggle();
		});
		</script>
		
		
		
	</div>
	
<div class="left_bar_shrink">
  <i class="icon-angle-left blue"></i>
</div>

		<script>
		$(".left_bar_shrink").click(function () {
		 $(".components").toggleClass('components-close');
		 $(".component").toggleClass('component-close');
		 $(".zoom").toggleClass('zoom-close');
		 $(".text-visible").toggleClass('text-hidden');
		 $(".chat_window").toggleClass('chat_window_close');
		 $(".left_bar_shrink").toggleClass('left_bar_shrink_close');
		 
		});
				
		</script>

	
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
<input type="text" class="chapter-title" placeholder="chapter title" value="<?php echo $chapter->title; ?>">
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
				$page_link = "/book/author/".$model->book_id.'/'.$pages->page_id;
				?> 
					
					<li class='page <?php echo ( $current_page->page_id== $pages->page_id  ? "current_page": "" ); ?>' chapter_id='<?php echo $pages->chapter_id; ?>' page_id='<?php echo $pages->page_id; ?>' chapter_id='<?php echo $pages->page_id; ?>'   >
						<a class="btn red white size-15 radius icon-delete page-chapter-delete delete-page hidden-delete "  style="top: 0px;right: 0px; position: absolute;"></a>
						<!--<a href='<?php echo $this->createUrl("book/author", array('bookId' => $model->book_id, 'page'=>$pages->page_id ));?>' >-->
							<a href='<?php echo "/book/author/".$model->book_id.'/'.$pages->page_id;?>'/>
								
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

	<?php 

	$template_links='';
	
	$data=json_decode($model->data,true);
	$template_id=$data["template_id"];
	
	$template_chapter=Chapter::model()->find( 'book_id=:book_id', array(':book_id' => $template_id )  );
	

	$template_pages=Page::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $template_chapter->chapter_id  ) ) );
	foreach ($template_pages as $template_page){
		$template_links .=  "<a href='?r=page/create&chapter_id=".$current_chapter->chapter_id."&pageTeplateId=".$template_page->page_id."' ><img src='".$template_page->data. "' ></a>";
	}

	?>	
$( "#add-button" ).hover(
  function() {


    $( this ).append( $(  "<span id='add-buttons' class='add-button-container'>\
 	<a id='add-page' class='add-button-cp white' href='?r=page/create&chapter_id=<?php echo $current_chapter->chapter_id; ?>'> Sayfa ekle </a>\
 	\
 	<a class='add-button-cp white' href='?r=chapter/create&book_id=<?php echo $model->book_id; ?>'> Bölüm ekle </a> \
 	<div class='add-button-page-template white' > <span>Sayfa Şablonları</span>  \
 	\
 	<?php echo $template_links; ?> \
 	\
 	</div> \
 	</span>" 

      	) );

 },
  
 function(){
			 $('#add-buttons').remove();
    }
   
);


</script>
		
</div>

<div id='author_pane_container' style=' width:100%'>
	<div id='author_pane' style='position:relative;width:1240px; margin: 0 auto; '> <!-- Outhor Pane -->
		
			<div class="hruler">
			<ul class="ruler" data-items="50"></ul>
			</div>
			
			<div class="vbruler">
			<ul class="vruler" data-items="38"></ul>
			</div>
			
			
			<script>
			$(function() {
    // Build "dynamic" rulers by adding items
    $(".ruler[data-items]").each(function() {
        var ruler = $(this).empty(),
            len = Number(ruler.attr("data-items")) || 0,
            item = $(document.createElement("li")),
            i;
        for (i = 0; i < len; i++) {
            ruler.append(item.clone().text(i + 1));
        }
    });
    // Change the spacing programatically
    function changeRulerSpacing(spacing) {
        $(".ruler").
          css("padding-right", spacing).
          find("li").
            css("padding-left", spacing);
    }
    
});
			</script>
			
			
			<script>
			$(function() {
    // Build "dynamic" rulers by adding items
    $(".vruler[data-items]").each(function() {
        var ruler = $(this).empty(),
            len = Number(ruler.attr("data-items")) || 0,
            item = $(document.createElement("li")),
			item2 = $(document.createElement("hr")),
            i;
        for (i = 0; i < len; i++) {
            ruler.append(item.clone().text(i + 1));
			ruler.append(item2.clone());
        }
    });
    // Change the spacing programatically
    function changeRulerSpacing(spacing) {
        $(".vruler").
          css("padding-right", spacing ).
          find("li").
            css("padding-left", spacing );
    }
    
});
			</script>
			
			
			
		<!-- ruler -->
		
		<div id='guide'> 
		</div> <!-- guide -->
<div id='editor_view_pane' style=' padding:5px 130px;margin: 10px 5px 5px 5px;float:left;'>

<?php
$book_data=json_decode($model->data,true);
$book_type=$book_data['book_type'];
if ($book_type=="pdf") {
	
	$page_data=json_decode($page->pdf_data,true);

	$img=$page_data['image']['data'];
}
$background= (!empty($img)) ? "background-image:url('".$img."')" : "background:white";
?>

					<div id='current_page' page_id='<?php echo $page->page_id ;?>' style="<?php echo $background; ?>;border:thin solid black;zoom:1; background-size:<?php echo $bookWidth; ?>px <?php echo $bookHeight; ?>px; height:<?php echo $bookHeight; ?>px;width:<?php echo $bookWidth; ?>px;position:relative"  >
						<div id="guide-h" class="guide"></div>
						<div id="guide-v" class="guide"></div>
					</div>
		</div><!-- editor_pane -->



	 
	</div> <!-- Outhor Pane -->
	<div style='float:right;clear:both;'>
		&nbsp;

	</div>
</div><!-- Outhor Pane Container -->


<div id="dropdown-1" class="dropdown dropdown-tip dropdown-anchor-right">
		<ul class="dropdown-menu">
			<div class="generic-options" style="display:inline-block;">
				<a href="#" class="toolbox-items" id="generic-cut"><i class="generic-cut icon-cut"></i></a>
				<a href="#" class="toolbox-items" id="generic-copy"><i class="generic-copy icon-copy"></i></a>
				<a href="#" class="toolbox-items" id="generic-paste"><i class="generic-paste icon-paste"></i></a>
				
				
				
			</div>
		</ul>
	</div>

	
<div id="dropdown-2" class="dropdown dropdown-tip dropdown-anchor-right">
		<ul class="dropdown-menu">
			<a href="#" class="bck-dark-blue white toolbox-items radius" id="pop-arrange"><i class="icon-send-backward size-15"></i></a>

<div class="generic-options" style="display:inline-block;">
				<a href="#" class="toolbox-items" id="generic-cut"><i class="generic-cut icon-cut"></i></a>
				<a href="#" class="toolbox-items" id="generic-copy"><i class="generic-copy icon-copy"></i></a>
				<a href="#" class="toolbox-items" id="generic-paste"><i class="generic-paste icon-paste"></i></a>
				
			</div>           
		</ul>
	</div>
