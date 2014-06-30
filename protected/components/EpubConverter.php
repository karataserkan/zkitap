<?php

class EpubConverter
{
	private $epub_path;
	private $pdf_path;
	private $process_count;

	public function __construct($epub_path,$pdf_path,$process_count) {
    		$this->epub_path = $epub_path;
		$this->pdf_path=$pdf_path;
		$this->process_count=$process_count;
  	}
	public function extract()
	{
		$sh_string='';
		$merge=array();
		$start_point=0;
		$extract_folder=$this->getUnique();
		$pdf='/tmp/'.$extract_folder;
		exec('unzip -o '.$this->epub_path.' -d '.$pdf);
		$files=array();
		$this->getFiles($pdf.'/package.opf',$files);
		error_log(print_r($files,1));		
		if($this->process_count>sizeof($files))
		{
			$this->process_count=sizeof($files);
			error_log("EpubConverter:number of processes should be less than number of pages but it is ok and fixed!\n");
		}
		$counter=(int)((sizeof($files)/$this->process_count));
		for($i=0;$i< ($this->process_count);$i++)
			{
				error_log("EpubConverter:process number: $i\n");
				if($i==$this->process_count-1)
				{
					$temp_files=array_slice($files,$start_point);
				}
				else
				{
					$temp_files=array_slice($files,$start_point,$counter);
					$start_point+=$counter;
				}				
				$process[]=$this->getUnique();
				$output_text=$process[sizeof($process)-1];
				$merge[]=$pdf.'/'.$output_text.'.pdf';
				$sh_string.='sh '.(Yii::app()->params['epubtopdf']).$output_text.' '.$pdf.' '.$this->getWithSpace($temp_files).'&';
			}
			$sh_string.='wait;`pdftk '.$this->getWithSpace($merge).' cat output '.$this->pdf_path.'`';
			error_log($sh_string);
			exec($sh_string,$result);
			error_log($result);
			return $this->check_success($this->pdf_path);
	}

	private function check_success($pdf_path)
	{
		if(file_exists($pdf_path))
		{
			return true;
		}
		return false;
	}
	private function getFiles($opf_path,&$files)
	{
		$pages=simplexml_load_file($opf_path);
		//$tocs=simplexml_load_file($pdf.'toc.ncx');
		
		$pages=$pages->manifest->item;
		
		foreach($pages as $page)
		{
			$page_attributes=$page->attributes();
			$media_type=$page_attributes['media-type'];
			$id=$page_attributes['id'];
			if($media_type=='application/xhtml+xml')
			{
				
				$href=(string)$page_attributes['href'][0];
				error_log($href);
				error_log('\n');
				if($href!='toc.xhtml'){
					if($id=='titlepage')
					{
						$files=array_merge(array($href),$files);
					}
					else
					{
						$files[]=$href;
					}
				}
			}
			
		}
		
	}

	private function getUnique()
	{
		return substr(number_format(time() * rand(),0,'',''),0,10);
	}

	private function getWithSpace($array)
	{
		return implode(" ",$array);
	}

}
