<?php

class OrganisationHostingsController extends Controller
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
				'actions'=>array('create','update','delete','deleteHost','server'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
	public function actionCreate($organisationId)
	{
		$model=new OrganisationHostings;
		$model->organisation_id=$organisationId;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->hosting_client_id = functions::new_id(15);
		
		if(isset($_POST['OrganisationHostings']))
		{
			$model->attributes=$_POST['OrganisationHostings'];
			if($model->save())
				{
					$msg="ORGANISATION_HOSTINGS:CREATE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('organisationId'=>$organisationId,'hostingClientId'=>$model->hosting_client_id)));
					Yii::log($msg,'info');
					$this->redirect(array('index','organisationId'=>$model->organisation_id));
				}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionServer()
	{
		$model=new OrganisationHostings;
		$model->organisation_id=Yii::app()->request->getPost('organisationId');
		$server_address=Yii::app()->request->getPost('server_address');
		$server_port=Yii::app()->request->getPost('server_port');
		$status=Yii::app()->request->getPost('status');

		$model->hosting_client_id = functions::new_id(15);
		if(isset($_POST))
		{
			$retrieved_model=OrganisationHostings::model()->find('hosting_client_id=:hosting_client_id',array(':hosting_client_id'=>$status));
			if($retrieved_model){
				$retrieved_model->hosting_client_IP=$server_address;
				$retrieved_model->hosting_client_port=$server_port;
				if($retrieved_model->save())
				{
					echo "success";
				}
				else
				{
					echo "fail";
				}

			}
			else
			{

				$key1=functions::new_id(128);
				$key2=functions::new_id(128);
				
				$model->hosting_client_key1=$key1;
				$model->hosting_client_key2=$key2;
				$model->hosting_client_IP=$server_address;
				$model->hosting_client_port=$server_port;
				if($model->save())
					{
						$msg="ORGANISATION_HOSTINGS:CREATE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('organisationId'=>$organisationId,'hostingClientId'=>$model->hosting_client_id)));
						Yii::log($msg,'info');
						echo "success";
					}
					else
					{
						echo "fail";
					}
			}
		}
		else
		{
			echo "fail";
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($organisationId,$id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrganisationHostings']))
		{
			$model->attributes=$_POST['OrganisationHostings'];
			if($model->save())
			{
				$msg="ORGANISATION_HOSTINGS:UPDATE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('organisationId'=>$organisationId,'hostingClientId'=>$model->hosting_client_id)));
				Yii::log($msg,'info');
				$this->redirect(array('index','organisationId'=>$model->organisation_id));
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
	public function actionDelete($organisationId,$id)
	{
		$this->loadModel($id)->delete();
		//if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeleteHost($organisationId,$id)
	{
		$model=$this->loadModel($id);
		$msg="ORGANISATION_HOSTINGS:DELETE_HOST:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('organisationId'=>$organisationId,'hostingClientId'=>$model->hosting_client_id)));
		if ($model->delete()) {
			Yii::log($msg,'info');
		}
		$this->redirect(array('index','organisationId'=>$organisationId));
	}

	/**
	 * Lists all models of organisation.
	 */
	public function actionIndex($organisationId=null)
	{
		if(Yii::app()->user->isGuest)
			$this->redirect( array('/site/login' ) );

		$hostings= OrganisationHostings::model()->findAll('organisation_id=:organisation_id', 
	    				array(':organisation_id' => $organisationId) );
		
		$this->render('index',array(
			'hostings'=>$hostings,
			'organisationId'=>$organisationId
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrganisationHostings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrganisationHostings']))
			$model->attributes=$_GET['OrganisationHostings'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrganisationHostings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrganisationHostings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrganisationHostings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organisation-hostings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
