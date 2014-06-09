<?php

class PageController extends Controller
{
	public $response=null; 
	public $errors=null; 

	public function response($response_avoition=null){

		$response['result']=$response_avoition ? $response_avoition : $this->response;
		if ($this->errors) $response['errors']=$this->errors;

		$response_string=json_encode($response);


		header('Content-type: plain/text');
		header("Content-length: " . strlen($response_string) ); // tells file size
		echo $response_string;
	}
 
	public function error($domain='PageActions',$explanation='Error', $arguments=null,$debug_vars=null ){
		$error=new error($domain,$explanation, $arguments,$debug_vars);
		$this->errors[]=$error; 
		return $error;
	}

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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','getPdfData','getPdfThumbnail','getComponent'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	public function actionCreate($book_id,$page_id=null,$pageTeplateId=null)
	{
		$currentPage=Page::model()->findByPk($page_id);

		if ($currentPage) {
			$chapter_id=$currentPage->chapter_id;
		}else{
			$chapter_id=$page_id;
		}
		
		//$pages=Page::model()->findAll('chapter_id=:chapter_id and `order` >'.$currentPage->order,array('chapter_id'=>$chapter_id));

		// foreach ($pages as $key => $page) {
		// 	$page->order+=1;
		// 	$page->save();
		// }

		$model=new Page;
		$new_id=functions::new_id();
		$model->page_id=$new_id;
		if ($chapter_id) {
			$chapter=Chapter::model()->findByPk($chapter_id);
		}
		else
		{
				$chapter= new Chapter;
				$chapter->chapter_id=functions::new_id();
				$chapter->book_id=$book_id;
				$chapter->save();
		}
		$model->chapter_id=$chapter->chapter_id;



		if ($currentPage->order) {
			$model->order=$currentPage->order+1;
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
			//$model->attributes=$_POST['Page'];
			if($model->save())
			{
				if (isset($pageTeplateId)) {
						$components = Component::model()->findAll(array(
							'condition' => 'page_id=:page_id',
							'params' => array(':page_id'=> $pageTeplateId)
							));

						if ($components) {
							foreach ($components as $ckey => $component) {
								$newComponent = new Component;
								$newComponent->id=functions::new_id();
								$newComponent->type=$component->type;
								$newComponent->data=$component->data;
								$newComponent->created=date("Y-m-d H:i:s");
								$newComponent->page_id=$new_id;
								$newComponent->save();
							}
						}
					}
				$this->redirect(array('book/author','bookId'=>$chapter->book_id,'page'=>$model->page_id));
			}
				
	

		
	}

	public function actionGetComponent($id)
	{
		if ($id) {
			$component=Component::model()->findByPk($id);
			if (!empty($component)) {
				$data=array();
				$data['id']=$component->id;
				$data['type']=$component->type;
				$data['data']=base64_decode($component->data);
				$data['created']=$component->created;
				$data['page_id']=$component->page_id;
				echo json_encode($data);
			}
			else
			{
				echo "component id not found!";
			}
		}
		else
		{
			echo "component id not sent!";
		}
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

		if(isset($_POST['Page']))
		{
			$model->attributes=$_POST['Page'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->page_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionGetPdfData($pageId)
	{

		$page=Page::model()->findByPk($pageId);

		$page_data=json_decode($page->pdf_data,true);

		$img=$page_data['image']['data'];

		$this->response($img);

	}

	public function actionGetPdfThumbnail($pageId)
	{

		$page=Page::model()->findByPk($pageId);

		$page_data=json_decode($page->pdf_data,true);

		$img=$page_data['thumnail']['data'];

		$this->response($img);

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
		$dataProvider=new CActiveDataProvider('Page');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Page('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
			$model->attributes=$_GET['Page'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Page the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Page::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Page $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
