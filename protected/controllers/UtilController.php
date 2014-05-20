<?php
class UtilController extends Controller{


	public function actionSetCoverThumbnail(){
		$path="/var/www/squid-pacific/master/uploads/files/"
		$seviye_books=Book::model()->findAll('author=:author',array('author' => 'Seviye Yayınları'));
		foreach ($seviye_books as $book) {
			$book_data=json_decode($book->data);
			$book_data['cover']=$this->base64_encode_image($path.$book->book_id."/page-1.jpg","jpeg");
			$book_data['thumbnail']=$book_data['cover'];
			$book->data=json_encode($book_data);
			if($book->save()){
				print_r($book->book_id."-->Saved");
			}
			else 
			{
				print_r(echo $book->getErrors());	
			}	

		}

	}
	private function base64_encode_image ($filename=string,$filetype=string) {
	    if ($filename) {
	        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
	        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
	    }
	}

}