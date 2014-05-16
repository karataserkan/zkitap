<?php

class WorkspacesController extends Controller
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
				'actions'=>array('create','update','delete','deleteWorkspace','updateWorkspace'),
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
	public function actionCreate($organisationId=null)
	{
		$model=new Workspaces;
		$model_organisation=new OrganisationWorkspaces;
		$model_workspace=new WorkspacesUsers;

		$workspace_id=functions::new_id();
		$workspace_name=Yii::app()->request->getPost('workspace_name');
		$status=Yii::app()->request->getPost('status');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		echo Yii::app()->user->id;
		if(isset($_POST))
		{
			$model_organisation->organisation_id=Yii::app()->request->getPost('organisationId');
			$model_organisation->workspace_id=$workspace_id;

			$model->workspace_name=$workspace_name;
			$model->workspace_id=$workspace_id;

			$model_workspace->workspace_id=$workspace_id;
			$model_workspace->userid=(int)Yii::app()->user->id;
			$model_workspace->owner=Yii::app()->user->id;

			if($model->save()){
				if($model_organisation->save())
			 	{
			 	if($model_workspace->save())
			 		{
						echo "success";
					}
					else
					{
						print_r($model_workspace->getErrors());
						echo "fail 3";
					}
				}
				else
				{echo "fail2";}
			}
			else
			{
				echo "fail1";
			}

			/*
			$model->workspace_id=
			if($model->save())
			{
				$addWorkspaceOrganization = Yii::app()->db->createCommand();

				if($addWorkspaceOrganization->insert('organisation_workspaces', array(
				    'organisation_id'=>$organisationId,
				    'workspace_id'=>$model->workspace_id,
				)))
				{
					$msg="WORKSPACE:CREATE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('workspaceId'=>$model->workspace_id,'organisationId'=>$organisationId)));
					Yii::log($msg,'info');
				}
				else
				{
					$msg="WORKSPACE:CREATE:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('workspaceId'=>$model->workspace_id,'organisationId'=>$organisationId)));
					Yii::log($msg,'info');
				}

				$addWorkspaceOwner = Yii::app()->db->createCommand();
				$addWorkspaceOwner->insert('workspaces_users', array(
				    'workspace_id'=>$model->workspace_id,
				    'userid'=>Yii::app()->user->id,
				    'owner'=>'1',
				));

				//$this->redirect( array('organisations/workspaces?organizationId='.$organisationId ) );
			}*/
				
		}


		/*$this->render('create',array(
			'model'=>$model,
		));*/
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

		if(isset($_POST['Workspaces']))
		{
			$model->attributes=$_POST['Workspaces'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->workspace_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateWorkspace($id,$organisationId)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Workspaces']))
		{
			$model->attributes=$_POST['Workspaces'];
			if($model->save())
			{
				$msg="WORKSPACE:UPDATE_WORKSPACE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('workspaceId'=>$id,'organisationId'=>$organisationId)));
				Yii::log($msg,'info');
				$this->redirect( array('organisations/workspaces?organizationId='.$organisationId ) );
			}
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


	public function actionDeleteWorkspace($id,$organisationId)
	{
		$this->loadModel($id)->delete();

		$command = Yii::app()->db->createCommand();
		$command->delete('organisation_workspaces', 'organisation_id=:organisation_id && workspace_id=:workspace_id', array(':organisation_id'=>$organisationId,':workspace_id'=>$id));

		$this->redirect( array('organisations/workspaces?organizationId='.$organisationId ) );
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        //$workspacesOfuser = WorkspacesUsers::model()->findAll("userid=:userid", array(":userid",Yii::app()->user->id) ); 
        $criteria=new CDbCriteria(array(                    
                                'order'=>'creation_time desc',
                                'with'   => 'workspace_id',
                                'condition'=>'userid = ' . Yii::app()->user->id,

                        ));
       // print_r($workspacesOfuser);
        $dataProvider=new CActiveDataProvider('Workspaces'
        //	, array('criteria'=>$criteria)
        	);
	//	$dataProvider->setData($workspacesOfuser->workspace_id);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{		
		$model=new Workspaces('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Workspaces']))
			$model->attributes=$_GET['Workspaces'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Workspaces the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Workspaces::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Workspaces $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='workspaces-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
