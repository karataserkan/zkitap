<?php

class EditorActionsController extends Controller
{
	public function actionAddChapter()
	{
		$this->render('addChapter');
	}

	public function actionAddComponent()
	{
		$this->render('addComponent');
	}

	public function actionAddPage()
	{
		$this->render('addPage');
	}

	public function actionDeleteChapter()
	{
		$this->render('deleteChapter');
	}

	public function actionDeleteComponent()
	{
		$this->render('deleteComponent');
	}

	public function actionDeletePage()
	{
		$this->render('deletePage');
	}

	public function actionUpdateChapter()
	{
		$this->render('updateChapter');
	}

	public function actionUpdateComponent()
	{
		$this->render('updateComponent');
	}

	public function actionUpdatePage()
	{
		$this->render('updatePage');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}