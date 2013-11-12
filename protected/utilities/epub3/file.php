<?php 
class file {
	
	public $path ='';
	public $filename ='';
	public $filepath ='';
	public $handler ;

	public  function __construct($filename,$pathWithout){
		$this->path=$pathWithout;
		$this->filename=$filename;
		if(substr($this->path,-1)!='/') $this->path.='/';

		$this->filepath=$this->path.$this->filename;

		$this->handler=$this->createFile($this->filepath);

	}

	public function reopenFileAs($mode){
		$this->closeFile();
	}

	public function openfile($filename,$mode){
		
		return fopen($filename, $mode);

	}

	public function createFile($filename){
		
		return $this->openfile($filename,'w');

	}

	public function writeLine($line) {

		return fwrite($this->handler, $line);	

	}

	public function closeFile(){

		return fclose($this->handler);

	}


}