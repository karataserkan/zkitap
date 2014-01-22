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
				'actions'=>array('create','update','selectTemplate','delete','view','author','newBook','selectData','uploadFile','copy'),
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


	/**
	 * Selection of book type.
	 * @param $bookType 'epub' || 'pdf'
	 */
	public function actionNewBook($bookType=null)
	{

		if ($bookType=='epub' || $bookType=='pdf') {
			$this->redirect(array('create','bookType'=>$bookType));
		}
		$this->render('new_book', array());
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($workspace=null,$book_id=null,$bookType='epub')
	{
		$model=new Book;
		$model->book_id=functions::new_id();//functions::get_random_string();
		
		$model->setData('book_type',$bookType);

		//seçilen bookType eklendi
		
		$model->created=date("Y-m-d");


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];

			//$model->pdf_file=CUploadedFile::getInstance($model,'pdf_file');
			//print($model->pdf_file);die();
			if($model->save())
				$msg="BOOK:CREATE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('BookId'=>$model->book_id,'workspaceId'=>$workspace,'bookType'=>$bookType)));
				Yii::log($msg,'info');
				$userid=Yii::app()->user->id;
				$addOwner = Yii::app()->db->createCommand();
				$addOwner->insert('book_users', array(
				    'user_id'=>$userid,
				    'book_id'=>$model->book_id,
				    'type'   =>'owner'
				));
				if($bookType=='epub'){
					$this->redirect(array('selectTemplate','bookId'=>$model->book_id));
				}
				else
				{
					$this->redirect(array('uploadFile','bookId'=>$model->book_id));
				}
		}


		$model->workspace_id=$workspace;
		$this->render('create',array(
			'model'=>$model,
		));

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
								$newChapter=Chapter::model()->find('title=:title',array('title'=>$toc_title));	
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
	public function actionSelectTemplate($bookId=null,$layout_id=null){ 

		$layouts= Book::model()->findAll(array(
		    'condition'=>'workspace_id=:workspace_id',
		    'params'=>array(':workspace_id'=>'layouts'),
		));

		if(isset($_GET['layout']))
		{
			

			$layout_id = $_GET['layout'];
			$bookId=$_GET['book_id'];

			$book=$this->loadModel($bookId);
			//book->data'ya template_id eklendi
			$book->setData('template_id',$layout_id);

			$book->save();


				
			$chapters= Chapter::model()->findAll(array(
				'condition' => 'book_id=:book_id',
				'params' => array(':book_id' => $layout_id),
			));
			if ($chapters) {
				foreach ($chapters as $key => $chapter) {
					$newchapterid=functions::new_id();//functions::get_random_string();
					$newChapter=new Chapter;
					$newChapter->book_id=$bookId;
					$newChapter->chapter_id=$newchapterid;
					$newChapter->title=$chapter->title;
					$newChapter->start_page=$chapter->start_page;
					$newChapter->order=$chapter->order;
					$newChapter->data=$chapter->data;
					$newChapter->created=date("Y-m-d H:i:s");
					$newChapter->save();

					$pages = Page::model()->findAll(array(
						'condition' => 'chapter_id=:chapter_id',
						'params' => array(':chapter_id'=> $chapter->chapter_id)
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
		$this->redirect(array('selectData','bookId'=>$bookId));	
		}

		$this->render('select_template',array(
			'layouts'=>$layouts,
			'book_id'=>$bookId,
		));

			
	}



	public function actionDuplicateBook($layout_id, $workspaceId=null){ 

			$layout=Book::model()->findByPk($layout_id);
			if (!$workspaceId) {
				$workspaceId=$layout->workspace_id;
			}
			$book= new Book;
			$bookId=functions::new_id();
			$book->book_id=$bookId;
			$book->workspace_id=$workspaceId;
			$book->title=$layout->title." Copy";
			$book->author=$layout->author;
			$book->created=date("Y-m-d H:i:s");
			$book->data=$layout->data;
			//book->data'ya template_id eklendi
			$book->setData('template_id',$layout_id);

			$book->save();
				
			$chapters= Chapter::model()->findAll(array(
				'condition' => 'book_id=:book_id',
				'params' => array(':book_id' => $layout_id),
			));
			if ($chapters) {
				foreach ($chapters as $key => $chapter) {
					$newchapterid=functions::new_id();//functions::get_random_string();
					$newChapter=new Chapter;
					$newChapter->book_id=$bookId;
					$newChapter->chapter_id=$newchapterid;
					$newChapter->title=$chapter->title;
					$newChapter->start_page=$chapter->start_page;
					$newChapter->order=$chapter->order;
					$newChapter->data=$chapter->data;
					$newChapter->created=date("Y-m-d H:i:s");
					$newChapter->save();

					$pages = Page::model()->findAll(array(
						'condition' => 'chapter_id=:chapter_id',
						'params' => array(':chapter_id'=> $chapter->chapter_id)
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
		
		// $meta=new UserMeta;
		// $meta->user_id=$user[0]->id;
		// $meta->meta_id=functions::new_id(40);
		// $meta->meta_data="password_reset";
		// $meta->created=time();
		// $meta->save();

		$model=$this->loadModel($bookId);
		
		$bookSize=$model->getPageSize();


		$this->render('author',array(
			'model'=>$model,
			'page_id'=>$page,
			'component_id'=>$component,
			'bookWidth'=>$bookSize['width'],
			'bookHeight'=>$bookSize['height']
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('site/index'));
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
