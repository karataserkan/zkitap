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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('mybooks','view','author'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','selectTemplate'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','delete'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($workspace=null,$book_id=null)
	{
		$model=new Book;
		$model->book_id=functions::get_random_string();
		$model->created=date("Y-m-d H:i:s");


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);




		if(isset($_POST['Book']))
		{
			$model->attributes=$_POST['Book'];

			if($model->save())
				$this->redirect(array('selectTemplate','bookId'=>$model->book_id));
		}


		$model->workspace_id=$workspace;
		$this->render('create',array(
			'model'=>$model,
		));

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
			
			if ($layout_id == 'blank') {
				$this->redirect(array('author','bookId'=>$bookId));
			}
			
			
			
			$chapters= Chapter::model()->findAll(array(
				'condition' => 'book_id=:book_id',
				'params' => array(':book_id' => $layout_id),
			));
			if ($chapters) {
				foreach ($chapters as $key => $chapter) {
					$newchapterid=functions::get_random_string();
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
							$newpageid=functions::get_random_string();
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
									$newComponent->id=functions::get_random_string();
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

		

		$this->render('select_template',array(
			'layouts'=>$layouts,
			'book_id'=>$bookId,
		));

			
	}



	public function actionAuthor($bookId,$page=null,$component=null){ 
		$model=$this->loadModel($bookId);
		
		$this->render('author',array(
			'model'=>$model,
			'page_id'=>$page,
			'component_id'=>$component
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
