<?php
class PdfUtil{
	private $pdfPath;
	private $pdfFileId;

	function __construct($pdfPath,$pdfFileId){
		$this->setPdfPath($pdfPath);
		$this->setPdfFileId($pdfFileId);
	}
	public function extractHtmls(){	

	}
	public function extractImages(){
        $pdftojpg=Yii::app()->params->pdftojpg;
        $extractPath=$this->getPdfPath().'/';
        $pdfSourcePath=$extractPath.$this->getPdfFileId().'.pdf';
        exec('sh '.$pdftojpg.' '.$pdfSourcePath.' '.$extractPath);

	}
	public function extractSearchIndex() {
		
	}
	public function extractTableofContents(){
		setlocale( LC_MESSAGES,'tr_TR.UTF-8');
		putenv("LANG=tr_TR.UTF-8");

		$path=$this->getPdfPath().'/'.$this->getPdfFileId().'.pdf';
		$input_stream=popen(Yii::app()->params->tocextractor.$path,'r');
		$lines=array();
		while($line=fgets($input_stream,4096))
		{
			error_log($line);
			preg_match("/([\"\'\&\#\?\!\/\\\.A-Za-z0-9ĞğÖöŞşÜüÇçİı ;,_-:.])*[^\$]\d+[,]/",$line,$step1);// 0 => 'How to write a document/6,'
			//preg_match("/\D*(\d*)(,)/",$step1[0],$step2);//0 => 'How to write a document/3,',1 => 'How to write a document/',2 => '3'
			error_log($step1[0]);
			list($toc_title,$start_page)=explode("/",$step1[0]);
			$start_page=(int)substr($start_page, 0, -1);
			$end_page=$start_page;
			if(sizeof($lines)!=0)
				if($start_page>$lines[sizeof($lines)-1]['end_page'])
					{
						$lines[sizeof($lines)-1]['end_page']=$start_page-1;
					}
				else
					{
						$lines[sizeof($lines)-1]['end_page']=$lines[sizeof($lines)-1]['start_page'];
					}
			$lines[]=array('toc_title'=>$toc_title,'start_page'=>$start_page,'end_page'=>$end_page);
		}
		fclose($input_stream);
		if(sizeof($lines)==0)
		{

			return null;//array('toc_title'=>' ','start_page'=>0,'end_page'=>0);
		}
		return $lines;
		//$lines=Array ( [0] => Array ( [toc_title] => ToC 2 samples.pdf [start_page] => 1 [end_page] => 1 ) [1] => Array ( [toc_title] => ToC manuscript in 2 parts [start_page] => 2 [end_page] => 2 ) )
	}

	public function getNumberofPages(){
		$path=$this->getPdfPath().'/'.$this->getPdfFileId().'.pdf';
		exec("pdfinfo ".$path." | awk '/Pages/ {print $2}\'",$page_object);
		if ($page_object!=null && isset($page_object[0])){
			return $page_object[0];
		}
		return 0;
	}
	public function getPdfPath(){
		return $this->pdfPath;
	}

	public function setPdfPath($pdfPath){
		$this->pdfPath=$pdfPath;
	}

	public function getPdfFileId(){
		return $this->pdfFileId;
	}

	public function setPdfFileId($pdfFileId){
		$this->pdfFileId=$pdfFileId;
	}

	public function isPdfPathSet(){
		return isset($this->pdfPath);
	}

	public function pdfExists(){
		return file_exists($this->pdfPath);
	}




}
