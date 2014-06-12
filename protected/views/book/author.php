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
			} else {
				$chapter=Chapter::model()->find('book_id=:book_id', array(':book_id' => $model->book_id ));
				$page=Page::model()->find('chapter_id=:chapter_id', array(':chapter_id' => $chapter->chapter_id ));
			}
 
		} 

$current_chapter=Chapter::model()->findByPk($page->chapter_id);
$current_page=Page::model()->findByPk($page->page_id);
$current_user=User::model()->findByPk(Yii::app()->user->id);

//$chapters_preview =Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" => array(':book_id' => $model->book_id )));
//echo CJSON::encode($chapters_preview);

//print_r($pagesChapter);
//$deneme = chapters_preview($model->book_id);
//echo $deneme[0];
//print_r($deneme);
//echo CJSON::encode($deneme[0]);
?>
 

<script type="text/javascript">




	window.lindneo.currentPageId='<?php echo $current_page->page_id; ?>';
	window.lindneo.currentBookId='<?php echo $model->book_id; ?>';
	//console.log(window.lindneo.currentBookId);
	window.lindneo.user={};
	window.lindneo.user.username='<?php echo Yii::app()->user->name; ?>';
	window.lindneo.user.name='<?php echo $current_user->name . " ". $current_user->surname; ?>';
	window.lindneo.tsimshian.connect();

	window.lindneo.highlightComponent='<?php echo $highlight_component->id; ?>';


	$(document).ready(function(){
	
		//$('#editor_view_pane').css({'margin-left':'200px'});
		var adaptive_width=$('.components').width()+50+"px";
		console.log(adaptive_width);
		$('#editor_view_pane').css({'margin-left':adaptive_width});
		options = {  
    reject : { // Rejection flags for specific browsers  
        all: false, // Covers Everything (Nothing blocked)  
        firefox:true, Webkit:true, konqueror:true, msie: true // Covers MSIE 5-6 (Blocked by default)  
        /* 
            * Possibilities are endless... 
            * 
            * // MSIE Flags (Global, 5-8) 
            * msie, msie5, msie6, msie7, msie8, 
            * // Firefox Flags (Global, 1-3) 
            * firefox, firefox1, firefox2, firefox3, 
            * // Konqueror Flags (Global, 1-3) 
            * konqueror, konqueror1, konqueror2, konqueror3, 
            * // Chrome Flags (Global, 1-4) 
            * chrome, chrome1, chrome2, chrome3, chrome4, 
            * // Safari Flags (Global, 1-4) 
            * safari, safari2, safari3, safari4, 
            * // Opera Flags (Global, 7-10) 
            * opera, opera7, opera8, opera9, opera10, 
            * // Rendering Engines (Gecko, Webkit, Trident, KHTML, Presto) 
            * gecko, webkit, trident, khtml, presto, 
            * // Operating Systems (Win, Mac, Linux, Solaris, iPhone) 
            * win, mac, linux, solaris, iphone, 
            * unknown // Unknown covers everything else 
            */  
    },  
    display: ['chrome','opera','msie','safari'], // What browsers to display and their order (default set below)  
    browserShow: true, // Should the browser options be shown?  
    browserInfo: { // Settings for which browsers to display    
        safari: {  
            text: 'Safari 7',  
            url: 'http://www.apple.com/safari/download/'  
        },  
        opera: {  
            text: 'Opera 21',  
            url: 'http://www.opera.com/download/'  
        },  
        chrome: {  
            text: 'Chrome 34',  
            url: 'http://www.google.com/chrome/'  
        },  
        msie: {  
            text: 'Internet Explorer 11',  
            url: 'http://www.microsoft.com/windows/Internet-explorer/'  
        },  
        gcf: {  
            text: 'Google Chrome Frame',  
            url: 'http://code.google.com/chrome/chromeframe/',  
            // This browser option will only be displayed for MSIE  
            allow: { all: false, msie: true }  
        }  
    },  
  
    // Header of pop-up window  
    header: '<?php echo __("Tarayıcınız, sistemle uyumlu değil!");?>',  
    // Paragraph 1  
    paragraph1:'<?php echo __("Tarayıcınız güncel olmayıp sistem tarafından kabul edilmiyor. Uyumlu tarayıcı listesi aşağıdadır.");?>',  
    // Paragraph 2  
    paragraph2: '<?php echo __("Uyumlu tarayıcılardan birini yüklemek için simgelerden birini tıklayınız.");?>',  
    close: true, // Allow closing of window  
    // Message displayed below closing link  
    closeMessage:'<?php echo __("Bu pencereyi kapatarak devam etmek, aldığınız hizmet kalitesinde ciddi bir etki yaratacaktır.");?>', 
    closeLink: 'Kapat', // Text for closing link  
    closeURL: '#', // Close URL  
    closeESC: true, // Allow closing of window with esc key  
  
    // If cookies should be used to remmember if the window was closed  
    // See cookieSettings for more options  
    closeCookie: true,  
    // Cookie settings are only used if closeCookie is true  
    cookieSettings: {  
        // Path for the cookie to be saved on  
        // Should be root domain in most cases  
        path: '/',  
        // Expiration Date (in seconds)  
        // 0 (default) means it ends with the current session  
        expires: 0  
    },  
  
    imagePath: '<?php echo Yii::app()->request->getBaseUrl(true); ?>/css/images/jreject/', // Path where images are located  
    overlayBgColor: '#000', // Background color for overlay  
    overlayOpacity: 0.8, // Background transparency (0-1)  
  
    // Fade in time on open ('slow','medium','fast' or integer in ms)  
    fadeInTime: 'fast',  
    // Fade out time on close ('slow','medium','fast' or integer in ms)  
    fadeOutTime: 'fast',  
  
    // Google Analytics Link Tracking (Optional)  
    // Set to true to enable  
    // Note: Analytics tracking code must be added separately  
    analytics: false  
};  

		 $.reject(options);

	});



</script>
	
<?php 
//echo $model->getFastStyle('p');
?>	
	
		
	

	
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
			         <li><a href="<?php echo $this->createUrl("EditorActions/ExportPdfBook", array('bookId' => $model->book_id ));?>"> <i class="icon-doc-inv"></i><?php _e("PDF Olarak Aktar"); ?></i></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/ExportBook", array('bookId' => $model->book_id ));?>"> <i class="icon-doc-inv"></i><?php _e("ePub Olarak Aktar"); ?></i></a></li>
			         <li><a href="<?php echo $this->createUrl("EditorActions/publishBook/", array('bookId' => $model->book_id ));?>"> <i class="icon-doc-inv"></i><?php _e("Markette Yayınla"); ?></i></a></li>
			         <li>
			         	<?php
			         		if ($budget==0) {
			         			
			         		}else{
			         	 ?>
			         	<a href="<?php echo $this->createUrl("EditorActions/ExportBook", array('bookId' => $model->book_id ));?>"><i class="icon-publish"></i><?php _e("Epub3 Olarak Aktar"); ?></a>
			         	<?php } ?>
			         </li>

					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>Düzenle</span></a>
			      <ul>
			         <li><a href='#' id="undo"><i class="undo icon-undo size-10"></i><span>&nbsp;&nbsp;&nbsp;Geri Al</span></a></li>
			         <li><a href='#' id="redo"><i class="redo icon-redo size-10"></i><span>&nbsp;&nbsp;&nbsp;İleri Al</span></a></li>

			         <li><a href='#' id="generic-cut"><i class="generic-cut icon-cut size-20"></i><span>Kes</span></a></li>
			         <li><a href='#' id="generic-copy"><i class="generic-copy icon-copy size-20"></i><span>Kopyala</span></a></li>
			         <li><a href='#' id="generic-paste"><i class="generic-paste icon-paste size-20"></i><span>Yapıştır</span></a></li>
			         <!--<li class='last'><a href='#'><span>Location</span></a></li>-->
			      </ul>
			   </li>

			   <li class='has-sub'><a href='#'><span><?php _e('Görünüm') ?> </span></a>
					<ul>
				     <li class="onoff"><a href='#'  ><input type="checkbox" name="cetvel" id="cetvelcheck" class="css-checkbox" /><label for="cetvelcheck" class="css-label"><?php _e('Cetvel') ?></label></a></li>
			         <li class="onoff"><a href='#'  ><input type="checkbox" name="rehber" id="rehbercheck" class="css-checkbox" /><label for="rehbercheck" class="css-label"><?php _e('Rehber') ?></label></a></li>
			         <li class="onoff"><a href='#'  ><input type="checkbox" name="grid" id="gridcheck" class="css-checkbox" /><label for="gridcheck" class="css-label"><?php _e('Grid') ?></label></a></li>
			         <!--<li class="onoff"><a href='#'  ><input type="checkbox" name="yorumlar" id="yorumlarcheck" class="css-checkbox" /><label for="yorumlarcheck" class="css-label"><?php _e('Yorumlar') ?></label></a></li>-->
			        </ul>
			   </li>
				
			    
			   <li><a href='#'>
			   
					<input type="text" id="searchn" name='component' class="search radius ui-autocomplete-input" placeholder="Ara" autocomplete="on">
			
			   <!--
			   <input type="text" id="searchn" name="component" style="display:none;" class="search radius ui-autocomplete-input" placeholder="Ara" autocomplete="on">
			   -->
			   <span id="search_btn">&nbsp;&nbsp;&nbsp;<i class="icon-zoom size-15"></i></span></a></li>
			  	
			   <li style="float:right; " class='has-sub'>
			  
					<a id='login_area' style='float:right;'>
						<?php
						if(Yii::app()->user->isGuest){
							echo CHtml::link(array('/site/login'));
						}else{
							echo CHtml::link('('.Yii::app()->user->name.')',array('/user/profile'));
						}
						?>
					</a>   
			      <ul>

			      	<?php if (!Yii::app()->user->isGuest) {?>
			         <li><a href='/user/profile'><span><?php _e('Profil') ?></span></a></li>
			         <?php echo " <li>". CHtml::link(__("Çıkış"),"/site/logout") ."</li>"; ?>
					<?php 
						// foreach (Yii::app()->params->availableLanguages  as $lang_id => $lang_name) {
						// 	$_GET['language']=$lang_id;
						// 	$lang_link_params = array_merge(array($this->route),$_GET ) ;

						// 	echo " <li>". CHtml::link("<span>".$lang_name."</span>",$lang_link_params ) ."</li>";

						// }
					?>
			         <?php } ?>
			      </ul>
			   </li>
			   <!--
			   <li>
			   	<a href="http://bekir.dev.lindneo.com/EditorActions/PreviewPage/<?php echo $current_page->page_id; ?> " class="fancybox">Preview</a>
			   </li>
			   -->
			   <li class="left-border" style="float:right; height: 42px; min-width:50px; text-align:center; padding-top: 5px; ">
			  <i id="save_status" class="size-30"></i>
			   </li>
			   <li style="float:right; ">	

			  		
			  		<div id="onlineUsers"></div>
			 	</li>
			</ul>
			<script>
			$("#search_btn").click(function(){
			$("#searchn").toggle();
			});
			
			</script>


			</div>
			<div class="styler_box dark-blue">
			<!-- <ul id="text-styles" ></ul> -->
            <div class="generic-options float-left"  style="display:inline-block; margin-right:5px;">

				<a class="optbtn " id="undo" ><i style="vertical-align: bottom;" class="undo icon-undo size-15 dark-blue" title="İleri" ></i></a>
				<a class="optbtn " id="redo" ><i style="vertical-align: bottom;" class="redo icon-redo size-15 dark-blue" title="Geri" ></i></a>
			
			</div>
			<div class="vertical-line responsive_2"></div>
						
			<div class="text-options wrap-options latex-options table-options toolbox" style="display:inline-block;">
					
					
					<input class='tool color' rel='color' type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" title="Yazı Rengi" />
				
					<select class='tool select' rel='fast-style' id="fast-style" class="radius" title="Başlık Tipi">
						<option value="">Serbest</option>
						<option value="h1" >Başlık</option>
						<option value="h2" >Alt Başlık</option>
						<option value="h3" >Başlık 1</option>
						<option value="h4" >Başlık 2</option>
						<option value="h5" >Başlık 3</option>
						<option value="h6" >Başlık 4</option>
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


				<!-- <input type='radio' rel='text-align' name='text-align' activeVal='justify' id="text-align-justify"  href="#" class="dark-blue radius toolbox-items  radio tool" ><label for='text-align-justify' class="icon-text-align-justify  size-15" title="İki Yana Yasla"></label -->


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
				
					
			</div>

			<div class="text-options wrap-options latex-options toolbox" style="display:inline-block;">

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

			<div class="plink-options toolbox" style="display:inline-block;">

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

			<div class="table-options toolbox" style="display:inline-block;">
					
				
					<a href="#" for="add_row" class="toolbox-btn optbtn tablesettings" rel="add_row" id="add_row" title="Satır Ekle"style="background-image: url(/css/images/addrow.png)"></a> 
					<a href="#" class="toolbox-btn optbtn tablesettings" rel="delete_row" id="delete_row" title="Satır Sil" style="background-image: url(/css/images/deleterow.png)"></a> 
					<a href="#" class="toolbox-btn optbtn tablesettings" rel="add_column" id="add_column" title="Sütun Ekle"style="background-image: url(/css/images/addcolumn.png)"></a> 
					<a href="#" class="toolbox-btn optbtn tablesettings" rel="delete_column" id="delete_column" title="Sütun Sil"style="background-image: url(/css/images/deletecolumn.png)"></a> 			
					
					<!--
					<input type="checkbox" id="delete_row" rel="delete_row" class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label for="delete_row" title="Satır Sil">Satır Sil</label>
					<input type="checkbox" id="delete_column" rel="delete_column" class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label for="delete_column" title="Satır Sil">Sütun Sil</label>
					<input type="checkbox" id="add_row" rel="add_row" class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label for="add_row" title="Satır Ekle">Satır Ekle</label>
					<input type="checkbox" id="add_column" rel="add_column" class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> 
					<label for="add_column" title="Satır Ekle">Sütun Ekle</label>
					-->
					<div class="vertical-line"></div>	
			</div>
 
				
				
			<div class="rtext-options toolbox" style="display:inline-block;">
					
					
					<input class='tool color' rel='color' type="color" class="color-picker-box radius " placeholder="e.g. #bbbbbb" title="Yazı Rengi" />
				
					<select class='tool select' rel='fast-style' id="fast-style" class="radius" title="Başlık Tipi">
						<option value="">Serbest</option>
						<option value="h1" >Başlık</option>
						<option value="h2" >Alt Başlık</option>
						<option value="h3" >Başlık 1</option>
						<option value="h4" >Başlık 2</option>
						<option value="h5" >Başlık 3</option>
						<option value="h6" >Başlık 4</option>
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
				<!--
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
					-->
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
			<div class="generic-options toolbox float-left"  style="display:inline-block;">
			<i class="icon-arrows-cw  grey-6" style="font-size:19px;"></i>
			<input type="text" id="rotate_val" class="tool text radius textboxes" rel='rotate' rel='color' value="0" style="width:50px;" title="Nesne Dönme Derecesi">
			<div class="vertical-line"></div>
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
<i class="icon-align-center"></i> Hizala <i id="align-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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

<div class="popup" id="pop-arrange-popup" style="left:750px;">
<div class="popup-header">
	<!--<i class="icon-arrange"></i>-->
	 Katman<i id="arrange-add-dummy-close-button" class="icon-close size-10" style="float:right; margin-right:10px; margin-top:5px;"></i>
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

<!--  add thumb popup -->	
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
<!--  end add thumb popup -->

	
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

<!--  add mquiz popup -->	
<div class="popup" id="pop-mquiz-popup">
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
<!--  end add mquiz popup -->		
	
	
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
		
			
			

			<!--
			<li ctype="slider" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Slider'); ?></li>
			<li ctype="thumb" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Öngörüntü Slider'); ?></li>
			<li ctype="tag" class="component icon-m-galery">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Etiket'); ?></li>
			-->
			
			<!--<li ctype="wrap" class="component icon-t-merge">&nbsp;&nbsp;&nbsp;&nbsp;<?php _e('Metin Sarma'); ?></li>-->
				<li ctype="text" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/text.png);"></li>
				<li ctype="side-text" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/slider.png);"></li>
				<li ctype="rtext" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/rtext.png);"></li>
				<li ctype="table" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/table.png);"></li>
				<li ctype="image" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/image.png);"></li>
				<li ctype="galery" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/galery.png);"></li>
				<li ctype="grafik" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/graphic.png);"></li>
				<li ctype="shape" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/shape.png);"></li>
				<li ctype="video" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/video.png);"></li>
				<li ctype="sound" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/audio.png);"></li>
				<li ctype="popup" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/popup.png);"></li>
				<li ctype="mquiz" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/quiz.png);"></li>
				<li ctype="html" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/html.png);"></li>
				<li ctype="latex" class="component" style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/latex.png);"></li>
				<li ctype="link" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/link.png);"></li>
				<li ctype="plink" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/pagelink.png);"></li>
				<li ctype="page" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/pagenumber.png);"></li>
				<!--<li ctype="quiz" class="component " style=" background-image: url(<?php echo Yii::app()->getBaseUrl(true);?>/css/images/components/<?php echo Yii::app()->language;?>/quiz.png);"></li>-->

		</ul>	
			
			
		<div class="clearfix"></div>
		
		<i class="icon-zoom grey-5" style="margin:5px;"></i>	
		<div id='zoom-pane' class="zoom" style="margin-top: 10px; max-width:150px;"></div>
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
		<!--
		<div class="left_bar_shrink">
		  <i class="icon-angle-left blue"></i>
		</div>
		<div class="left_bar_shrink_left">
		</div>
		-->
		
		
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
			console.log(position);
			$("#collapseThree").animate({scrollTop: position});
			console.log(document.getElementById('collapseThree').scrollTop);
			});
		</script>
		
		
	<!---- /shrinking buttons and scripts ---->
	

	
	
	
	
	
	
	
	
	
	
	
	<div id='chapters_pages_view' class="chapter-view" >
	
	<div class="btn fa fa-chevron-right right_bar_shrink_button" id="right_open">
	</div>
	<script>
	var position;
		$( "#right_open" ).click(function() {
			position=document.getElementById('collapseThree').scrollTop;
			console.log('position:'+position);
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
					<?php $coverImageSrc="/css/images/deneme_cover.jpg";
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
					<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThum"><i class="fa fa-edit light-blue"></i>&nbsp;&nbsp;&nbsp;<?php _e('Öngörüntü'); ?> </a> </h3>
				
				</div>
				 <div id="collapseThum" class="panel-collapse collapse">
				<div class="panel-body">
				<div style="position:relative;">  
					<a href="#box-thumbnail" data-toggle="modal">
					<?php $thumbnailImageSrc="/css/images/deneme_cover.jpg";
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
					<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseStyle"><i class="fa fa-bars light-blue"></i>&nbsp;&nbsp;&nbsp;<?php _e('Hızlı Stiller'); ?> </a> </h3>
				</div>
					<div id="collapseStyle" class="panel-collapse collapse">
						<div class="panel-body">
							<div id="fast_styles_main">
								<a class="btn component" href="#" id="fast_style2" component="h1" ><?php _e("Başlık"); ?></a><br>
								<a class="btn component" href="#" id="fast_style3" component="h2" ><?php _e("Alt Başlık"); ?></a><br>
								<a class="btn component" href="#" id="fast_style4" component="h3" ><?php _e("Başlık 1"); ?></a><br>
								<a class="btn component" href="#" id="fast_style4" component="h4" ><?php _e("Başlık 2"); ?></a><br>
								<a class="btn component" href="#" id="fast_style4" component="h5" ><?php _e("Başlık 3"); ?></a><br>
								<a class="btn component" href="#" id="fast_style4" component="h6" ><?php _e("Başlık 4"); ?></a><br>
								<a class="btn component" href="#" id="fast_style5" component="p" ><?php _e("Paragraf"); ?></a><br>
								<a class="btn component" href="#" id="fast_style6" component="blockqoute" ><?php _e("Alıntı"); ?></a>
							</div>
							<div id="fast_styles_edit">
								<h3 class="form-title" id="fast_styles_form_name">Styles</h3>
								<form class="form-horizontal" role="form">
									<div class="form-group">
									<label class="col-sm-3 control-label"><?php _e("Satır Yüksekliği"); ?>:</label>
										<div class="col-sm-9">
											<select class="form-control" id="fast_styles_line_height">
											  <option name="fast_styles_line_height" value="100">100</option>
											  <option name="fast_styles_line_height" value="125">125</option>
											  <option selected="" name="fast_styles_line_height" value="150">150</option>
											  <option name="fast_styles_line_height" value="175">175</option>
											  <option name="fast_styles_line_height" value="200">200</option>
											</select>
										</div>
								  </div>

								  <div class="form-group">
									<label class="col-sm-3 control-label"><?php _e("Yazı Tipi"); ?>:</label>
										<div class="col-sm-9">
											<select class="form-control" id="fast_styles_font_type">
											  	<option name="fast_styles_font_type" value="Arial"> Arial </option>
												<option name="fast_styles_font_type" value="SourceSansPro" >Source Sans Pro</option>
												<option name="fast_styles_font_type" value="AlexBrushRegular" >Alex Brush Regular</option>
												<option name="fast_styles_font_type" value="ChunkFiveRoman" >ChunkFive Roman</option>
												<option name="fast_styles_font_type" value="Aller" >Aller</option>
												<option name="fast_styles_font_type" value="Cantarell" >Cantarell</option>
												<option name="fast_styles_font_type" value="Exo" >Exo</option>
												<option name="fast_styles_font_type" value="helvetica" >Helvetica</option>
												<option name="fast_styles_font_type" value="Open Sans" >Open Sans</option>
												<option name="fast_styles_font_type" value="Times New Roman" >Times New Roman</option>
												<option name="fast_styles_font_type" value="georgia" >Georgia</option>
												<option name="fast_styles_font_type" value="Courier New" >Courier New</option>
											</select>
										</div>
								  </div>

								  <div class="form-group">
									<label class="col-sm-3 control-label"><?php _e("Yazı Boyutu"); ?>:</label>
										<div class="col-sm-9">
											<select class="form-control" id="fast_styles_font_size">
											  	<?php for ($font_size_counter=10; $font_size_counter<=250;$font_size_counter+=2){
													echo "<option name='fast_styles_font_size' value='{$font_size_counter}px' >{$font_size_counter}</option>";
												} ?>
											</select>
										</div>
								  </div>
									<div class="form-group">
										<div class="col-sm-12">
											<input type="checkbox" name="fast_styles_font_weight"  value="bold" class="dark-blue radius toolbox-items btn-checkbox tool checkbox"> <label class="icon-font-bold  size-15" for="font-bold" title="Yazı Kalınlaştırma"></label>
											<input type="checkbox" name="fast_styles_font_italic" value="italic" class="dark-blue radius toolbox-items btn-checkbox tool checkbox" > <label class="icon-font-italic size-15" for="font-italic" title="İtalik Yazı"></label>
											<input type="checkbox" name="fast_styles_text_decoration"  value="underline" class="dark-blue radius toolbox-items btn-checkbox tool checkbox" ><label class="icon-font-underline size-15" for="font-underline" title="Altı Çizili Yazı"></label>
 											<br><br>
										  	<input type='radio' name='fast_styles_text_align' value="left"  href="#" class="dark-blue radius toolbox-items radio tool" ><label for='text-align-left' class="icon-text-align-left size-15" title="Sola Yasla"></label>
											<input type='radio' name='fast_styles_text_align' value="center"  href="#" class="dark-blue radius toolbox-items  radio tool" ><label for='text-align-center' class="icon-text-align-center  size-15" title="Ortala"></label>
											<input type='radio' name='fast_styles_text_align' value="right"  href="#" class="dark-blue radius toolbox-items  radio tool" ><label for='text-align-right' class="icon-text-align-right  size-15" title="Sağa Yasla"></label>
										</div>
									</div>



								</form>
							</div>
							<div id="fast_styles_buttons">
								<a href="#" class="btn btn-inverse component" id="fast_style_back_button"><?php _e("Geri"); ?></a>
								<a href="#" class="btn btn-success component" id="fast_style_save_button"><?php _e("Kaydet"); ?></a>
							</div>
						</div>
					</div>
			</div>
			
			<script type="text/javascript">
				var main=$('#fast_styles_main');
				var edit=$('#fast_styles_edit');
				var buttons=$('#fast_styles_buttons');
			    var font_size='';
			    var font_family='';
			    var text_decoration='';
			    var font_weight='normal';
				var line_height='';
			    var text_align='';
			    var font_italic='';
			    var style='';
				edit.hide();
				buttons.hide();

				$("#fast_styles_main .btn").on("click",function() {
				    main.hide();
				    edit.show();
				    buttons.show();
				    var baslik=$(this).text();
				    style=$(this).attr('component');
				    $('#fast_styles_form_name').html(baslik);

				    $.ajax({
					  type: "POST",
					  data: {book_id: window.lindneo.currentBookId,component:style},
					  url: '/book/getFastStyle',
					}).done(function(res){
				    	var inDb=jQuery.parseJSON(res);
				    	console.log(inDb.font_size);

				    	font_size='';
						font_family='';
						text_decoration='';
						font_weight='';
						font_italic='';
						line_height='';
						text_align='';

				    	font_size=inDb.font_size;
						font_family=inDb.font_family;
						text_decoration=inDb.text_decoration;
						font_weight=inDb.font_weight;
						font_italic=inDb.font_italic;
						line_height=inDb.line_height;
						text_align=inDb.text_align;

				    	$("[name='fast_styles_font_size'][value='"+font_size+"']").attr("selected","selected");
						$("[name='fast_styles_font_type'][value='"+font_family+"']").attr("selected","selected");
						$("[name='fast_styles_line_height'][value='"+line_height+"']").attr("selected","selected");
						
						$("[name='fast_styles_text_decoration'][value='"+text_decoration+"']").attr("checked","checked");
						$("[name='fast_styles_font_weight'][value='"+font_weight+"']").attr("checked","checked");
						$("[name='fast_styles_font_italic'][value='"+font_italic+"']").attr("checked","checked")	
						$("[name='fast_styles_text_align'][value='"+text_align+"']").attr("checked","checked");
					});



				});




				// $('#fast_styles_line_height option').on("click",function(){
				// 	line_height=this.val();
				// 	console.log(this);
				// 	//$("[name='fast_styles_line_height']:")
				// });

				$('#fast_style_save_button').on("click",function(){
					font_size=$("[name='fast_styles_font_size']:checked").val();
					font_family=$("[name='fast_styles_font_type']:checked").val();
					text_decoration=$("[name='fast_styles_text_decoration']:checked").val();
					font_weight=$("[name='fast_styles_font_weight']:checked").val();
					font_italic=$("[name='fast_styles_font_italic']:checked").val();					
					line_height=$("[name='fast_styles_line_height']:checked").val();
					text_align=$("[name='fast_styles_text_align']:checked").val();
					
					var data=[];
					var name='';
					var value='';
					var item={};


					item['name']='book_id';
					item['value'] = window.lindneo.currentBookId;
					data.push(item);

					item={};
					item['name']='component_style';
					item['value'] = style;
					data.push(item);

					item={};
					item['name']='font_size';
					item['value'] = font_size;
					data.push(item);

					item={};
					item['name']='font_family';
					item['value'] = font_family;
					data.push(item);

					item={};
					item['name']='text_decoration';
					item['value'] = text_decoration;
					data.push(item);

					item={};
					item['name']='font_weight';
					item['value'] = font_weight;
					data.push(item);

					item={};
					item['name']='font_italic';
					item['value'] = font_italic;
					data.push(item);

					item={};
					item['name']='line_height';
					item['value'] = line_height;
					data.push(item);

					item={};
					item['name']='text_align';
					item['value'] = text_align;
					data.push(item);

					data=JSON.stringify(data);
					

					$.ajax({
					  type: "POST",
					  data: {styles: data},
					  url: '/book/fastStyle',
					}).done(function(res){
						
					});

					edit.hide();
					buttons.hide();
					main.show();
					font_size='';
				    font_family='';
				    text_decoration='';
				    font_weight='normal';
					line_height='';
				    text_align='';
				    font_italic='';
				    style='';
					
				});

				$('#fast_style_back_button').on("click",function(){
					edit.hide();
					buttons.hide();
					main.show();
					font_size='';
				    font_family='';
				    text_decoration='';
				    font_weight='normal';
					line_height='';
				    text_align='';
				    font_italic='';
				    style='';
				});


			</script>

			 
				
				
				
				<script>
					$(document).ready(function() {
						//console.log = function() {}
						$('#align-add-dummy-close-button').click(function() {
						/*	
				          $('#pop-align-popup').remove();

				          if ($('#pop-align-popup').length) {
				              $('#pop-align-popup').remove();
				          }
						*/
						$('#pop-align').click();
				      });

					$('#arrange-add-dummy-close-button').click(function() {
						/*
				          $('#pop-arrange-popup').remove();

				          if ($('#pop-arrange-popup').length) {
				              $('#pop-arrange-popup').remove();
				          }
						*/
						$('#pop-arrange').click();
				      });
					
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
					var maxheight = $( window ).height();
					$(".panel-collapse.collapse.in").css('max-height',maxheight-280);
					$(".panel-collapse.collapse.in").css('width','100%');
					$(".panel-collapse.collapse.in").css('overflow','auto');
					$( window ).resize(function() {
					  	maxheight = $( window ).height();
					  	$(".panel-collapse.collapse.in").css('max-height',maxheight-280);
					});
					$( ".modal" ).css('z-index','9999999999999');
				});
				</script>
			  <div class="panel panel-default">
				 <div class="panel-heading">
					<h3 class="panel-title"> <a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-file-text-o light-blue"></i>&nbsp;&nbsp;&nbsp;Sayfalar</a>
					<a data-toggle="modal" data-target="#addPage" class="btn btn-info pull-right clearfix" style="margin-top: -22px;" ><i class="fa fa-plus white"></i></a> </h3>

				 </div>
				 <div id="collapseThree" class="panel-collapse collapse in">

					<div class="panel-body">
						
						
						<!-- yeni butonlar gelmeden önce en altta olan zımbırtı -->
						<!--  <div id="add-button" class="bck-dark-blue size-25 icon-add white" style="position: fixed; bottom: 0px; right: 0px; width: 140px; text-align: center;"></div -->
						
						<script>

						<?php 

						$template_links='';
						
						$data=json_decode($model->data,true);
						$template_id=$data["template_id"];
						
						$template_chapter=Chapter::model()->find( 'book_id=:book_id', array(':book_id' => $template_id )  );
						

						$template_pages=Page::model()->findAll(array('order'=>  '`order` asc ,  created desc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $template_chapter->chapter_id  ) ) );
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
					
					
						

				
					
				</div>

			
				</div>
		
		</div>
		
		</div>
		</div>
		</div>
		
			  
	
</div>

<div id='author_pane_container' style=' width:100%'>
	<div id='author_pane' style='position:relative;margin: 0 auto; '> <!-- Outhor Pane -->
		
			<div class="hruler">
			<!--<ul class="ruler" data-items="54"></ul>-->
			<div class="ruler" style="width:100%;border-bottom: 3px dotted #000"></div>		
			</div>
			
			<div class="vbruler">
			<!--<ul class="vruler" data-items="34"></ul>-->
			<div class="vruler" style="height:100%;border-right: 2px dotted #000"></div>	
			</div>
			
			
			<script>


			$(function() {
    // Build "dynamic" rulers by adding items
    $(".ruler[data-items]").each(function() {
        var ruler = $(this).empty(),
            //len = Number(ruler.attr("data-items")) || 0,
            item = $(document.createElement("li"));
            var i;
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
<div id='editor_view_pane' style=' margin-top:30px;/*padding:5px 130px;margin: 10px 5px 5px 5px;*/float:left;'>

<?php
$book_data=json_decode($model->data,true);
$book_type=$book_data['book_type'];

if ($book_type=="pdf") {
	//echo $page->pdf_data;
	$page_data=json_decode($page->pdf_data,true);

	$img=$page_data['image']['data'];
	//$img=$page->pdf_data;
	
}
$background= (!empty($img)) ? "background-image:url('".str_replace(" ", "", $img)."')" : "background:white";
?>

					<div data-book-type='<?php echo $book_type;?>' id='current_page' page_id='<?php echo $page->page_id ;?>' style="<?php echo $background; ?>;border:thin solid rgb(146, 146, 146);zoom:1;
					-webkit-box-shadow: 1px 1px 5px 2px rgba(6, 34, 63, 0.63);
					-moz-box-shadow: 1px 1px 5px 2px rgba(6, 34, 63, 0.63);
					box-shadow: 1px 1px 5px 2px rgba(6, 34, 63, 0.63);
					background-size:<?php echo $bookWidth; ?>px <?php echo $bookHeight; ?>px;
					 height:<?php echo $bookHeight; ?>px;width:<?php echo $bookWidth; ?>px;position:relative"  >
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
	
<div class="modal fade add-page-modal" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
  <div class="modal-dialog ">
    <div class="modal-content ui-draggable">
	<script>
  $(function() {

    $( ".modal" ).css('z-index','9999999999999');
    $( "#addPage" ).css('z-index','9999999999999');
    $( "#box-thumbnail" ).css('z-index','9999999999999');
    $( "#box-cover" ).css('z-index','9999999999999');
    $( ".ui-draggable" ).draggable({ scroll: false,  snap: false, revert: false, refreshPositions: true});
   
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
						<li style="width:122px; height:92px; border: 1px solid rgb(55, 108, 150);">
							<a class="add-page-list-button" id="addBlankPage" style="width:110px; height:82px;">
								<div class="add-page-list-inside"> 
								Boş Sayfa Ekle </div>
							</a>
						</li>
						<?php 
						$data=json_decode($model->data,true);
						$template_id=$data["template_id"];
						$template_chapters=Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" =>array(':book_id' => $template_id  ) ) );
						foreach ($template_chapters as $key => $template_chapter) {
							$template_pages=Page::model()->findAll(array('order'=>  '`order` asc ,  created desc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $template_chapter->chapter_id  ) ) );
							foreach ($template_pages as $template_page){
								echo "<li class='page'  chapter_id='".$template_chapter->chapter_id."' page_id='".$template_page->page_id."' style='width:122px; height:92px; border: 1px solid rgb(55, 108, 150);'  >
								<canvas  class='pre_".$template_page->page_id."' style='height:90px; width:120px;'> </canvas>
								<a class='pre_".$template_page->page_id." copyBook' book-id='".$model->book_id."' chapter_id='".$current_chapter->chapter_id."' pageTeplateId='".$template_page->page_id."' href='#' ></a>
								</li>";
								?>
									<script type="text/javascript">

										window.lindneo.tlingit.loadAllPagesPreviews('<?php echo $template_id ?>');

										//window.lindneo.tlingit.loadPagesPreviews('<?php echo $template_page->page_id ?>');

									</script>
								<?php
							}
						}
						?>
						
					<ul>	
					

					
					</div>
				   <div class="tab-pane fade" id="tab_3_2">
					<ul class="add-page-list">
						<li class='page' style='width:122px; height:92px; border: 1px solid rgb(55, 108, 150);'>
							<a class="add-page-list-button" id='addBlankChapter' href='#' style="width:110px; height:82px;">
								<div class="add-page-list-inside">
								Bölüm Ekle </div>
							</a>
						</li>
						<?php 
						$data=json_decode($model->data,true);
						$template_id=$data["template_id"];
						$template_chapters=Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" =>array(':book_id' => $template_id  ) ) );
						foreach ($template_chapters as $key => $template_chapter) {
							$template_page=Page::model()->find(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $template_chapter->chapter_id  ) ) );
							echo "<li class='page'  chapter_id='".$template_chapter->chapter_id."' page_id='".$template_page->page_id."' style='width:122px; height:92px; border: 1px solid rgb(55, 108, 150);'  >
								<canvas  class='ch_".$template_page->page_id."' style='height:90px; width:120px;'> </canvas>
								<a class='ch_".$template_page->page_id." copyBook' book-id='".$model->book_id."' chapter_id='".$current_chapter->chapter_id."' pageTeplateId='".$template_page->page_id."' href='#' ></a>
								</li>";
							/*
							echo "<li onclick='event.stopPropagation();' class='page' chapter_id='".$template_chapter->chapter_id."' page_id='".$template_page->page_id."' >
									<canvas class='preview' height='90' width='120'></canvas>
									<a href='/page/create?book_id=".$model->book_id."&chapter_id=".$current_chapter->chapter_id."&pageTeplateId=".$template_page->page_id."' >Ekle</a>
								</li>";
							*/
								?>
									<script type="text/javascript">
									window.lindneo.tlingit.loadPagesPreviews('<?php echo $template_page->page_id ?>');
									</script>
								<?php
						}

						?>
						
					</ul>

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
		  <h4 class="modal-title"><?php _e('Öngörüntü resmi') ?></h4>
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
<!--
<div id="preview_page">
	Preview Sayfası buraya gelecek....
</div>
-->


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
