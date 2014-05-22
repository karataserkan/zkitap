<?php
class UtilController extends Controller{


	public function actionCalculateOrganisationSpace()
	{	$user=Yii::app()->user;
		$storagePath=Yii::app()->params['storage'];
		$organisation=OrganisationUsers::model()->find('user_id=:user_id',array(':user_id'=>Yii::app()->user->id));
		if ($organisation){
			print_r($organisationId);
			$queryString="select component.id,component.type from organisation_workspaces,book,chapter,page,component where organisation_workspaces.organisation_id='".$organisation->organisation_id."' AND organisation_workspaces.workspace_id=book.workspace_id AND book.book_id=chapter.book_id AND chapter.chapter_id=page.chapter_id AND page.page_id=component.page_id";
			$results=Yii::app()->db->createCommand($queryString)->queryAll();
			foreach ($results as $result) {
				print_r($result);
				print_r(glob($storagePath.$result['id'].'.*',GLOB_BRACE));
				echo "<br>";

			}
		}

	}
	public function actionSetCoverThumbnail(){
		$path="/var/www/squid-pacific/master/uploads/files/";
		$seviye_books=Book::model()->findAll('author=:author',array('author' => 'Seviye Yayınları'));
		foreach ($seviye_books as $book) {
			$book_data=json_decode($book->data,true);
			if(file_exists($path.$book->book_id."/page-1.jpg"))
			{
				try{
				$data_image=$this->base64_encode_image($path.$book->book_id."/page-1.jpg","jpeg");
				$book_data['cover']=$data_image;
				$data_thumnail=$this->base64_encode_image($path.$book->book_id."/thumbnailpage-1.jpg","jpeg");
				$book_data['thumbnail']=$data_thumnail;
				$book->data=json_encode($book_data);
					if($book->save()){
						print_r($book->book_id."-->Saved");
					}
					else 
					{
						print_r($book->getErrors());	
					}
				}
				catch (Exception $ex)
				{
					print_r("error!");
				}
			}
			else
			{
				print_r($book->book_id."-->no thumbnails");
			}

		}

	}
	public function actionRemoveUnused(){
		/*
		
		$files= scandir($path);
		 $result=Yii::app()->db->createCommand()
	    ->select('co.id')
	    ->from('book b,chapter ch, page p, component co')
	    ->where('b.book_id=ch.book_id AND ch.chapter_id=p.chapter_id AND p.page_id=co.page_id')
	    ->queryRow();
	    print_r($result);*/
	    $path="/var/www/squid-pacific/master/uploads/files/";
	    $files= scandir($path);
	    $results=Yii::app()->db->createCommand("select component.id from book,chapter,page,component where book.book_id=chapter.book_id AND chapter.chapter_id=page.chapter_id AND page.page_id=component.page_id")->queryAll();
	    $counter=0;
		foreach ($files as $file) {
			$status=false;
			foreach($results as $result)
			{
				$sonuc=array();
				preg_match("/".$result['id']."/", $file, $sonuc);
				if(!empty($sonuc)){
					//print_r($file);echo "<br>";
					$status=true;
				}
			}
			if(!$status){
				$counter++;
				echo $file."<br>";
				if (!is_dir($path.$file))
				{
					unlink($path.$file);
				}
				else
				{
					$this->rrmdir($path.$file);
				}
			}

		}
		echo "COUNTER:".$counter;
		/*$seviye_books=Book::model()->findAll();
		foreach ($seviye_books as $book) {
			$chapters=Chapter::model()->findAll('book_id=:book_id',array('book_id' => $book->book_id ));
			foreach ($chapters as $chapter) {
				$pages=Page::model()->findAll('chapter_id=:chapter_id',array('chapter_id' => $chapter->chapter_id ));
				foreach ($pages as $page) {
					print_r($page->page_id);
				}
				
			}
		}*/		
	}

 function rrmdir($dir) {
	    foreach(glob($dir . '/*') as $file) 
	    {
	        if(is_dir($file))
	            $this->rrmdir($file);
	        else
	            unlink($file);
	    }
    	rmdir($dir);
	}
	private function base64_encode_image ($filename=string,$filetype=string) {
	    if ($filename and filesize($filename)>0) {
	    	try
	    	{
	        	$imgbinary = fread(fopen($filename, "r"), filesize($filename));
	        	return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
	    	}
	    	catch(Exception $ex){
	    		return 'data:image/' . $filetype . ';base64,' . base64_encode("");
	    	}
	    }
	}

}