<?php

class BookController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actionMybooks(){
		$this->redirect( array('site/index' ) );
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('mybooks'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','selectTemplate','delete','view','author','newBook','selectData','uploadFile','duplicateBook','updateCover',"copyBook","createTemplate","updateBookTitle","getBookPages",'bookCreate','getTemplates','createNewBook','fastStyle','getFastStyle','updateThumbnail','manageDemo'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionFastStyle()
	{
			if (isset($_POST['styles'])) {
				$styles=json_decode($_POST['styles']);
				$book=$this->loadModel($styles[0]->value);
				$component=$styles[1]->value;
				unset($styles[0]);
				unset($styles[1]);
				foreach ($styles as $type => $style) {
					$book->setFastStyle($component,$style->name,$style->value);
				}
				$book->save();
			}
		
	}

	public function actionGetFastStyle()
	{
		if (isset($_POST['book_id']) & isset($_POST['component'])) {
			$book=$this->loadModel($_POST['book_id']);
			echo $book->getFastStyle($_POST['component']);

		}
	}

	public function actionBookCreate()
	{
		$file_form=new FileForm();
		$userid=Yii::app()->user->id;
		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->join("user u","x.userid=u.id")
	    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
	    
	    $templates=Yii::app()->db->createCommand()
		->select ("*")
		->from("organisations_meta")
		->where("meta=:meta", array(':meta' => 'template'))
		->queryAll();

	    foreach ($templates as $key => $template) {
	    	foreach ($workspacesOfUser as $key => $workspace) {
		    	if ($template['value']===$workspace['workspace_id']) {
		    		$templateWorkspaces[]=$workspace;
		    		unset($workspacesOfUser[$key]);
		    	}
	    	}
	    }

		$workspace_id_value = CHtml::listData($workspacesOfUser, 
                'workspace_id', 'workspace_name');

		$this->render('book_create',array('workspaces'=>$workspace_id_value,
										'model'=>$file_form));
	}

	public function actionCreateNewBook()
	{
		$this->layout=false;
		$userid=Yii::app()->user->id;
		$book["book_type"] = ( isset( $_POST['book_type'] ) ) ? $_POST['book_type'] : false ;
		$book["book_name"] = ( isset( $_POST['book_name'] ) ) ? $_POST['book_name'] : false ;
		$book["book_author"] = ( isset( $_POST['book_author'] ) ) ? $_POST['book_author'] : false ;
		$book["workspaces"] = ( isset( $_POST['workspaces'] ) ) ? $_POST['workspaces'] : false ;
		$book["book_size"] = ( isset( $_POST['book_size'] ) ) ? $_POST['book_size'] : false ;
		$book["templates"] = ( isset( $_POST['templates'] ) ) ? $_POST['templates'] : false ;
		$book["pdf"] = ( isset( $_FILES['pdf'] ) ) ? $_FILES['pdf'] : false ;
		
		if ($book["book_type"] & $book["book_name"] & $book["book_author"] & $book["workspaces"]) {
			if ($book["book_type"]=='epub') {  
				$this->layout=false;
				$newBook=new Book;
				$newBook->book_id=functions::new_id();
				$newBook->workspace_id=$book['workspaces'];
				$newBook->title=$book['book_name'];
				$newBook->author=$book['book_author'];
				$newBook->created=date("Y-m-d H:i:s");
				$newBook->setData('book_type',$book['book_type']);
				$bookSize=explode('x', $book['book_size']);
				$newBook->setPageSize($bookSize[0],$bookSize[1]);
				$newBook->setData('template_id',$book['templates']);

				if ($newBook->save()) {
					$msg="BOOK:CREATE:0:". json_encode(array(array('user'=>$userid),array('BookId'=>$newBook->book_id,'workspaceId'=>$newBook->workspace_id,'bookType'=>$book['book_type'])));
					Yii::log($msg,'info');
					$addOwner = Yii::app()->db->createCommand();
					$addOwner->insert('book_users', array(
					    'user_id'=>$userid,
					    'book_id'=>$newBook->book_id,
					    'type'   =>'owner'
					));
					$this->copy($newBook->book_id,$book['templates']);
					echo $newBook->book_id;
				}
			}
			elseif ($book["book_type"]=='pdf') { 
				// print_r($book);
				// die();
				$this->layout=false;
				$newBook=new Book;
				$newBook->book_id=functions::new_id();
				$newBook->workspace_id=$book['workspaces'];
				$newBook->title=$book['book_name'];
				$newBook->author=$book['book_author'];
				$newBook->created=date("Y-m-d H:i:s");
				$newBook->setData('book_type',$book['book_type']);
				$newBook->save();
				$addOwner = Yii::app()->db->createCommand();
					$addOwner->insert('book_users', array(
					    'user_id'=>$userid,
					    'book_id'=>$newBook->book_id,
					    'type'   =>'owner'
					));
				$bookId=$newBook->book_id;
				
				$file_form=new FileForm();
				$file_form->attributes=$_POST['FileForm'];
				$file_form->pdf_file=CUploadedFile::getInstance($file_form,'pdf_file');
				//echo $file_form->pdf_file;
				$filePath=Yii::app()->basePath.'/../uploads/files/'.$bookId;
				if(!is_dir($filePath))
					mkdir($filePath);
				$file_form->pdf_file->saveAs($filePath.'/'.$bookId.'.pdf');
				$pdfUtil=new PdfUtil($filePath,$bookId);
				$pdfUtil->extractImages();
				$pdfUtil->extractSearchIndex();
				$tocs=$pdfUtil->extractTableofContents();
				$nop=$pdfUtil->getNumberofPages();
				if($tocs==null){
					for($i=1;$i<=$nop;$i++){
						$imgPath=$filePath.'/page-'.$i.'.jpg';
						$imgThumbnailPath=$filePath.'/thumbnailpage-'.$i.'.jpg';
						$imgData=base64_encode(file_get_contents($imgPath));
						$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;
						$imgData=$this->getPDFData($filePath,$i,'');
						if($i==1){
							$chapter=new Chapter();
							$chapter->chapter_id=functions::new_id();
							$chapter->book_id=$bookId;
							$chapter->order=$i;
							$chapter->title=__("Bölüm")."-".$i;
							$chapter->save();
						}
						$page=new Page();
						$page->chapter_id=$chapter->chapter_id;
						$page->pdf_data=$imgData;
						$page->order=$i;
						$page->page_id=functions::new_id();
						$page->save();
						//print $i;

					}
					$msg="BOOK:UPLOAD_FILE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('BookId'=>$bookId)));
					Yii::log($msg,'info');
					$this->setBookData($filePath,$bookId);
					//$this->redirect('/book/author/'.$bookId);
				}
				else{
						// print_r($tocs);
						for($i=1;$i<=$nop;$i++){
							$belongs_to_chapter=null;
							foreach($tocs as $toc){
								//list($toc_title,$start_page,$end_page)=$toc;
								$toc_title=$toc['toc_title'];
								$start_page=$toc['start_page'];
								$end_page=$toc['end_page'];
								if((int)$start_page<=$i && $i<=(int)$end_page){
										$belongs_to_chapter=$toc;
									}
								
								}
							
							if($belongs_to_chapter!=null){
									$toc_title=$belongs_to_chapter['toc_title'];
									$start_page=$belongs_to_chapter['start_page'];
									$end_page=$belongs_to_chapter['end_page'];		
									$newChapter=Chapter::model()->find('title=:title AND book_id=:book_id',array('title'=>$toc_title,'book_id'=>$bookId));	
									if($newChapter==null){
										$newChapter=new Chapter();
										$newChapter->chapter_id=functions::new_id();
										$newChapter->book_id=$bookId;
										$newChapter->order=$i;
										$newChapter->title=$toc_title;
										$newChapter->save();
									}
									$imgPath=$filePath.'/page-'.$i.'.jpg';
									$imgThumbnailPath=$filePath.'/thumbnailpage-'.$i.'.jpg';
									$imgData=base64_encode(file_get_contents($imgPath));
									$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;
									$page=new Page();
									$page->chapter_id=$newChapter->chapter_id;
									//ekaratas edited -begin
									$imgData=$this->getPDFData($filePath,$i,'');

								
									// ekaratas -end

									$page->pdf_data=$imgData;
									$page->order=$i;
									$page->page_id=functions::new_id();
									$page->save();
								}
								else{
										
										$newChapter=new Chapter();
										$newChapter->chapter_id=functions::new_id();
										$newChapter->book_id=$bookId;
										$newChapter->title=__("Bölüm")."-".$i;
										$newChapter->order=$i;
										$newChapter->save();
										$imgPath=$filePath.'/page-'.$i.'.jpg';
										$imgThumbnailPath=$filePath.'/thumbnailpage-'.$i.'.jpg';
										$imgData=base64_encode(file_get_contents($imgPath));
										$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;
										$page=new Page();
										$page->chapter_id=$newChapter->chapter_id;

										//ekaratas edited -begin
										$imgData=$this->getPDFData($filePath,$i,'');

										// ekaratas -end


										$page->pdf_data=$imgData;
										$page->order=$i;
										$page->page_id=functions::new_id();
										$page->save();

								}

							}
							$msg="BOOK:UPLOAD_FILE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('BookId'=>$bookId)));
							Yii::log($msg,'info');

							$this->setBookData($filePath,$bookId);
							// $this->redirect('/book/author/'.$bookId);

					}
				
					echo $bookId;
				}
		}
	}

	

	public function actionGetTemplates($id)
	{
		$sizes=$bookSize=explode('x', $id);
		$width=$sizes[0];
		$height=$sizes[1];

		$userid=Yii::app()->user->id;
		$templateWorkspaces=array();

		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->join("user u","x.userid=u.id")
	    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
		
		$templates=Yii::app()->db->createCommand()
		->select ("*")
		->from("organisations_meta")
		->where("meta=:meta", array(':meta' => 'template'))
		->queryAll();

	    foreach ($templates as $key => $template) {
	    	foreach ($workspacesOfUser as $key => $workspace) {
		    	if ($template['value']===$workspace['workspace_id']) {
		    		$templateWorkspaces[]=$workspace;
		    		unset($workspacesOfUser[$key]);
		    	}
	    	}
	    }

	    $templateBooks=array();
		foreach ($templateWorkspaces as $key => $templateWorkspace) {
			$temp = Book::model()->findAll(array(
		    'condition'=>'workspace_id=:workspace_id',
		    'params'=>array(':workspace_id'=>$templateWorkspace['workspace_id']),
			));

			foreach ($temp as $key2 => $tem) {
				$pageSize=$tem->getPageSize();
				if ($pageSize['width']==$width & $pageSize['height']==$height) {
					$templateBooks[]=$tem;
				}
			}
		}

		$main_templates= Book::model()->findAll(array(
		    'condition'=>'workspace_id=:workspace_id',
		    'params'=>array(':workspace_id'=>'layouts'),
		));
		foreach ($main_templates as $key2 => $tem) {
				$pageSize=$tem->getPageSize();
				if ($pageSize['width']==$width & $pageSize['height']==$height) {
					$templateBooks[]=$tem;
				}
		}
		$book_templates=array();
		foreach ($templateBooks as $key3 => $book) {
			$book_templates[$key3]['id']=$book->book_id;
			$book_templates[$key3]['title']=$book->title;
			$book_templates[$key3]['thumbnail']=($book->getData('thumbnail'))?$book->getData('thumbnail'):'';
		}
		print_r(json_encode($book_templates));
	}

	public function copy($book_id,$template_id)
	{
		if (!$template_id) {
			$newchapterid=functions::new_id();//functions::get_random_string();
			$newChapter=new Chapter;
			$newChapter->book_id=$book_id;
			$newChapter->chapter_id=$newchapterid;
			$newChapter->title='Bölüm 1';
			$newChapter->order=0;
			$newChapter->created=date("Y-m-d H:i:s");
			$newChapter->save();

			$newpageid=functions::new_id();//functions::get_random_string();
			$newPage= new Page;
			$newPage->page_id=$newpageid;
			$newPage->created=date("Y-m-d H:i:s");
			$newPage->chapter_id=$newchapterid;
			$newPage->order=0;
			$newPage->save();

		}
		$chapters= Chapter::model()->findAll(array(
				'condition' => 'book_id=:book_id',
				'params' => array(':book_id' => $template_id),
				'order' => 'created'
			)
		);
			if ($chapters) {
				foreach ($chapters as $key => $chapter) {
					$newchapterid=functions::new_id();//functions::get_random_string();
					$newChapter=new Chapter;
					$newChapter->book_id=$book_id;
					$newChapter->chapter_id=$newchapterid;
					$newChapter->title=$chapter->title;
					$newChapter->start_page=$chapter->start_page;
					$newChapter->order=$chapter->order;
					$newChapter->data=$chapter->data;
					$newChapter->created=date("Y-m-d H:i:s");
					$newChapter->save();

					$pages = Page::model()->findAll(array(
						'condition' => 'chapter_id=:chapter_id',
						'params' => array(':chapter_id'=> $chapter->chapter_id),
					));
					if ($pages) {
						foreach ($pages as $pkey => $page) {
							$newpageid=functions::new_id();//functions::get_random_string();
							$newPage= new Page;
							$newPage->page_id=$newpageid;
							$newPage->created=date("Y-m-d H:i:s");
							$newPage->chapter_id=$newchapterid;
							$newPage->data=$page->data;
							$newPage->order=$page->order;
							$newPage->save();

							$components = Component::model()->findAll(array(
								'condition' => 'page_id=:page_id',
								'params' => array(':page_id'=> $page->page_id)
								));

							if ($components) {
								foreach ($components as $ckey => $component) {
									$newComponent = new Component;
									$newComponent->id=functions::new_id();//functions::get_random_string();
									$newComponent->type=$component->type;
									$newComponent->data=$component->data;
									$newComponent->created=date("Y-m-d H:i:s");
									$newComponent->page_id=$newpageid;
									$newComponent->save();
								}
							}

						}
					}
					
				}

			}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreateTemplate($id)
	{
		if (isset($_POST['isim'])&isset($_POST['yazar'])) {
				$model=new Book;
				$model->book_id=functions::new_id();
				$model->workspace_id=$id;
				$model->title=$_POST['isim'];
				$model->author=$_POST['yazar'];
				$model->created=date("Y-m-d H:i:s");
				if (isset($_POST['size'])) {
					$bookSize=explode('x', $_POST['size']);
				}
				else
				{
					$bookSize=array('1024','768');
				}
				$model->setPageSize($bookSize[0],$bookSize[1]);
				if ($model->save()) {
					$userid=Yii::app()->user->id;
					$addOwner = Yii::app()->db->createCommand();
					$addOwner->insert('book_users', array(
					    'user_id'=>$userid,
					    'book_id'=>$model->book_id,
					    'type'   =>'owner'
					));
					
					$this->redirect('/book/author/'.$model->book_id);
				}				
				//{"book_type":"pdf","size":{"width":1275,"height":1650}}
		}
		$this->render('create_template',array('workspace_id'=>$id));
	}

	public function actionGetBookPages($id)
	{
		if (!$id) {
			return null;
		}
		$data=array();
		$chapters=Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" => array(':book_id' => $id )));
		foreach ($chapters as $key => $chapter) {
				$data[$key]=$chapter->attributes;
				$pages=Page::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $chapter->chapter_id )) );
				if ($pages) {
					foreach ($pages as $key2 => $page) {
						$data[$key]['pages'][$key2]=$page->attributes;
					}
				}
				else{
					$data[$key]['pages'][]=null;
				}
			}
		echo json_encode($data);
	}


	private function getPDFData($filePath,$pageNumber,$pageJSON){
		$data=array();
		$imgPath=$filePath.'/page-'.$pageNumber.'.jpg';
		$imgThumbnailPath=$filePath.'/thumbnailpage-'.$pageNumber.'.jpg';

		$imgData=base64_encode(file_get_contents($imgPath));
		$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;

		$thumbnailData=base64_encode(file_get_contents($imgThumbnailPath));
		$thumbnailData= 'data: '.mime_content_type($imgThumbnailPath).';base64,'.$thumbnailData;

		$data['image']['data']=$imgData;
		$data['thumnail']['data']=$thumbnailData;

		list($image_width, $image_height, $type, $attr) = getimagesize($imgPath);
		$data['image']['size']['width']=$image_width;
		$data['image']['size']['height']=$image_height;

		list($image_width, $image_height, $type, $attr) = getimagesize($imgThumbnailPath);
		$data['thumnail']['size']['width']=$image_width;
		$data['thumnail']['size']['height']=$image_height;		

		$data['pageJSON']=$pageJSON;
		return json_encode($data);


	}
	private function setBookData($filePath,$bookId){

		$imgPath=$filePath.'/page-1.jpg';
		list($image_width, $image_height, $type, $attr) = getimagesize($imgPath);
		$model=Book::model()->findByPk($bookId);
		$model->setPageSize($image_width*0.5,$image_height*0.5);
		$model->save();

	}
	public function actionUploadFile($bookId)
	{
		$date = date('m/d/Y h:i:s a', time());
		$file_form=new FileForm();

		if (isset($_POST['FileForm'])) {
			$file_form->attributes=$_POST['FileForm'];
			$file_form->pdf_file=CUploadedFile::getInstance($file_form,'pdf_file');
			//echo $file_form->pdf_file;
			$filePath=Yii::app()->basePath.'/../uploads/files/'.$bookId;
			if(!is_dir($filePath))
				mkdir($filePath);
			$file_form->pdf_file->saveAs($filePath.'/'.$bookId.'.pdf');
			$pdfUtil=new PdfUtil($filePath,$bookId);
			$pdfUtil->extractImages();
			$pdfUtil->extractSearchIndex();
			$tocs=$pdfUtil->extractTableofContents();
			$nop=$pdfUtil->getNumberofPages();
			if($tocs==null){
				for($i=1;$i<=$nop;$i++){
					$imgPath=$filePath.'/page-'.$i.'.jpg';
					$imgThumbnailPath=$filePath.'/thumbnailpage-'.$i.'.jpg';
					$imgData=base64_encode(file_get_contents($imgPath));
					$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;
					$imgData=$this->getPDFData($filePath,$i,'');
					if($i==1){
						$chapter=new Chapter();
						$chapter->chapter_id=functions::new_id();
						$chapter->book_id=$bookId;
						$chapter->order=$i;
						$chapter->title=__("Bölüm")."-".$i;
						$chapter->save();
					}
					$page=new Page();
					$page->chapter_id=$chapter->chapter_id;
					$page->pdf_data=$imgData;
					$page->order=$i;
					$page->page_id=functions::new_id();
					$page->save();
					print $i;

				}
				$msg="BOOK:UPLOAD_FILE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('BookId'=>$bookId)));
				Yii::log($msg,'info');
				$this->setBookData($filePath,$bookId);
				$this->redirect('/book/author/'.$bookId);
			}
			else{
					print_r($tocs);
					for($i=1;$i<=$nop;$i++){
						$belongs_to_chapter=null;
						foreach($tocs as $toc){
							//list($toc_title,$start_page,$end_page)=$toc;
							$toc_title=$toc['toc_title'];
							$start_page=$toc['start_page'];
							$end_page=$toc['end_page'];
							if((int)$start_page<=$i && $i<=(int)$end_page){
									$belongs_to_chapter=$toc;
								}
							
							}
						
						if($belongs_to_chapter!=null){
								$toc_title=$belongs_to_chapter['toc_title'];
								$start_page=$belongs_to_chapter['start_page'];
								$end_page=$belongs_to_chapter['end_page'];		
								$newChapter=Chapter::model()->find('title=:title AND book_id=:book_id',array('title'=>$toc_title,'book_id'=>$bookId));	
								if($newChapter==null){
									$newChapter=new Chapter();
									$newChapter->chapter_id=functions::new_id();
									$newChapter->book_id=$bookId;
									$newChapter->order=$i;
									$newChapter->title=$toc_title;
									$newChapter->save();
								}
								$imgPath=$filePath.'/page-'.$i.'.jpg';
								$imgThumbnailPath=$filePath.'/thumbnailpage-'.$i.'.jpg';
								$imgData=base64_encode(file_get_contents($imgPath));
								$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;
								$page=new Page();
								$page->chapter_id=$newChapter->chapter_id;
								//ekaratas edited -begin
								$imgData=$this->getPDFData($filePath,$i,'');

							
								// ekaratas -end

								$page->pdf_data=$imgData;
								$page->order=$i;
								$page->page_id=functions::new_id();
								$page->save();
							}
							else{
									
									$newChapter=new Chapter();
									$newChapter->chapter_id=functions::new_id();
									$newChapter->book_id=$bookId;
									$newChapter->title=__("Bölüm")."-".$i;
									$newChapter->order=$i;
									$newChapter->save();
									$imgPath=$filePath.'/page-'.$i.'.jpg';
									$imgThumbnailPath=$filePath.'/thumbnailpage-'.$i.'.jpg';
									$imgData=base64_encode(file_get_contents($imgPath));
									$imgData= 'data: '.mime_content_type($imgPath).';base64,'.$imgData;
									$page=new Page();
									$page->chapter_id=$newChapter->chapter_id;

									//ekaratas edited -begin
									$imgData=$this->getPDFData($filePath,$i,'');

									// ekaratas -end


									$page->pdf_data=$imgData;
									$page->order=$i;
									$page->page_id=functions::new_id();
									$page->save();

							}

						}
						$msg="BOOK:UPLOAD_FILE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('BookId'=>$bookId)));
						Yii::log($msg,'info');

						$this->setBookData($filePath,$bookId);
						$this->redirect('/book/author/'.$bookId);

			}
			
			
			//die();

		}
			$model=$this->loadModel($bookId);
			$this->render('upload_file',array(
			'model'=>$file_form));

	}
	
	//demo hesabını düzenlemek için
	//hatalı fonksiyon şimdilik
	public function actionManageDemo()
	{
		$organisation_id="SZaFaR3cwct6PrEJmUibyJV6lHFnrNOrH5HGKdMq5l4B";
		$workspace_id="ghwj7r2jeSIcisP6k2WB0ZmZCPNcqG2pe8crTx6EEaTS";
		$budget=$this->getOrganisationBudget($organisation_id);
		$budget=($budget[4]['amount'])?$budget[4]['amount']:'0' ;
		$addBudgetAmount=(100- (int) $budget);
		if ($addBudgetAmount>10) {
			$addBudget = Yii::app()->db->createCommand("INSERT INTO `transactions`(`transaction_id`, `transaction_type`, `transaction_method`, `transaction_amount`, `transaction_unit_price`, `transaction_amount_equvalent`, `transaction_currency_code`, `transaction_result`,`transaction_organisation_id`)
																				VALUES ('".functions::new_id(30)."','epub','deposit',".$addBudgetAmount.",0,0,840,0,'".$organisation_id."')")->queryRow();
		}

		$templates=array("5XnjyrR4UFgxiVdP62GnrXRb2aNbDUlWdGiZaWUXdfew","pcRva5dQ93puNONLkSfXnMyR7jYN1yNcU1nSM47AquPG","wy7QLbapB2H2k5IzJXANBkdTterGK1Cm7cYOEW6g0Tgo");
		
		$workspaces=OrganisationWorkspaces::model()->findAll('organisation_id=:organisation_id',array('organisation_id'=>$organisation_id));
		foreach ($workspaces as $key => $workspace) {
			$workspace_books= Book::model()->findAll('workspace_id=:workspace_id AND (publish_time IS NULL OR publish_time=0)', 
		    				array(':workspace_id' => $workspace->workspace_id) );
			foreach ($workspace_books as $key => $book) {
				$book->delete();
			}
		}


		foreach ($templates as $key => $template) {
			$this->duplicateBook($template,$workspace_id);
		}


	}


	public function actionCopyBook($bookId,$workspaceId,$title=null)
	{
		if ($bookId & $workspaceId) {
			$newId=$this->duplicateBook($bookId,$workspaceId,$title);
			if ($newId) {
				$this->redirect(array('author','bookId'=>$newId));
			}
		}
		$this->redirect("/site/index");
	}

	public function duplicateBook($layout_id, $workspaceId=null,$title=null){ 


			$layout=Book::model()->findByPk($layout_id);
			if (!$workspaceId) {
				$workspaceId=$layout->workspace_id;
			}
			$book= new Book;
			$bookId=functions::new_id();
			$book->book_id=$bookId;
			$book->workspace_id=$workspaceId;
			$book->title=$title;
			if (!$title) {
				$book->title="Copy of ".$layout->title;
			}
			$book->author=$layout->author;
			$book->created=date("Y-m-d H:i:s");
			$book->data=$layout->data;
			//book->data'ya template_id eklendi
			$book->setData('template_id',$layout_id);

			$book->save();
			$userId=Yii::app()->user->id;
			$addUser = Yii::app()->db->createCommand();
			$type="owner";
			if($addUser->insert('book_users', array(
			    'user_id'=>$userId,
			    'book_id'=>$bookId,
			    'type'   =>$type
			)))
			{
				$msg="SITE:RIGHT:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId,'type'=>$type)));
				Yii::log($msg,'info');
			}
			else
			{
				$msg="SITE:RIGHT:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId,'type'=>$type)));
				Yii::log($msg,'info');
			}
			$this->copy($bookId, $layout_id);

		$this->redirect(array('author','bookId'=>$bookId));
	}


	/**
	 * display selectdata form and set data
	 * @param  string $bookId id of the book
	 * @return [type]         [description]
	 */
	public function actionSelectData($bookId=null,$id=null){

		if($bookId==null){
			$bookId=$id;
		}
		
		$book=$this->loadModel($bookId);
		
		/**
		 * BookDataForm -> CFormModel
		 * @var BookDataForm
		 */
		$model = new BookDataForm;
		if (isset($_POST['BookDataForm']['size'])) {
			$book=$this->loadModel($bookId);
			//book->data'ya size eklendi
			
			$bookSize=explode('x', $_POST['BookDataForm']['size']);
			$book->setPageSize($bookSize[0],$bookSize[1]);

			$book->save();
			$this->redirect(array('author','bookId'=>$bookId));
		}
		
		$this->render('select_data',array(
			'book_id'=>$bookId,
			'model' => $model
		));
	}

	public function actionAuthor($bookId=null,$page=null,$component=null,$id=null,$id2=null){
		$this->layout = '//layouts/author';
		if($bookId==null){
			$bookId=$id;
		}
		
		if($page==null)
		{
			$page=$id2;
		}
		
		$userId=Yii::app()->user->id;
		$isUserBook=UserBook::model()->findAll("user_id=:user_id AND book_id=:book_id AND (type='editor' OR type='owner')", array('user_id'=>$userId,'book_id'=>$bookId));

		if (! $isUserBook) {
			$this->redirect('/site/index');
		}

		$detectSQLinjection=new detectSQLinjection($page);
		if (!$detectSQLinjection->ok()) {
			error_log("detectSQLinjection BC:A: ".$Yii::app()->user->id." page: ".$page);
			$this->redirect('/site/index');	
		}

		$detectSQLinjection=new detectSQLinjection($bookId);
		if (!$detectSQLinjection->ok()) {
			error_log("detectSQLinjection BC:A:".$Yii::app()->user->id." bookId: ".$bookId);
			$this->redirect('/site/index');	
		}



		Yii::app()->db
		    ->createCommand("DELETE FROM user_meta WHERE user_id=:user_id AND meta_value=:meta_value AND meta_key=:meta_key")
		    ->bindValues(array(':user_id' => Yii::app()->user->id, ':meta_value' => $bookId,':meta_key'=>'lastEditedBook'))
		    ->execute();


		$meta=new UserMeta;
		$meta->user_id=Yii::app()->user->id;
		$meta->meta_key="lastEditedBook";
		$meta->meta_value=$bookId;
		$meta->created=time();
		$meta->save();

		$model=$this->loadModel($bookId);
		
		$bookSize=$model->getPageSize();

		$ow=OrganisationWorkspaces::model()->find('workspace_id=:workspace_id',array('workspace_id'=>$model->workspace_id));
		$budget=$this->getOrganisationBudget($ow->organisation_id);
		$budget=($budget[4]['amount'])?$budget[4]['amount']:'0' ;

		functions::event('tripData',NULL, function($var){
			@include ('js/lib/trips/book/author.json');
		});


		$this->render('author',array(
			'model'=>$model,
			'page_id'=>$page,
			'component_id'=>$component,
			'bookWidth'=>$bookSize['width'],
			'bookHeight'=>$bookSize['height'],
			'budget'=>$budget
		)); 
	}

	

	public function actionSelectLayout($bookId){

	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->book_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionUpdateThumbnail($id,$bookId=null)
	{
		$bookId = ($id) ? $id : $bookId ;

		$book=Book::model()->findByPk($bookId);

		if (isset($_POST['img'])) {
			$bookData=json_decode($book->data,true);
			$bookData['thumbnail']=$_POST['img'];
			$book->data=json_encode($bookData);
			$book->save();
		}
	}

	public function actionUpdateCover($id,$bookId=null)
	{
		$bookId = ($id) ? $id : $bookId ;

		$book=Book::model()->findByPk($bookId);

		if (isset($_POST['img'])) {
			$bookData=json_decode($book->data,true);
			$bookData['cover']=$_POST['img'];
			$book->data=json_encode($bookData);
			$book->save();
		}
	}

	public function actionUpdateBookTitle($bookId,$title)
	{
		$book=$this->loadModel($bookId);
		$book->title=$title;
		$book->save();
		$this->redirect(array('site/index'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($bookId=null,$id=null)
	{ 
		if($bookId==null){
			$bookId=$id;
		}
		
		if (isset($bookId)) {
			$this->loadModel($bookId)->delete();
			$msg="BOOK:DELETE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('BookId'=>$bookId)));
			Yii::log($msg,'info');
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		/*if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('site/index'));*/
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Book');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Book('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Book']))
			$model->attributes=$_GET['Book'];

		$this->render('admodelmin',array(
			'model'=>$model,
		));
	}

	public function getOrganisationBudget($id)
	{
		$budget = Yii::app()->db->createCommand("select transaction_type, transaction_organisation_id,  SUM(amount)  as amount 
			from ( select transaction_type, transaction_organisation_id, transaction_currency_code, SUM(transaction_amount) as amount , SUM(transaction_amount_equvalent) as amount_equvalent  
		from transactions 
		where transaction_result = 0 and transaction_method = 'deposit'  
		group by transaction_type, transaction_organisation_id  
		Union select transaction_type, transaction_organisation_id, transaction_currency_code,  -1 * SUM(transaction_amount) as amount , -1 * SUM(transaction_amount_equvalent) as amount_equvalent  
		from transactions where transaction_result = 0 and transaction_method = 'withdrawal'  group by transaction_type, transaction_organisation_id, transaction_currency_code ) as tables 
		group by transaction_type, transaction_organisation_id")->queryAll();

		foreach ($budget as $key => $tr) {
			if ($tr['transaction_organisation_id']!=$id)
				{
					unset($budget[$key]);
				}
		}

		return $budget;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Book the lomodeladed model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Book::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Book $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='book-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	protected function add($model){

	}
}
