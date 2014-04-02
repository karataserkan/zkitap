<?php
class epub3 {
	

	public $tempdir='';
	public $tempdirParent='';
	public $files ;
	public $toc;
	public $chapters ;
	public $coverImage ;
	public $thumImage ;
	public $nicename;
	public $ebookFile ;
	public $title='';
	public $totalPageCount;
	public $TOC_Titles;
	public $uuid;
	public $coverType;
	public $thumType;
	public $errors=null;
	public $book ;

	public function error($domain='EditorActions',$explanation='Error', $arguments=null,$debug_vars=null ){
			$error=new error($domain,$explanation, $arguments,$debug_vars);
			$this->errors[]=$error; 
			return $error;
		}


	public function tempdir($dir=false,$prefix='epub3_export') {
	$tempfile=tempnam(sys_get_temp_dir(),'');

	if (file_exists($tempfile)) 
		{ unlink($tempfile); }

	mkdir($tempfile);

	if (is_dir($tempfile)) 
		{ 
			$this->tempdirParent=$tempfile;
			mkdir($tempfile.'/book');
			mkdir($tempfile.'/book/META-INF');
			return $tempfile.'/book'; 
		}

	}

	function get_tmp_file_path($filename){
		return $this->get_tmp_file(). "/" . $filename;

	}

	function get_tmp_file($with_slash=false){
		return $this->tempdir;
	}

	function create_MIMETYPE_File(){


		if(! $res[]=$this->files->mimetype=new file('mimetype',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-create_MIMETYPE_File','File could not be created');
			 }

		if(!$res[]=$this->files->mimetype->writeLine('application/epub+zip'))
			 {
			 	$this->errors[]=new error('Epub3-create_MIMETYPE_File','File could not be written');
			 }
		if(!$res[]=$this->files->mimetype->closeFile())
			 {
			 	$this->errors[]=new error('Epub3-create_MIMETYPE_File','File could not be closed');
			 }
		return $res;

	}

	public function createGenericFiles(){

			$latexComponents = Yii::app()->db->createCommand('SELECT COUNT( * ) as count FROM component LEFT JOIN page USING ( page_id )  LEFT JOIN chapter USING ( chapter_id ) LEFT JOIN book USING ( book_id ) WHERE TYPE =  "latex" AND book_id ="'.$this->book->book_id.'"')->queryRow();

			$genericFiles = new stdClass;
			error_log("count: ".$count);
			if($latexComponents['count']) { 
				$zip_url='/css/epubPublish/generic_latex.zip';
				$zip_file='generic_latex.zip';
			}
			else {
				$zip_url='/css/epubPublish/generic.zip';
				$zip_file='generic.zip';
			}

			$genericFiles->URL=Yii::app()->request->hostInfo . $zip_url;

			$genericFiles->filename=$zip_file;

			$genericFiles->contents=file_get_contents($genericFiles->URL);



			$this->files->genericFiles= new file( $genericFiles->filename, $this->get_tmp_file() );
			
			$this->files->genericFiles->writeLine($genericFiles->contents);

			$this->files->genericFiles->closeFile();

			$zip = new ZipArchive;

			$res[]= $result = $zip->open($this->files->genericFiles->filepath);
			if ($result === TRUE) {
				$res[]=$zip->extractTo( $this->get_tmp_file().'/' );

			 	$zip->close();
				unlink($this->files->genericFiles->filepath);
				unset($this->files->genericFiles);

			} else {
				$this->errors[]=new error('Epub3-createGenericFiles','File could not be unzipped created');
				


			}
			return $res;



	}


	public function createCssStyleSheets(){



			//page_styles.css 

			if(! $res[]=$this->files->styleSheets->page_style=new file('page_styles.css',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be created');
			 }

				$page_styles="
				body {
					border: 1px solid black;
					zoom: 1;
					color: #000;
					font-family: Arial;
					font-size: 14px;
					line-height: normal;
					}
";


			if(!$res[]=$this->files->styleSheets->page_style->writeLine($page_styles))
				 {
				 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be written');
				 }
			if(!$res[]=$this->files->styleSheets->page_style->closeFile())
				 {
				 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be closed');
				 }


			//stylesheet.css

			if(! $res[]=$this->files->styleSheets->stylesheet=new file('stylesheet.css',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be created');
			 }

				$stylesheet="
				@page {
				  margin-bottom: 5pt;
				  margin-top: 5pt
				}
				";


			if(!$res[]=$this->files->styleSheets->stylesheet->writeLine($stylesheet))
				 {
				 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be written');
				 }
			if(!$res[]=$this->files->styleSheets->stylesheet->closeFile())
				 {
				 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be closed');
				 }

				return $res;







	}

	public function copyCoverImage(){

		$cover64=$this->book->getData('cover');

		if ($cover64) {
			$ext1=explode(';', $cover64);
			$ext2=explode('/', $ext1[0]);
			$extension = '.'.$ext2[1];
			$this->coverType=$ext2[1];
			$this->coverImage = functions::save_base64_file ( $cover64 , "cover" , $this->get_tmp_file());
			$this->coverImage->URL=$this->get_tmp_file(). '/cover'.$extension;
			$this->coverImage->filename='cover'.$extension;
		}
		else
		{
			$this->coverType='jpeg';
			$this->coverImage->URL=Yii::app()->request->hostInfo . '/css/cover.jpg';
			$this->coverImage->filename='cover.jpg';
		}


		$image_file_contents=file_get_contents($this->coverImage ->URL);

		$this->files->coverImage= new file( $this->coverImage->filename, $this->get_tmp_file() );
		
		$this->files->coverImage->writeLine($image_file_contents);

		$this->files->coverImage->closeFile();


		
		

		if(! $res[]=  $this->coverImage ){
			$this->errors[]=new error('Epub3-copyCoverImage','File could not be copied',__DIR__ . '/' . $this->coverImage,$this->get_tmp_file_path($this->coverImage));
		}

		return $res;

	}	

	public function copyThumImage(){

		$thum64=$this->book->getData('thumbnail');

		if ($thum64) {
			$ext1=explode(';', $thum64);
			$ext2=explode('/', $ext1[0]);
			$extension = '.'.$ext2[1];
			$this->thumType=$ext2[1];
			$this->thumImage = functions::save_base64_file ( $thum64 , "thumbnail" , $this->get_tmp_file());
			$this->thumImage->URL=$this->get_tmp_file(). '/thumbnail'.$extension;
			$this->thumImage->filename='thumbnail'.$extension;
		}
		else
		{
			$this->thumType='jpeg';
			$this->thumImage->URL=Yii::app()->request->hostInfo . '/css/cover.jpg';
			$this->thumImage->filename='cover.jpg';
		}


		$image_file_contents=file_get_contents($this->thumImage ->URL);

		$this->files->thumImage= new file( $this->thumImage->filename, $this->get_tmp_file() );
		
		$this->files->thumImage->writeLine($image_file_contents);

		$this->files->thumImage->closeFile();


		
		

		if(! $res[]=  $this->thumImage ){
			$this->errors[]=new error('Epub3-copythumImage','File could not be copied',__DIR__ . '/' . $this->thumImage,$this->get_tmp_file_path($this->thumImage));
		}

		return $res;

	}


	public function create_title_page(){
		$bookSize=$this->book->getPageSize();
		$width=$bookSize['width']?$bookSize['width']:"1024";
		$height=$bookSize['height']?$bookSize['height']:"768";
		
	

			//create_title_page

			if(! $res[]=$this->files->titlepage=new file('titlepage.xhtml',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be created');
			 }
			 $pageSize=$this->book->getPageSize();
			
				$title_page=
'<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" lang="en">
  <head>
    <meta http-equiv="default-style" content="text/html; charset=utf-8"/>
    	<title>'.$this->book->title.'</title>
    	<link rel="stylesheet" href="stylesheet.css" type="text/css"/>
		<link rel="stylesheet" href="page_styles.css" type="text/css"/>
		<link rel="stylesheet" href="widgets.css" type="text/css"/>

		<meta name="viewport" content="width='.$pageSize['width'].', height='.$pageSize['height'].'"/>

		
	</head>
	<body>
		<div>
			<img width="'.$pageSize['width'].'" height="'.$pageSize['height'].'" src="' . $this->coverImage->filename . '"/>
		</div>

		<script>
		  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,"script","//www.google-analytics.com/analytics.js","ga");

		  ga("create", "UA-16931314-17", "lindneo.com");
		  ga("send", "pageview");

		</script>

	</body>
</html>';


			if(!$res[]=$this->files->titlepage->writeLine($title_page))	
				 {
				 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be written');
				 }
			if(!$res[]=$this->files->titlepage->closeFile())
				 {
				 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be closed');
				 }
			return $res;


	}


	public function prepareBookStructure(){

		$chapterModels = Chapter::model()->findAll( 
			array('order'=>  '`order` asc ,  created asc', 
				"condition"=>'book_id=:book_id', "params" => array(':book_id' => $this->book->book_id )
				));

		$this->totalPageCount=0;

		foreach ($chapterModels as $key => $chapter) {

			$chapter_page_counts=0;

			$new_chapter=(object)$chapter->attributes;

			
			$pagesOfChapter=Page::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $chapter->chapter_id )) );
			
			if(count($pagesOfChapter)>0){
				foreach ($pagesOfChapter as $key => $page) {

					$new_page=(object)$page->attributes;

					$this->files->pages[]=$new_page->file=new file($new_page->page_id . '.html', $this->get_tmp_file() );



					if($chapter_page_counts==0){
						$new_toc_item->title=$chapter->title;
						$new_toc_item->page=$new_page->file->filename;
						$new_toc_item->anchor='';


						$this->toc[]=$new_toc_item;
						unset($new_toc_item);
					}

					$components=(object)EditorActionsController::get_page_components($page->page_id);
					if($components){
						$new_page->components=$components;
					}
					//print_r(EditorActionsController::get_page_components($page->page_id));
					$new_page->file->writeLine($this->prepare_PageHtml($new_page,$this->book->getPageSize(),$this->get_tmp_file()  ));

					$new_chapter->pages[]=$new_page;

					unset($new_page);
					$this->totalPageCount++;

					$chapter_page_counts++;
				}

			$this->chapters[]=$new_chapter;
			}
			unset($new_chapter);

		}


	}

	public function prepare_PageHtml(&$page,$bookSize,$folder){
		$page_data=json_decode($page->pdf_data,true);
		if (isset($page_data['image']['data'])&& !empty($page_data['image']['data'])) {
			$img=$page_data['image']['data'];
			$backgroundfile = functions::save_base64_file ( $img , 'bg'.$page->page_id , $this->get_tmp_file());

			//$bookSize=$page_data['image']['size'];
		}
		$background= (isset($img)&&!empty($img)) ? "background-image:url('".$backgroundfile->filename."')" : "background:transparent";
		$background_size=(isset($bookSize)&&!empty($bookSize)) ? "background-size:".$bookSize['width']."px ".$bookSize['height']."px":"";
		
		$width="1024";
		$height="768";
		if ($background_size) {
			$width=$bookSize['width'];
			$height=$bookSize['height'];
		}

		//$bookSize=array('width'=>'768','height'=>'1024');
		//$page->getPageSize();

		$components_html='';
		$page_styles='';
		$page_structure=
'<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" lang="en">
  <head>
    <meta http-equiv="default-style" content="text/html; charset=utf-8"/>
<<<<<<< HEAD
    <title></title>

=======
>>>>>>> adcd895ca68fea3bfa065fd4ea323c3718d1838d
		<meta name="viewport" content="width='.$width.', height='.$height.'"/>




		<link rel="stylesheet" href="stylesheet.css" type="text/css"/>
		<link rel="stylesheet" href="page_styles.css" type="text/css"/>
		<link rel="stylesheet" href="widgets.css" type="text/css"/>
		<script type="text/javascript" src="jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="aie_core.js"></script>
		<script type="text/javascript" src="aie_events.js"></script>
		<script type="text/javascript" src="aie_explore.js"></script>
		<script type="text/javascript" src="aie_gameutils.js"></script>
		<script type="text/javascript" src="aie_qaa.js"></script>
		<script type="text/javascript" src="aie_storyline.js"></script>
		<script type="text/javascript" src="aie_textsound.js"></script>
		<script type="text/javascript" src="igp_audio.js"></script>
		<script type="text/javascript" src="iscroll.js"></script>
		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript" src="jquery-ui.min.js"></script>
		<script type="text/javascript" src="LAB.min.js"></script>
		<script type="text/javascript" src="panelnav.js"></script>
		<script type="text/javascript" src="popup.js"></script>
		<script type="text/javascript" src="pubsub.js"></script>
		<script type="text/javascript" src="Chart.js"></script>
		<script type="text/javascript" src="jquery.slickwrap.js"></script>
		<script type="text/javascript" src="jssor.slider.js"></script>
		<script type="text/javascript" src="jssor.core.js"></script>
		<script type="text/javascript" src="jssor.utils.js"></script>
		<script type="text/javascript" src="runtime.js"></script>
		<!-- MULTİPLE CHOİCE -->
		<script src="multiplechoice/sources/js/MultipleChoiceDataJSON.js"></script>
		<script src="multiplechoice/sources/js/multiplechoice_min.js"></script>
		<link rel="stylesheet" type="text/css" href="multiplechoice/sources/css/MultipleChoice.css" />

		<!-- DROPDOWN -->
		<script src="dropdown/sources/js/DropDownDataJSON.js"></script>
		<script src="dropdown/sources/js/dropdown-mini.js"></script>
		<link rel="stylesheet" type="text/css" href="dropdown/sources/css/DropDown.css" />

		<!-- DRAGDROP-->
		<script type="text/javascript" src="dragdrop/sources/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="dragdrop/sources/js/jquery.ui.touch-punch.min.js"></script>
		<script type="text/javascript" src="dragdrop/sources/js/DragDrop.js"></script>
		<link rel="stylesheet" type="text/css" href="dragdrop/sources/css/DragDrop.css" />

		<script type="text/x-mathjax-config">
		  MathJax.Hub.Config({
			tex2jax: {
			  inlineMath: [["$","$"],["\\\\(","\\\\)"]],
			  "HTML-CSS": { scale: 100} 
			}
		  });
		  MathJax.Hub.Register.StartupHook("HTML-CSS Jax Ready",function () {
		  var VARIANT = MathJax.OutputJax["HTML-CSS"].FONTDATA.VARIANT;
		  VARIANT["normal"].fonts.unshift("MathJax_Arial");
		  VARIANT["bold"].fonts.unshift("MathJax_Arial-bold");
		  VARIANT["italic"].fonts.unshift("MathJax_Arial-italic");
		  VARIANT["-tex-mathit"].fonts.unshift("MathJax_Arial-italic");
		});
		MathJax.Hub.Register.StartupHook("SVG Jax Ready",function () {
		  var VARIANT = MathJax.OutputJax.SVG.FONTDATA.VARIANT;
		  VARIANT["normal"].fonts.unshift("MathJax_SansSerif");
		  VARIANT["bold"].fonts.unshift("MathJax_SansSerif-bold");
		  VARIANT["italic"].fonts.unshift("MathJax_SansSerif-italic");
		  VARIANT["-tex-mathit"].fonts.unshift("MathJax_SansSerif-italic");
		});
		MathJax.Hub.Register.StartupHook("End",function () {
		  $(".MathJax").css("font-size","93%");
		  $(".textarea .MathJax").css("font-size","80%");
		});
		</script>
		<script src="mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

		<script type="text/javascript" src="fancy/lib/jquery.mousewheel-3.0.6.pack.js"></script>
		<script type="text/javascript" src="fancy/source/jquery.fancybox.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />
		<link rel="stylesheet" type="text/css" href="fancy/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
		<script type="text/javascript" src="fancy/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<link rel="stylesheet" type="text/css" href="fancy/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="fancy/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
		<script type="text/javascript" src="fancy/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
		<script type="text/javascript">
		$(document).ready(function() {

		$(".fancybox").fancybox();

		});
		</script>
		<style type="text/css">
		.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
		}
		body {
		max-width: 700px;
		margin: 0 auto;
		}
		</style>

	</head>
	<body style="background-repeat:no-repeat; width:'.$width.'px; height:'.$height.'px;'.$background.';'.$background_size.';">
	<section epub:type="frontmatter titlepage">
	%components%
	</section>
		<script>
		  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,"script","//www.google-analytics.com/analytics.js","ga");
		  ga("create", "UA-16931314-17", "lindneo.com");
		  ga("send", "pageview");
		</script>
	</body>
</html>';

		foreach ($page->components as $component){
			set_time_limit(100);
			$component=(object)$component;
			$component->html=new componentHTML($component, $this, $folder);
			$components_html.=$component->html->html;
		}
		$page_file_inside=str_replace(array(
			'%components%','%style%'
			), array($components_html,$page_styles), $page_structure);

		return $page_file_inside;

	}

	//creates Toc for EPUB3 readers
	public function createTOCNav()
	{
		if(! $res[]=$this->files->TOC=new file('toc.xhtml',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createTOCNav','File could not be created');
			 }

		 $TOC_Html=
				'<?xml version="1.0" encoding="UTF-8"?>
				<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:epub="http://www.idpf.org/2007/ops">
				    <head>
				            <meta charset="utf-8"></meta>
				    </head>
					<body>
				        <nav epub:type="toc" id="toc">                  
				            <ol>
				        		%navPoints%
				    		</ol>
						</nav>
					</body>
				</html>';


				$toc_items="";

				foreach ($this->toc as $key => $toc) {
					$toc_items.='<li><a href="'. $toc->page . ( $toc->anchor!="" ? '#'. $toc->anchor : "" ) .'">'.$toc->title.'</a></li>';
				}
				
			$TOC_Html=str_replace('%navPoints%', $toc_items, $TOC_Html);


			if(!$res[]=$this->files->TOC->writeLine($TOC_Html))	
				 {
				 	$this->errors[]=new error('Epub3-createTOCNav','File could not be written');
				 }
			if(!$res[]=$this->files->TOC->closeFile())
				 {
				 	$this->errors[]=new error('Epub3-createTOCNav','File could not be closed');
				 }

			return $res;
	}

	public function createTOC(){
	//Create TOC

			if(! $res[]=$this->files->TOC=new file('toc.ncx',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createTOC','File could not be created');
			 }

				$TOC_Html=
					'<?xml version="1.0" encoding="utf-8"?>
					<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1" xml:lang="eng">
						<head>
							<meta content="urn:'.$this->uuid.'" name="dtb:uid"/>
							<meta content="2" name="dtb:depth"/>
							<meta content="calibre (0.8.68)" name="dtb:generator"/>
							<meta content="'.$this->totalPageCount.'" name="dtb:totalPageCount"/>
							<meta content="'.$this->totalPageCount.'" name="dtb:maxPageNumber"/>
						</head>
						<docTitle>
							<text>'.$this->book->title.'</text>
						</docTitle>
						<navMap>
					%navPoints%
						</navMap>
					</ncx>';


				$toc_items="";
				$index_referance=1;
				foreach ($this->toc as $key => $toc) {
					$this->TOC_Titles[$toc->anchor]=$toc->title;
					$toc_items.=
						'		<navPoint id="a'. ($index_referance+1) .'" playOrder="'. $index_referance .'">
									<navLabel>
										<text>'.$toc->title.'</text>
									</navLabel>
									<content src="'. $toc->page . ( $toc->anchor!="" ? '#'. $toc->anchor : "" ) .'" />
								</navPoint>
						';
					$index_referance++;

				}
				
			$TOC_Html=str_replace('%navPoints%', $toc_items, $TOC_Html);


			if(!$res[]=$this->files->TOC->writeLine($TOC_Html))	
				 {
				 	$this->errors[]=new error('Epub3-createTOC','File could not be written');
				 }
			if(!$res[]=$this->files->TOC->closeFile())
				 {
				 	$this->errors[]=new error('Epub3-createTOC','File could not be closed');
				 }

			return $res;
	}


	public function containerXML(){
		

		//containerXML

		if(! $res[]=$this->files->containerXML=new file('container.xml',$this->get_tmp_file().'/META-INF') )
		 {
		 	$this->errors[]=new error('Epub3-containerXML','File could not be created');
		 }

			$containerXML_inside=
'<?xml version="1.0" encoding="UTF-8" ?>
<container version="1.0" xmlns="urn:oasis:names:tc:opendocument:xmlns:container">
   <rootfiles>
      <rootfile full-path="package.opf" media-type="application/oebps-package+xml"/>
   </rootfiles>
</container>';


		if(!$res[]=$this->files->containerXML->writeLine($containerXML_inside))	
			 {
			 	$this->errors[]=new error('Epub3-containerXML','File could not be written');
			 }
		if(!$res[]=$this->files->containerXML->closeFile())
			 {
			 	$this->errors[]=new error('Epub3-containerXML','File could not be closed');
			 }
		return $res;


	}

	public function contentOPF(){
		
		//contentOPF

		if(! $res[]=$this->files->content=new file('package.opf',$this->get_tmp_file()) )
		 {
		 	$this->errors[]=new error('Epub3-OPF','File could not be created');
		 }

			$content_inside=
'<?xml version="1.0" encoding="UTF-8"?>
<package xmlns="http://www.idpf.org/2007/opf" version="3.0" xml:lang="en" unique-identifier="pub-id" prefix="rendition: http://www.idpf.org/vocab/rendition/#">
	<metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
		<dc:language>tr</dc:language>
		<dc:title id="title" >'.$this->book->title.'</dc:title>
		<dc:creator id="creator" >'.$this->book->author.'</dc:creator>
		<meta property="dcterms:modified">'. date('Y-m-d\TH:i:s', strtotime( $this->book->created)).'Z</meta>
		<dc:date>'. date('Y', strtotime( $this->book->created)).'</dc:date>
		<dc:contributor>Linden</dc:contributor> 
		<dc:identifier id="pub-id" >urn:'.$this->uuid.'</dc:identifier>
		<dc:source>Linden-digital</dc:source>
		<dc:publisher>Linden digital</dc:publisher>
		<dc:rights>2005-13 Linden Digital. All rights reserved</dc:rights>
		<dc:description>by linden</dc:description>
		<meta name="covers" content="thumbnail"/>
		<meta property="rendition:layout">pre-paginated</meta>
		<meta property="rendition:orientation">landscape</meta>
		<meta property="rendition:spread">none</meta>



	</metadata>
	<manifest>
		<item href="'.$this->coverImage->filename.'" id="cover" media-type="image/'.$this->coverType.'" />
		<item href="'.$this->thumImage->filename.'" id="thumbnail" media-type="image/'.$this->thumType.'" />
		<item href="linkmarker.png" id="linkmarker" media-type="image/png" />
		<item href="popupmarker.png" id="popupmarker" media-type="image/png" />
%pages_manifest%
		<item href="page_styles.css" id="page_css" media-type="text/css" />
		<item href="stylesheet.css" id="stylesheet_css" media-type="text/css" />
		<item id="widgets_css" href="widgets.css" media-type="text/css" />
		<item id="sourcesanspro_css" href="webfonts/sourcesanspro.css" media-type="text/css" />
		<item id="alexbrush_css" href="webfonts/alexbrush-regular.css" media-type="text/css" />
		<item id="chunkfive_css" href="webfonts/chunkfive.css" media-type="text/css" />
		<item id="aller_css" href="webfonts/aller.css" media-type="text/css" />
		<item id="cantarell_css" href="webfonts/cantarell.css" media-type="text/css" />
		<item id="exo_css" href="webfonts/exo.css" media-type="text/css" />
		
		<item id="sourcesanspro_bold_eot" href="webfonts/sourcesanspro-bold.eot" media-type="application/font-eot" />
		<item id="sourcesanspro_bold_woff" href="webfonts/sourcesanspro-bold.woff" media-type="application/font-woff" />
		<item id="sourcesanspro_bold_ttf" href="webfonts/sourcesanspro-bold.ttf" media-type="application/font-ttf" />
		<item id="sourcesanspro_bold_svg" href="webfonts/sourcesanspro-bold.svg" media-type="application/font-svg" />

		<item id="sourcesanspro_boldit_eot" href="webfonts/sourcesanspro-boldit.eot" media-type="application/font-eot" />
		<item id="sourcesanspro_boldit_woff" href="webfonts/sourcesanspro-boldit.woff" media-type="application/font-woff" />
		<item id="sourcesanspro_boldit_ttf" href="webfonts/sourcesanspro-boldit.ttf" media-type="application/font-ttf" />
		<item id="sourcesanspro_boldit_csvg" href="webfonts/sourcesanspro-boldit.svg" media-type="application/font-svg" />

		<item id="sourcesanspro_it_eot" href="webfonts/sourcesanspro-it.eot" media-type="application/font-eot" />
		<item id="sourcesanspro_it_woff" href="webfonts/sourcesanspro-it.woff" media-type="application/font-woff" />
		<item id="sourcesanspro_it_ttf" href="webfonts/sourcesanspro-it.ttf" media-type="application/font-ttf" />
		<item id="sourcesanspro_it_svg" href="webfonts/sourcesanspro-it.svg" media-type="application/font-svg" />
		
		<item id="sourcesanspro_regular_eot" href="webfonts/sourcesanspro-regular.eot" media-type="application/font-eot" />
		<item id="sourcesanspro_regular_woff" href="webfonts/sourcesanspro-regular.woff" media-type="application/font-woff" />
		<item id="sourcesanspro_regular_ttf" href="webfonts/sourcesanspro-regular.ttf" media-type="application/font-ttf" />
		<item id="sourcesanspro_regular_svg" href="webfonts/sourcesanspro-regular.svg" media-type="application/font-svg" />

		<item id="exo_bold_eot" href="webfonts/exo-bold.eot" media-type="application/font-eot" />
		<item id="exo_bold_woff" href="webfonts/exo-bold.woff" media-type="application/font-woff" />
		<item id="exo_bold_ttf" href="webfonts/exo-bold.ttf" media-type="application/font-ttf" />
		<item id="exo_bold_svg" href="webfonts/exo-bold.svg" media-type="application/font-svg" />

		<item id="exo_bolditalic_eot" href="webfonts/exo-bolditalic.eot" media-type="application/font-eot" />
		<item id="exo_bolditalic_woff" href="webfonts/exo-bolditalic.woff" media-type="application/font-woff" />
		<item id="exo_bolditalic_ttf" href="webfonts/exo-bolditalic.ttf" media-type="application/font-ttf" />
		<item id="exo_bolditalic_svg" href="webfonts/exo-bolditalic.svg" media-type="application/font-svg" />

		<item id="exo_italic_eot" href="webfonts/exo-italic.eot" media-type="application/font-eot" />
		<item id="exo_italic_woff" href="webfonts/exo-italic.woff" media-type="application/font-woff" />
		<item id="exo_italic_ttf" href="webfonts/exo-italic.ttf" media-type="application/font-ttf" />
		<item id="exo_italic_svg" href="webfonts/exo-italic.svg" media-type="application/font-svg" />
		
		<item id="exo_regular_eot" href="webfonts/exo-regular.eot" media-type="application/font-eot" />
		<item id="exo_regular_woff" href="webfonts/exo-regular.woff" media-type="application/font-woff" />
		<item id="exo_regular_ttf" href="webfonts/exo-regular.ttf" media-type="application/font-ttf" />
		<item id="exo_regular_svg" href="webfonts/exo-regular.svg" media-type="application/font-svg" />

		<item id="alexbrush_regular_eot" href="webfonts/alexbrush-regular.eot" media-type="application/font-eot" />
		<item id="alexbrush_regular_woff" href="webfonts/alexbrush-regular.woff" media-type="application/font-woff" />
		<item id="alexbrush_regular_ttf" href="webfonts/alexbrush-regular.ttf" media-type="application/font-ttf" />
		<item id="alexbrush_regular_svg" href="webfonts/alexbrush-regular.svg" media-type="application/font-svg" />


		<item id="aller_bd_eot" href="webfonts/aller_bd.eot" media-type="application/font-eot" />
		<item id="aller_bd_woff" href="webfonts/aller_bd.woff" media-type="application/font-woff" />
		<item id="aller_bd_ttf" href="webfonts/aller_bd.ttf" media-type="application/font-ttf" />
		<item id="aller_bd_svg" href="webfonts/aller_bd.svg" media-type="application/font-svg" />

		<item id="aller_bdit_eot" href="webfonts/aller_bdit.eot" media-type="application/font-eot" />
		<item id="aller_bdit_woff" href="webfonts/aller_bdit.woff" media-type="application/font-woff" />
		<item id="aller_bdit_ttf" href="webfonts/aller_bdit.ttf" media-type="application/font-ttf" />
		<item id="aller_bdit_svg" href="webfonts/aller_bdit.svg" media-type="application/font-svg" />
		
		<item id="aller_it_eot" href="webfonts/aller_it.eot" media-type="application/font-eot" />
		<item id="aller_it_woff" href="webfonts/aller_it.woff" media-type="application/font-woff" />
		<item id="aller_it_ttf" href="webfonts/aller_it.ttf" media-type="application/font-ttf" />
		<item id="aller_it_svg" href="webfonts/aller_it.svg" media-type="application/font-svg" />

		<item id="aller_rg_eot" href="webfonts/aller_rg.eot" media-type="application/font-eot" />
		<item id="aller_rg_woff" href="webfonts/aller_rg.woff" media-type="application/font-woff" />
		<item id="aller_rg_ttf" href="webfonts/aller_rg.ttf" media-type="application/font-ttf" />
		<item id="aller_rg_svg" href="webfonts/aller_rg.svg" media-type="application/font-svg" />


		<item id="cantarell_bd_eot" href="webfonts/cantarell-boldoblique.eot" media-type="application/font-eot" />
		<item id="cantarell_bd_woff" href="webfonts/cantarell-boldoblique.woff" media-type="application/font-woff" />
		<item id="cantarell_bd_ttf" href="webfonts/cantarell-boldoblique.ttf" media-type="application/font-ttf" />
		<item id="cantarell_bd_svg" href="webfonts/cantarell-boldoblique.svg" media-type="application/font-svg" />

		<item id="cantarell_bdit_eot" href="webfonts/cantarell-bold.eot" media-type="application/font-eot" />
		<item id="cantarell_bdit_woff" href="webfonts/cantarell-bold.woff" media-type="application/font-woff" />
		<item id="cantarell_bdit_ttf" href="webfonts/cantarell-bold.ttf" media-type="application/font-ttf" />
		<item id="cantarell_bdit_svg" href="webfonts/cantarell-bold.svg" media-type="application/font-svg" />
		
		<item id="cantarell_it_eot" href="webfonts/cantarell-oblique.eot" media-type="application/font-eot" />
		<item id="cantarell_it_woff" href="webfonts/cantarell-oblique.woff" media-type="application/font-woff" />
		<item id="cantarell_it_ttf" href="webfonts/cantarell-oblique.ttf" media-type="application/font-ttf" />
		<item id="cantarell_it_svg" href="webfonts/cantarell-oblique.svg" media-type="application/font-svg" />

		<item id="cantarell_rg_eot" href="webfonts/cantarell-regular.eot" media-type="application/font-eot" />
		<item id="cantarell_rg_woff" href="webfonts/cantarell-regular.woff" media-type="application/font-woff" />
		<item id="cantarell_rg_ttf" href="webfonts/cantarell-regular.ttf" media-type="application/font-ttf" />
		<item id="cantarell_rg_svg" href="webfonts/cantarell-regular.svg" media-type="application/font-svg" />


		<item id="chunkfive_eot" href="webfonts/chunkfive.eot" media-type="application/font-eot" />
		<item id="chunkfive_woff" href="webfonts/chunkfive.woff" media-type="application/font-woff" />
		<item id="chunkfive_ttf" href="webfonts/chunkfive.ttf" media-type="application/font-ttf" />
		<item id="chunkfive_svg" href="webfonts/chunkfive.svg" media-type="application/font-svg" />


		<item id="opensans_bd_css" href="webfonts/open_sans/opensans-bold.css" media-type="text/css" />
		<item id="opensans_bd_eot" href="webfonts/open_sans/opensans-bold.eot" media-type="application/font-eot" />
		<item id="opensans_bd_woff" href="webfonts/open_sans/opensans-bold.woff" media-type="application/font-woff" />
		<item id="opensans_bd_ttf" href="webfonts/open_sans/opensans-bold.ttf" media-type="application/font-ttf" />
		<item id="opensans_bd_svg" href="webfonts/open_sans/opensans-bold.svg" media-type="application/font-svg" />

		<item id="opensans_bdit_css" href="webfonts/open_sans/opensans-bolditalic.css" media-type="text/css" />
		<item id="opensans_bdit_eot" href="webfonts/open_sans/opensans-bolditalic.eot" media-type="application/font-eot" />
		<item id="opensans_bdit_woff" href="webfonts/open_sans/opensans-bolditalic.woff" media-type="application/font-woff" />
		<item id="opensans_bdit_ttf" href="webfonts/open_sans/opensans-bolditalic.ttf" media-type="application/font-ttf" />
		<item id="opensans_bdit_svg" href="webfonts/open_sans/opensans-bolditalic.svg" media-type="application/font-svg" />
		
		<item id="opensans_it_css" href="webfonts/open_sans/opensans-italic.css" media-type="text/css" />
		<item id="opensans_it_eot" href="webfonts/open_sans/opensans-italic.eot" media-type="application/font-eot" />
		<item id="opensans_it_woff" href="webfonts/open_sans/opensans-italic.woff" media-type="application/font-woff" />
		<item id="opensans_it_ttf" href="webfonts/open_sans/opensans-italic.ttf" media-type="application/font-ttf" />
		<item id="opensans_it_svg" href="webfonts/open_sans/opensans-italic.svg" media-type="application/font-svg" />

		<item id="opensans_rg_css" href="webfonts/open_sans/opensans-regular.css" media-type="text/css" />
		<item id="opensans_rg_eot" href="webfonts/open_sans/opensans-regular.eot" media-type="application/font-eot" />
		<item id="opensans_rg_woff" href="webfonts/open_sans/opensans-regular.woff" media-type="application/font-woff" />
		<item id="opensans_rg_ttf" href="webfonts/open_sans/opensans-regular.ttf" media-type="application/font-ttf" />
		<item id="opensans_rg_svg" href="webfonts/open_sans/opensans-regular.svg" media-type="application/font-svg" />


		<item id="opensans2_bd_css" href="webfonts/open_sans/opensans-extrabold.css" media-type="text/css" />
		<item id="opensans2_bd_eot" href="webfonts/open_sans/opensans-extrabold.eot" media-type="application/font-eot" />
		<item id="opensans2_bd_woff" href="webfonts/open_sans/opensans-extrabold.woff" media-type="application/font-woff" />
		<item id="opensans2_bd_ttf" href="webfonts/open_sans/opensans-extrabold.ttf" media-type="application/font-ttf" />
		<item id="opensans2_bd_svg" href="webfonts/open_sans/opensans-extrabold.svg" media-type="application/font-svg" />

		<item id="opensans2_bdit_css" href="webfonts/open_sans/opensans-extrabolditalic.css" media-type="text/css" />
		<item id="opensans2_bdit_eot" href="webfonts/open_sans/opensans-extrabolditalic.eot" media-type="application/font-eot" />
		<item id="opensans2_bdit_woff" href="webfonts/open_sans/opensans-extrabolditalic.woff" media-type="application/font-woff" />
		<item id="opensans2_bdit_ttf" href="webfonts/open_sans/opensans-extrabolditalic.ttf" media-type="application/font-ttf" />
		<item id="opensans2_bdit_svg" href="webfonts/open_sans/opensans-extrabolditalic.svg" media-type="application/font-svg" />
		
		<item id="opensans2_it_css" href="webfonts/open_sans/opensans-lightitalic.css" media-type="text/css" />
		<item id="opensans2_it_eot" href="webfonts/open_sans/opensans-lightitalic.eot" media-type="application/font-eot" />
		<item id="opensans2_it_woff" href="webfonts/open_sans/opensans-lightitalic.woff" media-type="application/font-woff" />
		<item id="opensans2_it_ttf" href="webfonts/open_sans/opensans-lightitalic.ttf" media-type="application/font-ttf" />
		<item id="opensans2_it_svg" href="webfonts/open_sans/opensans-lightitalic.svg" media-type="application/font-svg" />

		<item id="opensans2_rg_css" href="webfonts/open_sans/opensans-light.css" media-type="text/css" />
		<item id="opensans2_rg_eot" href="webfonts/open_sans/opensans-light.eot" media-type="application/font-eot" />
		<item id="opensans2_rg_woff" href="webfonts/open_sans/opensans-light.woff" media-type="application/font-woff" />
		<item id="opensans2_rg_ttf" href="webfonts/open_sans/opensans-light.ttf" media-type="application/font-ttf" />
		<item id="opensans2_rg_svg" href="webfonts/open_sans/opensans-light.svg" media-type="application/font-svg" />
		
		<item id="open_sans_css1" href="webfonts/open_sans/open_sans.css" media-type="text/css" />





		<item href="titlepage.xhtml" id="titlepage" media-type="application/xhtml+xml" properties="svg" />
		<item href="toc.ncx" media-type="application/x-dtbncx+xml" id="ncx" />
		<item id="nav" href="toc.xhtml" properties="nav" media-type="application/xhtml+xml" />
		<item id="js001" href="jquery-1.4.4.min.js" media-type="text/javascript" />
	    <item id="js002" href="aie_core.js" media-type="text/javascript" />
	    <item id="js003" href="aie_events.js" media-type="text/javascript" />
	    <item id="js004" href="aie_explore.js" media-type="text/javascript" />
	    <item id="js005" href="aie_gameutils.js" media-type="text/javascript" />
	    <item id="js006" href="aie_qaa.js" media-type="text/javascript" />
	    <item id="js007" href="aie_storyline.js" media-type="text/javascript" />
	    <item id="js008" href="aie_textsound.js" media-type="text/javascript" />
	    <item id="js009" href="igp_audio.js" media-type="text/javascript" />
	    <item id="js010" href="iscroll.js" media-type="text/javascript" />
	    <item id="js011" href="jquery.min.js" media-type="text/javascript" />
	    <item id="js012" href="jquery-ui.min.js" media-type="text/javascript" />
	    <item id="js013" href="LAB.min.js" media-type="text/javascript" />
	    <item id="js014" href="panelnav.js" media-type="text/javascript" />
	    <item id="js015" href="popup.js" media-type="text/javascript" />
	    <item id="js016" href="pubsub.js" media-type="text/javascript" />
	    <item id="js017" href="Chart.js" media-type="text/javascript" />
	    <item id="js018" href="kinetic-v4.5.3.min.js" media-type="text/javascript" />
	</manifest>
	<spine toc="ncx" page-progression-direction="ltr">
		<itemref idref="titlepage" />
%page_spine%
	</spine>
</package>';
			$pages_manifest="";
			$page_spine="";
			foreach ($this->files->pages as $key => $page) {
				$pages_manifest.="\t\t". '<item href="'.$page->filename.'" id="id'.$key.'" properties="scripted" media-type="application/xhtml+xml"/>'. "\n";
				$page_spine.="\t\t".'<itemref idref="id'.$key.'" linear="yes" />' . "\n";

			}

			if($this->files->others)
			foreach ($this->files->others as $assets_key => $asset) {
				$pages_manifest.="\t\t". '<item href="'.$asset->filename.'" id="asset'.$assets_key.'"  media-type="'. substr(system(' file -i '.$asset->filepath." | awk '{ print $2}'" ),0,-1). '"/>'. "\n";
			}


			$content_inside=str_replace(array(
			'%pages_manifest%','%page_spine%'
			), array($pages_manifest,$page_spine), $content_inside);



		if(!$res[]=$this->files->content->writeLine($content_inside))	
			 {
			 	$this->errors[]=new error('Epub3-OPF','File could not be written');
			 }
		if(!$res[]=$this->files->content->closeFile())
			 {
			 	$this->errors[]=new error('Epub3-OPF','File could not be closed');
			 }
		return $res;


	}

	public function zipfolder($encyrptFiles=true){
		$zip = new ZipArchive;
		

		$this->ebookFile=$this->getNiceName('epub');

		$zip->open($this->ebookFile, ZipArchive::CREATE);
		$source = str_replace('\\', '/', realpath($this->get_tmp_file()));
		
		if ($encyrptFiles) Encryption::encryptFolder($source);





	    if (is_dir($source) === true)
	    {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

	        foreach ($files as $file)
	        {
	        	set_time_limit(30);
	            $file = str_replace('\\', '/', $file);

	            // Ignore "." and ".." folders
	            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
	                continue;

	            $file = realpath($file);

	            if (is_dir($file) === true)
	            {
	                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
	            }
	            else if (is_file($file) === true)
	            {
	                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
	            }
	        }
	    }
	    else if (is_file($source) === true)
	    {
	        $zip->addFromString(basename($source), file_get_contents($source));
	    }

	    return $zip->close();

		
	}

	public function download(){
		if (file_exists($this->ebookFile)) {	
			header('Content-Description: File Transfer');
			header('Content-Type: application/epub+zip');
			header('Content-Disposition: attachment; filename='.basename($this->ebookFile));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($this->ebookFile));
			ob_clean();
			flush();
			readfile($this->ebookFile);
			die;
		}
		
		die();
	}
	public function getEbookFile()
	{
		return $this->ebookFile;
	}

	public function getNiceName($ext)
	{
		return $this->nicename.'.'.$ext;
	}

	public function getTitle()
	{
		return $this->book->title;
	}

	public function getSanitizedFilename()
	{
		return $this->sanitized_filename;
	}
	public function createThumbnails(){
		error_log("Thumbnail\n");
		error_log($this->get_tmp_file());
		//error_log(print_r(scandir($this->get_tmp_file()),1));
		$files=scandir($this->get_tmp_file());
		$file_list="";
		foreach ($files as $file) {
			if(preg_match("/.+\.html/", $file))
			{
				$file=str_replace(".html", "", $file);
				error_log($file);
				error_log("\n");
				$file_list.=" ".$file;
			}
			# code...
		}
		error_log("file list:".$file_list);
		error_log("sh ".Yii::app()->params['htmltopng']." ".$this->get_tmp_file().$file_list);
		$result=shell_exec("sh ".Yii::app()->params['htmltopng']." ".$this->get_tmp_file().$file_list);
		if($result==null){
			echo "result is null";
			return false;
		}
		return true;

	}
	public function __construct($book_model=null, $download=true, $encyrptFiles=false){ 
		
		$this->book=$book_model;
		$this->uuid=functions::uuid();
		


		//Create Temp Folder and store
		if(!$this->tempdir=epub3::tempdir())
		{
			$this->errors[]=new error('Epub3-Construction','No temprory folder created!');
		}


		
		if($this->book){
			$this->title=$this->book->title;
			//$this->nicename=$this->tempdirParent.'/'.file::sanitize($this->title);
			$this->sanitized_filename=file::sanitize($this->book->title);
			$this->nicename=$this->tempdirParent.'/'.$this->sanitized_filename;
		}


		$this->prepareBookStructure();


		//Create Mimetype file and write into it.
		if( in_array(false,$this->create_MIMETYPE_File() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with MIMETYPE file');
			return false;
		}



		//Copy cover image.
		if( in_array(false,$this->copyCoverImage() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with Cover Image file');
			return false;
		}

		//Copy thumbnail image.
		if( in_array(false,$this->copyThumImage() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with thumbnail Image file');
			return false;
		}


		//Generic files.
		if( in_array(false,$this->createGenericFiles() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with Generic files');
			return false;
		}


		//CSS files.
		if( in_array(false,$this->createCssStyleSheets() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with CSS files');
			return false;
		}



		//Title Page.
		if( in_array(false,$this->create_title_page() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with Title Page'); 
			return false;
		}

		//containerXML.
		if( in_array(false,$this->containerXML() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with containerXML');
			return false;
		}

		//TOC.
		if( in_array(false,$this->createTOC() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with TOC');
			return false;
		}

		//TOCNav.
		if( in_array(false,$this->createTOCNav() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with TOCNav');
			return false;
		}

		//contentOPF.
		if( in_array(false,$this->contentOPF() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with contentOPF');
			return false;
		}

		//Create thumbnails
		if(!$this->createThumbnails()){
			$this->errors[]=new error('Thumbnail production','Problem with thumbnails');
			return false;
		}
		//Create Zip.
		if( ! $this->zipfolder($encyrptFiles)  ) {
			$this->errors[]=new error('Epub3-Construction','Problem with Zip');
			return false;
		}


		return $this->ebookFile;






	}

}
