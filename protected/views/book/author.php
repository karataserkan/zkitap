<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $page page_id */

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
			   <li><a style="height:42px;" href="<?php echo $this->createUrl('site/index');  ?>"><img  src="/css/linden_logo.png" ></a></li>
			   <li><a contenteditable="true"> <?php echo $model->title; ?></a></li>
			   <li class='has-sub'><a href='#'><span>Dosya</span></a>
					<ul>
			         <li><a href="<?php echo $this->createUrl('site/index');  ?>"><span><i class="icon-book"></i>Kitaplarım</span></a></li>
			         <li><a href="<?php echo $this->createUrl('site/index');  ?>"><span><i class="icon-folder-open"></i>Pdf İçe Aktar </span></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/ExportPdfBook", array('bookId' => $model->book_id ));?>"> <i class="icon-doc-inv"></i>PDF Yayınla</i></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/publishBook/", array('bookId' => $model->book_id ));?>"> <i class="icon-doc-inv"></i><?php _e("Hızlı Yayınla"); ?></i></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/ExportBook", array('bookId' => $model->book_id ));?>"><i class="icon-publish"></i>Yayınla</a></li>
					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>Düzenle</span></a>
			      <ul>
			         <li><a href='#' id="undo"><i class="undo icon-undo size-10"></i><span>&nbsp;&nbsp;&nbsp;Geri Al</span></a></li>
			         <li><a href='#' id="redo"><i class="redo icon-redo size-10"></i><span>&nbsp;&nbsp;&nbsp;İleri Al</span></a></li>

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
			   
			   <li class="left-border" style="float:right; height: 42px; min-width:50px; text-align:center; padding-top: 5px; ">
			  <i id="save_status" class="size-30"></i>
			   </li>
			</ul>
			<script>
			$("#search_btn").click(function(){
			$("#searchn").toggle();
			})
			</script>


			</div>
			<div class="styler_box dark-blue">
			<!-- <ul id="text-styles" ></ul> -->
            <div class="generic-options float-left"  style="display:inline-block; margin-right:5px;">

				<a class="optbtn " id="undo" ><i style="vertical-align: bottom;" class="undo icon-undo size-15 dark-blue" title="İleri" ></i></a>
				<a class="optbtn " id="redo" ><i style="vertical-align: bottom;" class="redo icon-redo size-15 dark-blue" title="Geri" ></i></a>
			
			</div>
			<div class="vertical-line responsive_2"></div>
						
			<div class="text-options html-options table-options toolbox" style="display:inline-block;">
					
					
					<input class='tool color' rel='color' type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" title="Yazı Rengi" />
				
					<select class='tool select' rel='fast-style' id="fast-style" class="radius" title="Başlık Tipi">
						<option value="">Serbest</option>
						<option value="h1" >Başlık</option>
						<option value="h2" >Alt Başlık</option>
						<option value="h3" >Kucuk Başlık</option>
						<option value="p"  >Paragraf</option>
						<option value="blockqoute" >Alıntı</option>
					</select>

					<select class='tool select' rel='line-height' id="line-height" class="radius" title="Satır Boşluğu">
						<option value="100%">100</option>
						<option value="125%" >125</option>
						<option value="150%" >150</option>
						<option value="175%" >175</option>
						<option value="200%" >200</option>
					</select>
					
					<select class='tool select' rel='font-family' id="font-family" class="radius" title="Font Tipi">
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
				
					
					
						<select class='tool select' rel='font-size' id="font-size" class="radius" title="Yazı Boyutu">
						<option selected="" value="8px"> 8 </option>
						<?php for ($font_size_counter=10; $font_size_counter<=250;$font_size_counter+=2){
							echo "<option value='{$font_size_counter}px' >{$font_size_counter}</option>";
						} ?>


					</select>	
								
				<div class="vertical-line"></div>
				<div id="checkbox-container" style="display:inline-block">
					<input type="checkbox" id="font-bold" rel='font-weight' activeVal='bold' passiveVal='normal'  class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label class="icon-font-bold  size-15" for="font-bold" title="Yazı Kalınlaştırma"></label>
					<input type="checkbox" id="font-italic" rel='font-style' activeVal='italic' passiveVal='normal'  class="dark-blue radius toolbox-items btn-checkbox tool checkbox" > 
					<label class="icon-font-italic size-15" for="font-italic" title="İtalik Yazı"></label>
					<input type="checkbox" id="font-underline" rel='text-decoration' activeVal='underline' passiveVal='none'  class="dark-blue radius toolbox-items btn-checkbox tool checkbox" >
					<label class="icon-font-underline size-15" for="font-underline" title="Altı Çizili Yazı"></label>				</div>
 
				
				<div class="vertical-line"></div>

				<input type='radio' rel='text-align' name='text-align' activeVal='left' id="text-align-left"  href="#" class="dark-blue radius toolbox-items radio tool" ><label for='text-align-left' class="icon-text-align-left size-15" title="Sola Yasla"></label>
				<input type='radio' rel='text-align' name='text-align' activeVal='center' id="text-align-center"  href="#" class="dark-blue radius toolbox-items  radio tool" ><label for='text-align-center' class="icon-text-align-center  size-15" title="Ortala"></label>
				<input type='radio' rel='text-align' name='text-align' activeVal='right' id="text-align-right"  href="#" class="dark-blue radius toolbox-items  radio tool" ><label for='text-align-right' class="icon-text-align-right  size-15" title="Sağa Yasla"></label>

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
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius" title="Yazının Şeffaflık Ayarı">
								
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
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius" title="Resmin Şeffaflık Ayarı">
								
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
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius" title="Şeffaflık" title="Açılır Pencerenin Şeffaflık Ayarı">
								
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
							<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius" title="Bağlantının Şeffaflık Ayarı">
								
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

			<div class="wrap-options toolbox" style="display:inline-block;">
				<div class="vertical-line"></div>
				
						<i class="icon-opacity grey-6"></i>
							<select class='tool-select tool select' rel='cutoff' rel='color' id="font-size" class="radius" title="Bağlantının Şeffaflık Ayarı">
								
								<option selected="selected" value="" >0</option>
								<option value="10" >10</option>
								<option value="30" >30</option>
								<option value="50" >50</option>
								<option value="70" >70</option>
								<option value="100" >100</option>
								<option value="120" >120</option>
								<option value="150" >150</option>
								<option value="180" >180</option>
								<option value="200" >200</option>
							</select>	
							
			</div>
			
			<div class="shape-options toolbox"  style="display:inline-block;">
				<div class="vertical-line"></div>
				<input class='tool-color tool color' rel='fillStyle' type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" title="Şeklin Rengi" />
				<div class="vertical-line"></div>
				
						<i class="icon-opacity grey-6"></i>
								<select class='tool-select tool select' rel='opacity' rel='color' id="font-size" class="radius" title="Şeklin Şeffaflık Ayarı">
								
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
			<!--	<a href="#" class="bck-dark-blue white btn btn-default" id="pop-align"><i class="icon-align-center size-20"></i></a> -->

				<a href="#" class="optbtn" id="pop-arrange" ><i style="vertical-align:bottom; color:#2C6185;" class="icon-send-backward size-15" title="Sırasını Değiştir"></i></a>

			<!--	<a href="#" class="btn btn-info">Grupla</a>    -->
			</div>
			
			<div class="generic-options toolbox responsive_1"  style="display:inline-block;">
				<a href="#" class="optbtn " id="pop-align"><i class="icon-align-center size-20 dark-blue" title="Hizalama"></i></a>
				<div class="vertical-line responsive_2"></div>
				<a href="#" class="optbtn " id="generic-disable" ><i style="margin-top:2px;" class="fa fa-lock size-20 dark-blue" title="Kilitle"></i></a>
				<a href="#" class="optbtn " id="generic-undisable" ><i style="margin-top:2px;" class="fa fa-unlock-alt size-20 dark-blue" title="Kilidi Aç"></i></a>
				<div class="vertical-line responsive_2"></div>

				<a href="#" class="optbtn " id="generic-cut"><i class="generic-cut icon-cut size-25 dark-blue" title="Kes"></i></a>
				<a href="#" class="optbtn " id="generic-copy"><i class="generic-copy icon-copy size-25 dark-blue" title="Kopyala"></i></a>


				
				
			</div>

			<div class="generic-options copy-paste responsive_1"  style="display:none;">
				<a href="#" class="optbtn " id="generic-paste"><i class="generic-paste icon-paste size-25 dark-blue" title="Yapıştır"></i></a>
			</div>
			<!--<a class="btn btn-info pull-right "id="pages"><i class="fa fa-files-o"></i> Sayfalar</a>-->

			
			
			
			
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
<i class="icon-align-center"></i> Hizala <i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
	<i class="icon-arrange"></i>
		Katman
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
	<i class="icon-m-image"></i>
		Görsel Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<div style="clear:both"></div>
		<div class="add-image-drag-area"> </div>
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add image popup -->	

	
<!--  add sound popup -->	
<div class="popup" id="pop-sound-popup">
<div class="popup-header">
	<i class="icon-m-sound"></i>
		Ses Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<div style="clear:both"></div>
		<div class="add-image-drag-area"> </div>
		<input class="input-textbox" type="url" value="sesin adını yazınız">
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add sound popup -->		


<!--  add video popup -->	
<div class="popup" id="pop-video-popup">
<div class="popup-header">
	<i class="icon-m-video"></i>
		Video Ekle
	<i id='image-add-dummy-close-button' class='icon-close size-10 popup-close-button'></i>
</div>

<!-- popup content-->
	<div class="gallery-inner-holder">
		<form id="video-url">
		<input class="input-textbox" type="url" value="URL Adresini Giriniz">
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
		</form>
	</div>		
	
<!-- popup content-->
</div>	
<!--  end add video popup -->		
		
		

<!--  add galery popup -->	
<div class="popup" id="pop-galery-popup">
<div class="popup-header">
	<i class="icon-m-galery"></i>
		Galeri Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add galery popup -->	

<!--  add tag popup -->	
<div class="popup" id="pop-galery-popup">
<div class="popup-header">
	<i class="icon-m-galery"></i>
		Tag Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add galery popup -->	

<!--  add slider popup -->	
<div class="popup" id="pop-galery-popup">
<div class="popup-header">
	<i class="icon-m-galery"></i>
		Galeri Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add slider popup -->

	
<!--  add quiz popup -->	
<div class="popup" id="pop-quiz-popup">
<div class="popup-header">
	<i class="icon-m-quiz"></i>
		Quiz Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
	
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
		
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
		</form>
		
		
	</div>		
	
<!-- popup content-->
</div>	
<!--  end add quiz popup -->		
	
	
<!--  add popup popup -->	
<div class="popup" id="pop-html-popup">
<div class="popup-header">
	<i class="icon-m-popup"></i>
		Açılır Kutu Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<textarea class="popup-text-area">Açılır kutunun içeriğini yazınız.
		</textarea> </br>
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add popup popup -->	
<!--  add latex popup -->	
<div class="popup" id="pop-latex-popup">
<div class="popup-header">
	<i class="icon-m-popup"></i>
		Açılır Kutu Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<textarea class="popup-text-area">Açılır kutunun içeriğini yazınız.
		</textarea> </br>
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add popup popup -->	

<!--  add textwrap popup -->	
<div class="popup" id="pop-wrap-popup">
<div class="popup-header">
	<i class="icon-m-popup"></i>
		Açılır Kutu Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<textarea class="popup-text-area">Açılır kutunun içeriğini yazınız.
		</textarea> </br>
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add popup popup -->	

<!--  add popup popup -->	
<div class="popup" id="pop-popup-popup">
<div class="popup-header">
	<i class="icon-m-popup"></i>
		Açılır Kutu Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
</div>
<!-- popup content-->
	<div class="gallery-inner-holder">
		<textarea class="popup-text-area">Açılır kutunun içeriğini yazınız.
		</textarea> </br>
		<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>
<!-- popup content-->
</div>	
<!--  end add popup popup -->	
	
		
<!--  add chart popup -->	
<div class="popup" id="pop-chart-popup">
<div class="popup-header">
	<i class="icon-c-pie"></i>
		Grafik Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
					
	<a href="#" class="btn btn-info" id="add-image" style="padding: 5px 30px;">Ekle</a>
	</div>		
	
<!-- popup content-->
</div>	
<!--  end add chart popup -->
		
<!--  shape popup -->	
<div class="popup" id="pop-shape-popup">
<div class="popup-header">
	<i class="icon-s-square"></i>
		Şekil Ekle
	<i id="image-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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
		
			
			
			<li ctype="image" class="component icon-m-image">&nbsp;&nbsp;&nbsp;&nbsp;Görsel</li>
			<li ctype="sound" class="component icon-m-sound">&nbsp;&nbsp;&nbsp;&nbsp;Ses</li>
			<li ctype="video" class="component icon-m-video">&nbsp;&nbsp;&nbsp;&nbsp;Video</li>
			
			<li class="left_bar_titles"></li>
			
			<li ctype="galery" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;Galeri</li>
			<li ctype="slider" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;Slider</li>
			<li ctype="tag" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;Tag</li>
			<li ctype="quiz"  class="component icon-m-quiz">&nbsp;&nbsp;&nbsp;&nbsp;Quiz</li>
			<li ctype="side-text"  class="component icon-m-listbox">&nbsp;&nbsp;&nbsp;Yazı Kutusu</li>
			<li ctype="link" class="component icon-m-link ui-draggable">&nbsp;&nbsp;&nbsp;&nbsp;Link</li>
			<li ctype="popup" class="component icon-m-popup">&nbsp;&nbsp;&nbsp;&nbsp;Pop-up</li>
			
			<li class="left_bar_titles"></li>

			<li ctype="text" class="component icon-m-text">&nbsp;&nbsp;&nbsp;&nbsp;Yazı</li>
			<li ctype="grafik" class="component icon-m-charts">&nbsp;&nbsp;&nbsp;&nbsp;Grafik</li>
			<li ctype="shape" class="component icon-m-shape">&nbsp;&nbsp;&nbsp;&nbsp;Şekil</li>
			<li ctype="table" class="component icon-t-merge">&nbsp;&nbsp;&nbsp;&nbsp;Tablo</li>
			<li ctype="html" class="component icon-t-merge">&nbsp;&nbsp;&nbsp;&nbsp;HTML</li>
			<li ctype="latex" class="component icon-t-merge">&nbsp;&nbsp;&nbsp;&nbsp;Latex</li>
			<li ctype="wrap" class="component icon-t-merge">&nbsp;&nbsp;&nbsp;&nbsp;Text Wrap</li>
			
			
			<li class="left_bar_titles"></li>
		</ul>	
			
			
		
		<i class="icon-zoom grey-5" style="margin:5px;"></i>	<div id='zoom-pane' class="zoom" style="margin-top: 10px; max-width:150px;"></div>
		</br>
				
			
		
<!-- chat  -->
	<a class="chat_button"><i class="icon-chat-inv"></i><span class="text-visible">&nbsp;Yazışma</span></a>
		<div class="chat_window">
		
	<div class="chat_inline_holder">

<div class="chat_sent_messages">


</div>
<!-- chat_sent_messages SON -->



<div class="chat_text_box_holder">
<textarea placeholder="Mesajınızı yazın."></textarea>
<input type="submit"  value="gönder"> 
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
	
	<!---- shrinking buttons and scripts ---->
		<div class="left_bar_shrink">
		  <i class="icon-angle-left blue"></i>
		</div>
		<div class="left_bar_shrink_left">
		</div>
		
		
		
		<div style="display:none;" class="btn right_bar_shrink_button right_bar_shrink_button_closed" id="right_close" >
		<i class="fa fa-chevron-left"></i>
		Sayfalar
		</div>
			
	
		
		<script>
		$(".left_bar_shrink").click(function () {
		 $(".components").toggleClass( "components-close");
		 $(".component").toggleClass("component-close");
		 $(".zoom").toggleClass("zoom-close");
		 $(".text-visible").toggleClass("text-hidden");
		 $(".chat_window").toggleClass("chat_window_close");
		 $(".left_bar_shrink").toggleClass("left_bar_shrink_close");
		 $("ul.component_holder li").toggleClass("ul.component_holder_close");
		});
				
		</script>
		
		<script>
		$(".left_bar_shrink_left").click(function () {
		 $(".components").toggleClass( "components-close");
		 $(".component").toggleClass("component-close");
		 $(".zoom").toggleClass("zoom-close");
		 $(".text-visible").toggleClass("text-hidden");
		 $(".chat_window").toggleClass("chat_window_close");
		 $(".left_bar_shrink").toggleClass("left_bar_shrink_close");
		 $("ul.component_holder li").toggleClass("ul.component_holder_close");
		});
		</script>
		
		
		
		<script>
			$("#right_close").click(function() {
			$("#chapters_pages_view" ).toggle( "slide",{direction: "right"}, 100 );
			$( "#right_close" ).hide( "slide",{direction: "right"}, 100 );
			
			});
		</script>
		
		
	<!---- /shrinking buttons and scripts ---->
	

	
	
	
	
	
	
	
	
	
	
	
	<div id='chapters_pages_view' class="chapter-view" >
	
	<div class="btn fa fa-chevron-right right_bar_shrink_button" id="right_open">
	</div>
	<script>
		$( "#right_open" ).click(function() {
		$( "#chapters_pages_view" ).toggle( "slide",{direction: "right"}, 100 );
		$( "#right_close" ).show( "slide",{direction: "right"}, 100 );
		});
	</script>
	
	
	
			
		<div class="box-body">
			<div class="panel-group" id="accordion">
			
			 <div class="panel panel-default">
				 <div class="panel-heading">
					<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-edit light-blue"></i>&nbsp;&nbsp;&nbsp;Kapak Sayfası </a> </h3>
				
				</div>
				 <div id="collapseOne" class="panel-collapse collapse">
				<div class="panel-body">
				<div style="position:relative;">  
					<a href="#box-cover" data-toggle="modal">
					<?php $coverImageSrc="data:image/jpeg;base64,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";
					$bookData=json_decode($model->data,true);
					if (isset($bookData['cover'])) {
						$coverImageSrc=$bookData['cover'];
					}
					?>
					<img id='coverRel' src="<?php echo $coverImageSrc; ?>" 
					style="
					margin:20px;
					width:120px;
					border:3px solid #fff; " ></img>
					<i class="delete fa fa-pencil"></i></a>
					</div>
				
				</div>
				</div>
				</div>
				<div class="panel panel-default">
				 <div class="panel-heading">
					<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThum"><i class="fa fa-edit light-blue"></i>&nbsp;&nbsp;&nbsp;Thumbnail </a> </h3>
				
				</div>
				 <div id="collapseThum" class="panel-collapse collapse">
				<div class="panel-body">
				<div style="position:relative;">  
					<a href="#box-thumbnail" data-toggle="modal">
					<?php $thumbnailImageSrc="data:image/jpeg;base64,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";
					$bookData=json_decode($model->data,true);
					if (isset($bookData['thumbnail'])) {
						$thumbnailImageSrc=$bookData['thumbnail'];
					}
					?>	
					<img id="thumbRel" src="<?php echo $thumbnailImageSrc; ?>" 
					style="
					margin:20px;
					width:120px;
					border:3px solid #fff; " ></img>
					<i class="delete fa fa-pencil"></i></a>
					</div>
				
				</div>
				</div>
				</div>
			
			
			 <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-bars light-blue"></i>&nbsp;&nbsp;&nbsp;İçindekiler </a> </h3>
				</div>
					<div id="collapseTwo" class="panel-collapse collapse">
						<div class="panel-body">
							asdf
						</div>
					</div>
			</div>
				
				
				
				<script>
				$(document).ready(function() {
					var last_timeout;
					$('.pages .page').hover(
						function(){
							//console.log('hover started');
							var timeout;
							var page_thumb_item = $(this);

							//$(this).find('.page-chapter-delete').hide();
							timeout = setTimeout(function(){ 
								page_thumb_item.find('.page-chapter-delete').show();
								//console.log('hover-timeout');
								clearTimeout(timeout);
							},1000);

							setTimeout(function(){
								clearTimeout(timeout);
							},2000); 

							last_timeout = timeout;
							//console.log('hover-out');
							//setTimeout(function(){alert("OK");}, 3000);

					},	
					function(){
						//clearTimeout(my_timer);
						$(this).find('.page-chapter-delete').hide();
						if (last_timeout) clearTimeout(last_timeout);

					});
					$('.chapter-detail').hover(
						function(){
							console.log('hover started');
							var timeout;
							var page_thumb_item = $(this);

							//$(this).find('.page-chapter-delete').hide();
							timeout = setTimeout(function(){ 
								page_thumb_item.find('.page-chapter-delete').eq(0).show();
								console.log('hover-timeout');
								clearTimeout(timeout);
							},1000);

							setTimeout(function(){
								clearTimeout(timeout);
							},2000); 

							last_timeout = timeout;
							console.log('hover-out');
							//setTimeout(function(){alert("OK");}, 3000);

					},	
					function(){
						//clearTimeout(my_timer);
						$(this).find('.page-chapter-delete').hide();
						if (last_timeout) clearTimeout(last_timeout);

					});
				});
				</script>
			  <div class="panel panel-default">
				 <div class="panel-heading">
					<h3 class="panel-title"> <a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-file-text-o light-blue"></i>&nbsp;&nbsp;&nbsp;Sayfalar</a>
					<a data-toggle="modal" data-target="#addPage" class="btn btn-info pull-right clearfix" style="margin-top: -22px;" ><i class="fa fa-plus white"></i></a> </h3>

				 </div>
				 <div id="collapseThree" class="panel-collapse collapse in">

					<div class="panel-body">
						<?php 
						$page_NUM=0;

						$chapters=Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" => array(':book_id' => $model->book_id )));
						//print_r($chapters);
						foreach ($chapters as $key => $chapter) {
								
								$pagesOfChapter=Page::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $chapter->chapter_id )) );
										$chapter_page=0;
										?>
					<div class='chapter'  chapter_id='<?php echo $chapter->chapter_id; ?>'>
					<div class="chapter-detail">
					<input type="text" class="chapter-title" placeholder="chapter title" value="<?php echo $chapter->title; ?>">
					
					<a class="btn btn-danger  page-chapter-delete delete-chapter hidden-delete" style="float: right; margin-top: -23px;"><i class="icon-ok"></i></a> 
					<a class="page-chapter-delete_control hidden-delete" style="float: right; margin-top: -23px;"><i class="icon-delete"></i><i class="icon-delete"></i></a> 
					</div>
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
											<a class="btn btn-danger page-chapter-delete delete-page hidden-delete "  style="top: 0px;right: 0px; position: absolute;"><i class="icon-delete"></i></a>
											<!--<a href='<?php echo $this->createUrl("book/author", array('bookId' => $model->book_id, 'page'=>$pages->page_id ));?>' >-->
												<a href='<?php echo "/book/author/".$model->book_id.'/'.$pages->page_id;?>'/>
													
												<span class="page-number"><?php echo $page_NUM; ?></span>
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
						
						<!-- yeni butonlar gelmeden önce en altta olan zımbırtı -->
						<!--  <div id="add-button" class="bck-dark-blue size-25 icon-add white" style="position: fixed; bottom: 0px; right: 0px; width: 140px; text-align: center;"></div -->
						
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
						<a id='add-page' class='add-button-cp white' href='/page/create?book_id=<?php echo $model->book_id?>&chapter_id=<?php echo $current_chapter->chapter_id; ?>'> Sayfa ekle </a>\
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
					
					
					<a class="add-page-list-button" href='/page/create?book_id=<?php echo $model->book_id; ?>&chapter_id=<?php echo $current_chapter->chapter_id; ?>'>
					<div class="add-page-list-inside">
					Sayfa Ekle </div>
					</a>

					<a class="add-page-list-button" href='/chapter/create?book_id=<?php echo $model->book_id; ?>'>
					<div class="add-page-list-inside">
					Bölüm Ekle </div>
					</a>	

				
					
				</div>
			
				</div>
		
		</div>
		</div>
		</div>
		</div>
		
			
	
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
	//echo $page->pdf_data;
	$page_data=json_decode($page->pdf_data,true);

	$img=$page_data['image']['data'];
	//$img=$page->pdf_data;
	
}
$background= (!empty($img)) ? "background-image:url('".$img."')" : "background:white";
?>

					<div id='current_page' page_id='<?php echo $page->page_id ;?>' style="<?php echo $background; ?>;border:thin solid rgb(146, 146, 146);zoom:1;
					-webkit-box-shadow: 1px 1px 5px 2px rgba(6, 34, 63, 0.63);
					-moz-box-shadow: 1px 1px 5px 2px rgba(6, 34, 63, 0.63);
					box-shadow: 1px 1px 5px 2px rgba(6, 34, 63, 0.63); background-size:<?php echo $bookWidth; ?>px <?php echo $bookHeight; ?>px; height:<?php echo $bookHeight; ?>px;width:<?php echo $bookWidth; ?>px;position:relative"  >
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
			<a href="#"style="vertical-align: bottom;" class="toolbox-items " id="pop-arrange"><i class="icon-send-backward size-15"></i></a>

<div class="generic-options" style="display:inline-block;">
				<a href="#" class="toolbox-items" id="generic-cut"><i class="generic-cut icon-cut"></i></a>
				<a href="#" class="toolbox-items" id="generic-copy"><i class="generic-copy icon-copy"></i></a>
				<a href="#" class="toolbox-items" id="generic-paste"><i class="generic-paste icon-paste"></i></a>
				
			</div>           
		</ul>
	</div>
	
	
	
<!-- Page Modal -->
	
<div class="modal fade add-page-modal" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content ui-draggable">
	<script>
  $(function() {
    $( ".ui-draggable" ).draggable();
  });
  </script>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Sayfa Ekle</h4>
      </div>
      <div class="modal-body">
     
	 <!--
	 <div class="col-md-3" style="height:400px;">
	 <h5>Bölüm Girişi Taslağı</h5> 
	 <img href="#" src="/css/images/addchapter.png" style="width:110px;">
	
	 <h5>Sayfa Taslağı</h5>
	 <img href="#"src="/css/images/addpage.png" style="width:110px;">
	 
	-->
	<div class="panel panel-default">
		<div class="panel-body">
			 <div class="tabbable tabs-left">
				<ul class="nav nav-tabs"style="margin-top: -1px;">
				   <li class="active"><a href="#tab_3_1" data-toggle="tab"> 
				    <p>Sayfa Taslağı</p>
				   <img href="#"src="/css/images/addpage.png" style="cursor: initial; width:110px;"></a></li>
				   
				   <li class=""><a href="#tab_3_2" data-toggle="tab"> 
				   <p>Bölüm Giriş Sayfası</p>
				   <img href="#" src="/css/images/addchapter.png" style="cursor: initial; width:110px;"></a></li>
				
				</ul>
				<div class="tab-content">
				   <div class="tab-pane fade active in" id="tab_3_1">
					<ul class="add-page-list">
						<li ><img src="/css/images/template/klasik_1_400x300.jpg" ></li>
						<li ><img src="/css/images/template/klasik_2_400x300.jpg" ></li>
						<li ><img src="/css/images/template/klasik_3_400x300.jpg" ></li>
						<li ><img src="/css/images/template/klasik_4_400x300.jpg" ></li>
				
					<ul>	
					
					</div>
				   <div class="tab-pane fade" id="tab_3_2">
				
					</div>
				</div>
			 </div>
			</div>
		</div>
									
	
	 
	 
      </div>
	  <div class="clearfix"></div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog --> 
</div><!-- /.Page modal -->	
	


<!-- THUMBNAIL BOX CONFIGURATION MODAL FORM-->
<div class="modal fade" id="box-thumbnail" style="top:150px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e('Thumbnail Image') ?></h4>
		</div>
		<div class="modal-body">
			  <div class="upload-thmn-preview" id="upload-thmn-preview">

			</div>
			<input class="file-thm-up" name="logo" type="file"/>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Kapat') ?></button>
		  <button type="button" id="thumbnailSave" class="btn btn-primary"><?php _e('Kaydet') ?></button>
		</div>
	  </div>
	</div>
  </div>
<!-- /THUMBNAIL BOX CONFIGURATION MODAL FORM-->

<!-- COVER BOX CONFIGURATION MODAL FORM-->
<div class="modal fade" id="box-cover" style="top:150px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><?php _e('Kapak Resmi') ?></h4>
		</div>
		<div class="modal-body">
			  <div class="upload-cover-preview" id="upload-cover-preview">

			</div>
			<input class="file-cover-up" name="logo" type="file"/>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Kapat') ?></button>
		  <button type="button" id="coverSave" class="btn btn-primary"><?php _e('Kaydet') ?></button>
		</div>
	  </div>
	</div>
  </div>
<!-- /COVER BOX CONFIGURATION MODAL FORM-->

<script type="text/javascript">
	var preview = $("#upload-thmn-preview");
	var thm_base64;
	var cover_base64;
	var previewCover=$('#upload-cover-preview');
		
		$(".file-thm-up").change(function(event){
		   var input = $(event.currentTarget);
		   var file = input[0].files[0];
		   var reader = new FileReader();
		   reader.onload = function(e){
		       image_base64 = e.target.result;
		       thm_base64 = image_base64;
		       preview.html("<img src='"+image_base64+"'style=\"margin:20px; width:120px; border:3px solid #fff; \"/><br/>");
		   };
		   reader.readAsDataURL(file);
		  });

		$('#thumbnailSave').click(function(){
			if (thm_base64) {
				$.ajax({
						type: "POST",
                        data: { img: thm_base64},
                        url:'/book/updateThumbnail/'+window.lindneo.currentBookId,
                }).done(function(hmtl){
                	$('#thumbRel').attr('src',thm_base64);
                	$('#box-thumbnail').modal('toggle');
                });
			};
		});


		$(".file-cover-up").change(function(event){
		   var input = $(event.currentTarget);
		   var file = input[0].files[0];
		   var reader = new FileReader();
		   reader.onload = function(e){
		       cover_base64 = e.target.result;
		       previewCover.html("<img src='"+cover_base64+"'style=\"margin:20px; width:120px; border:3px solid #fff; \"/><br/>");
		   };
		   reader.readAsDataURL(file);
		  });

		$('#coverSave').click(function(){
			if (cover_base64) {
				$.ajax({
						type: "POST",
                        data: { img: cover_base64},
                        url:'/book/updateCover/'+window.lindneo.currentBookId,
                }).done(function(hmtl){
                	$("#coverRel").attr('src',cover_base64);
                	$('#box-cover').modal('toggle');
                });
			};
		});

</script>
