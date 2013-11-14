<?php
class epub3 {
	

	public $tempdir='';
	public $tempdirParent='';
	public $files ;
	public $toc;
	public $chapters ;
	public $coverImage ;
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


	public function createCssStyleSheets(){


			//page_styles.css

			if(! $res[]=$this->files->styleSheets->page_style=new file('page_styles.css',$this->get_tmp_file()) )
			 {
			 	$this->errors[]=new error('Epub3-createCssStyleSheets','File could not be created');
			 }

				$page_styles="
				@page {
				  margin-bottom: 5pt;
				  margin-top: 5pt
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
			
				$title_page='
				<?xml version="1.0" encoding="utf-8"?>
				<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
						<title>'.$this->title.'</title>
						<style type="text/css" title="override_css">
							@page {padding: 0pt; margin:0pt}
							body { 
								text-align: center; padding:0pt; margin: 0pt; background: white;
								border: thin solid black;
								zoom: 1;
								padding: 1cm;
								margin-top: 5px;
								height: 700px;
								width: 600px;
								position: relative;
								color: #333;
								font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
								font-size: 13px;
							}
						</style>
					</head>
					<body>
						<div>
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 425 616" preserveAspectRatio="none">
								<image width="425" height="616" xlink:href="' . $this->coverImage->filename . '"/>
							</svg>
						</div>
					</body>
				</html>
				';


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

					$this->files->pages[]=$new_page->file=new file($new_page->page_id . '.xhtml', $this->get_tmp_file() );



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
		$page_structure='
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html>
			<head>
				<style type="text/css">
				%style%
				</style>
			</head>
			<body>
				%components%
			</body>
		</html>

		';

		foreach ($page->components as $component){
			$component=(object)$component;
			$component->html=new componentHTML($component);
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

				$TOC_Html='
				<?xml version="1.0" encoding="utf-8"?>
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

					$toc_items.='
					<navPoint id="a'. ($index_referance+1) .'" playOrder="'. $index_referance .'">
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
		if(!$res[]=mkdir($this->get_tmp_file_path('META-INF')) ){
			$this->errors[]=new error('Epub3-containerXML','META-INF could not be Created');
		}

		//containerXML

		if(! $res[]=$this->files->containerXML=new file('META-INF/container.xml',$this->get_tmp_file()) )
		 {
		 	$this->errors[]=new error('Epub3-containerXML','File could not be created');
		 }

			$containerXML_inside='
			<?xml version="1.0"?>
			<container version="1.0" xmlns="urn:oasis:names:tc:opendocument:xmlns:container">
				<rootfiles>
					<rootfile full-path="content.opf" media-type="application/oebps-package+xml"/>
				</rootfiles>
			</container>
			';


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

		if(! $res[]=$this->files->content=new file('content.opf',$this->get_tmp_file()) )
		 {
		 	$this->errors[]=new error('Epub3-contentOPF','File could not be created');
		 }

			$content_inside='
			<?xml version="1.0" encoding="utf-8"?>
			<package xmlns="http://www.idpf.org/2007/opf" version="2.0" unique-identifier="uuid_id">
				<metadata xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:opf="http://www.idpf.org/2007/opf" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:calibre="http://calibre.kovidgoyal.net/2009/metadata" xmlns:dc="http://purl.org/dc/elements/1.1/">
					<dc:language>tr</dc:language>
					<dc:title>'.$this->title.'</dc:title>
					<dc:creator opf:role="aut">'.$this->book->author.'</dc:creator>
					<meta name="cover" content="cover"/>
					<dc:date>'. date('Y-m-d\TH:i:s+P', strtotime( $this->book->created)).'</dc:date>
					<dc:contributor opf:role="bkp"></dc:contributor>
					<dc:identifier id="uuid_id" opf:scheme="uuid">'.functions::uuid().'</dc:identifier>
				</metadata>
				<manifest>
					<item href="cover.jpg" id="cover" media-type="image/jpg"/>
					%pages_manifest%
					<item href="page_styles.css" id="page_css" media-type="text/css"/>
					<item href="stylesheet.css" id="css" media-type="text/css"/>
					<item href="titlepage.xhtml" id="titlepage" media-type="application/xhtml+xml"/>
					<item href="toc.ncx" media-type="application/x-dtbncx+xml" id="ncx"/>
				</manifest>
				<spine toc="ncx">
					<itemref idref="titlepage"/>
					%page_spine%
				</spine>
				<guide>
					<reference href="titlepage.xhtml" type="cover" title="Cover"/>
				</guide>
			</package>
			';
			$pages_manifest="";
			$page_spine="";
			foreach ($this->files->pages as $key => $page) {
				$pages_manifest.='<item href="'.$page->filename.'" id="id'.$key.'" media-type="application/xhtml+xml"/>';
				$page_spine.='<itemref idref="id'.$key.'"/>';

			}


			$content_inside=str_replace(array(
			'%pages_manifest%','%page_spine%'
			), array($pages_manifest,$page_spine), $content_inside);



		if(!$res[]=$this->files->content->writeLine($content_inside))	
			 {
			 	$this->errors[]=new error('Epub3-contentOPF','File could not be written');
			 }
		if(!$res[]=$this->files->content->closeFile())
			 {
			 	$this->errors[]=new error('Epub3-contentOPF','File could not be closed');
			 }
		return $res;


	}

	public function zipfolder(){
		$zip = new ZipArchive;
		$this->ebookFile=$this->tempdirParent.'/'.file::sanitize($this->title). '.epub';

		$zip->open($this->ebookFile, ZipArchive::CREATE);
		if (false !== ($dir = opendir($this->get_tmp_file())))
		     {
		         while (false !== ($file = readdir($dir)))
		         {
		             if ($file != '.' && $file != '..')
		             {
		                       $zip->addFile($this->get_tmp_file().DIRECTORY_SEPARATOR.$file);
		                       //delete if need
		                       //if($file!=='important.txt') 
		                       //  unlink($this->get_tmp_file().DIRECTORY_SEPARATOR.$file);
		             }
		         }
		     }
		     else
		     {
		         $this->errors[]=new error('Epub3-zipfolder','Can\'t read folder',$this->get_tmp_file() );
		         return false;

		     }
		$zip->close();
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
	}


	public function __construct($book_model=null){ 
		
		$this->book=$book_model;
		
		if($this->book){
			$this->title	=$this->book->title;
		
		}


		//Create Temp Folder and store
		if(!$this->tempdir=epub3::tempdir())
		{
			$this->errors[]=new error('Epub3-Construction','No temprory folder created!');
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
