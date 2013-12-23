<?php
class epub3 {
	

	public $tempdir='';
	public $tempdirParent='';
	public $files ;
	public $toc;
	public $chapters ;
	public $coverImage ;
	public $nicename;
	public $ebookFile ;
	public $title='Canim Kitabim';

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

			$genericFiles = new stdClass;

			$genericFiles->URL=Yii::app()->request->hostInfo . '/css/epubPublish/generic.zip';

			$genericFiles->filename='generic.zip';

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
					width:1204px;
					height:768px;
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
		$this->coverImage->URL=Yii::app()->request->hostInfo . '/css/cover.jpg';

		$this->coverImage->filename='cover.jpg';

		$image_file_contents=file_get_contents($this->coverImage ->URL);

		$this->files->coverImage= new file( $this->coverImage->filename, $this->get_tmp_file() );
		
		$this->files->coverImage->writeLine($image_file_contents);

		$this->files->coverImage->closeFile();


		
		

		if(! $res[]=  $this->coverImage ){
			$this->errors[]=new error('Epub3-copyCoverImage','File could not be copied',__DIR__ . '/' . $this->coverImage,$this->get_tmp_file_path($this->coverImage));
		}

		return $res;

	}	


	public function create_title_page(){


	

			//create_title_page

			if(! $res[]=$this->files->titlepage=new file('titlepage.xhtml',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be created');
			 }
			
				$title_page=
'<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" lang="en">
  <head>
    <meta http-equiv="default-style" content="text/html; charset=utf-8"/>
    	<title>'.$this->title.'</title>
    	<link rel="stylesheet" href="stylesheet.css" type="text/css"/>
		<link rel="stylesheet" href="page_styles.css" type="text/css"/>
		<link rel="stylesheet" href="widgets.css" type="text/css"/>

		<meta name="viewport" content="width=1024, height=768"/>
	

		
	</head>
	<body>
		<div>
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 425 616" preserveAspectRatio="none">
				<image width="425" height="616" xlink:href="' . $this->coverImage->filename . '"/>
			</svg>
		</div>
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
					$new_page->file->writeLine($this->prepare_PageHtml($new_page));

					$new_chapter->pages[]=$new_page;

					unset($new_page);
					$chapter_page_counts++;
				}

			$this->chapters[]=$new_chapter;
			}
			unset($new_chapter);

		}


	}

	public function prepare_PageHtml(&$page){
		$components_html='';
		$page_styles='';
		$page_structure=
'<?xml version="1.0" encoding="UTF-8"?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops" lang="en">
  <head>
    <meta http-equiv="default-style" content="text/html; charset=utf-8"/>
    <title>My first book</title>

		<meta name="viewport" content="width=1024, height=768"/>

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


	</head>
	<body>
	<section epub:type="frontmatter titlepage">
%components%
	</section>

	</body>
</html>';

		foreach ($page->components as $component){
			$component=(object)$component;
			$component->html=new componentHTML($component,$this);
			$components_html.=$component->html->html;
		}
		$page_file_inside=str_replace(array(
			'%components%','%style%'
			), array($components_html,$page_styles), $page_structure);



		return $page_file_inside;


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
		<meta content="0c159d12-f5fe-4323-8194-f5c652b89f5c" name="dtb:uid"/>
		<meta content="2" name="dtb:depth"/>
		<meta content="calibre (0.8.68)" name="dtb:generator"/>
		<meta content="0" name="dtb:totalPageCount"/>
		<meta content="0" name="dtb:maxPageNumber"/>
	</head>
	<docTitle>
		<text>'.$this->book->title.'</text>
	</docTitle>
	<navMap>
%navPoints%
	</navMap>
</ncx>
				';


				$toc_items="";
				$index_referance=0;
				foreach ($this->toc as $key => $toc) {

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
		<dc:title id="title" >'.$this->title.'</dc:title>
		<dc:creator id="creator" >'.$this->book->author.'</dc:creator>
		<meta property="dcterms:modified">'. date('Y-m-d\TH:i:sP', strtotime( $this->book->created)).'</meta>
		<dc:date>'. date('Y', strtotime( $this->book->created)).'</dc:date>
		<dc:contributor></dc:contributor> 
		<dc:identifier id="uuid_id" >'.functions::uuid().'</dc:identifier>
		<dc:source>Linden-digital</dc:source>
		<dc:publisher>Linden digital</dc:publisher>
		<dc:rights>2005-13 Linden Digital. All rights reserved</dc:rights>
		<dc:description>by linden</dc:description>
		<meta name="covers" content="cover"/>
		<meta property="rendition:layout">pre-paginated</meta>
		<meta property="rendition:orientation">landscape</meta>
		<meta property="rendition:spread">none</meta>



	</metadata>
	<manifest>
		<item href="cover.jpg" id="cover" media-type="image/jpg" />
		<item href="linkmarker.png" id="linkmarker" media-type="image/png" />
		<item href="popupmarker.png" id="popupmarker" media-type="image/png" />
%pages_manifest%
		<item href="page_styles.css" id="page_css" media-type="text/css" />
		<item href="stylesheet.css" id="stylesheet_css" media-type="text/css" />
		<item id="widgets_css" href="widgets.css" media-type="text/css" />
		<item href="titlepage.xhtml" id="titlepage" media-type="application/xhtml+xml" />
		<item href="toc.ncx" media-type="application/x-dtbncx+xml" id="ncx" />
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

	public function zipfolder(){
		$zip = new ZipArchive;
		

		$this->ebookFile=$this->getNiceName('epub');

		$zip->open($this->ebookFile, ZipArchive::CREATE);




		$source = str_replace('\\', '/', realpath($this->get_tmp_file()));

	    if (is_dir($source) === true)
	    {
	        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

	        foreach ($files as $file)
	        {
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
		echo "file not exists".$this->ebookFile;die();
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
		return $this->title;
	}

	public function getSanitizedFilename()
	{
		return $this->sanitized_filename;
	}

	public function __construct($book_model=null, $download=true){ 
		
		$this->book=$book_model;

		


		//Create Temp Folder and store
		if(!$this->tempdir=epub3::tempdir())
		{
			$this->errors[]=new error('Epub3-Construction','No temprory folder created!');
		}


		
		if($this->book){
			$this->title=$this->book->title;
			//$this->nicename=$this->tempdirParent.'/'.file::sanitize($this->title);
			$this->sanitized_filename=file::sanitize($this->title);
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

		//contentOPF.
		if( in_array(false,$this->contentOPF() ) ) {
			$this->errors[]=new error('Epub3-Construction','Problem with contentOPF');
			return false;
		}

		//Create Zip.
		if( ! $this->zipfolder()  ) {
			$this->errors[]=new error('Epub3-Construction','Problem with Zip');
			return false;
		}


		return $this->ebookFile;






	}

}
