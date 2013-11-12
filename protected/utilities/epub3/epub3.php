<?php
class epub3 {
	

	public $tempdir='';
	public $errors=null;
	public $files ;
	public $book ;
	public $coverImage ;

	public function tempdir($dir=false,$prefix='epub3_export') {
	$tempfile=tempnam(sys_get_temp_dir(),'');

	if (file_exists($tempfile)) 
		{ unlink($tempfile); }

	mkdir($tempfile);

	if (is_dir($tempfile)) 
		{ return $tempfile; }

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

			if(! $res[]=$this->files->styleSheets->page_styles=new file('page_styles.css',$this->get_tmp_file()) )
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






	}

	public function copyCoverImage(){

		$this->coverImage='cover.jpg';
		//$image=imagecreatefromjpeg(filename)( __DIR__ . '/' . $this->coverImage ) ;
		//imagejpeg($image, $this->get_tmp_file_path($this->coverImage))	


		//echo __DIR__ . '/' . $this->coverImage . "    " . ;
		//return array();
		$command="cp " . __DIR__ . '/' . $this->coverImage . " ". $this->get_tmp_file_path($this->coverImage);
		$this->coverImage= shell_exec( $command );

		if(! $res[]=  $this->coverImage ){
			$this->errors[]=new error('Epub3-copyCoverImage','File could not be copied',__DIR__ . '/' . $this->coverImage,$this->get_tmp_file_path($this->coverImage));
		}

		return $res;

	}	


	public function create_title_page(){
			//page_styles.css 

			if(! $res[]=$this->files->styleSheets->page_styles=new file('page_styles.css',$this->get_tmp_file()) )
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

	}


	

	public function __construct($book_model=null){
		
		$this->book=$book_model;


		//Create Temp Folder and store
		if(!$this->tempdir=epub3::tempdir())
		{
			$this->errors[]=new error('Epub3-Construction','No temprory folder created!');
		}


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





	}

}
