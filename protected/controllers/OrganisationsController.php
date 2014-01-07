<?php

class OrganisationsController extends Controller
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
				'actions'=>array('create','update','workspaces','delWorkspaceUser','addWorkspaceUser','users','addUser','deleteOrganisationUser'),
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
	public function actionCreate()
	{
		$model=new Organisations;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Organisations']))
		{
			$model->attributes=$_POST['Organisations'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->organisation_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['Organisations']))
		{
			$model->attributes=$_POST['Organisations'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->organisation_id));
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
	public function actionIndex($organizationId=null)
	{
		$dataProvider=new CActiveDataProvider('Organisations');
		$this->render('index',array(
			'organizationId' => $organizationId,		
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * organisation's workspaces
	 * @param  varchar $organizationId
	 */
	public function actionWorkspaces($organizationId=null)
	{
		if(Yii::app()->user->isGuest)
			$this->redirect( array('site/login' ) );

		/**
		 * if $organisationId set
		 */
		if ($organizationId) {
			$organizationUser = Yii::app()->db->createCommand()
		    ->select("*")
		    ->from("organisation_users")
		    ->where("user_id=:user_id", array(':user_id' => Yii::app()->user->id))
		    ->queryRow();

		    /**
		     * [$isOrganizationUser whether user has this organization]
		     * @var user | null
		     */
		    $isOrganizationUser = ($organizationUser) ? $organizationUser : null ;
		    if ($isOrganizationUser) {

		    	$workspaces = Yii::app()->db->createCommand()
				    ->select("*")
				    ->from("organisation_workspaces x")
				    ->join("workspaces w",'w.workspace_id=x.workspace_id')
				    ->where("organisation_id=:organisation_id", array(':organisation_id' => $organizationId ) )
				    ->queryAll();

				$this->render('workspaces',array(
					'organizationUser' => $organizationUser,
					'workspaces' => $workspaces
					));
		    }
		}
	}

	/**
	 * [workspaceUsers]
	 * @param  varchar $workspace_id 
	 * @return array               
	 */
	public function workspaceUsers($workspace_id)
	{
		$workspaceUsers = Yii::app()->db->createCommand()
		->select ("*")
		->from("workspaces_users")
		->where("workspace_id=:workspace_id", array(':workspace_id' => $workspace_id))
		->join("user","userid=id")
		->queryAll();

		return $workspaceUsers;
	}

	/**
	 * [organizationUsers]
	 * @param  varchar $organisationId
	 * @return array           
	 */
	public function organizationUsers($organisationId)
	{
		$organizationUsers = Yii::app()->db->createCommand()
		->select ("*")
		->from("organisation_users")
		->where("organisation_id=:organisation_id", array(':organisation_id' => $organisationId ) )
		->join("user","user_id=id")
		->queryAll();

		return $organizationUsers;
	}

	/**
	 * [noneWorkspaceUsers description]
	 * @param  varchar $workspace_id   ID
	 * @param  varchar $organisationId ID
	 * @return array                 users who are in organisation but not in workspace
	 */
	public function freeWorkspaceUsers($workspace_id,$organisationId)
	{
		$workspaceUsers=$this->workspaceUsers($workspace_id);
		$organizationUsers=$this->organizationUsers($organisationId);

		foreach ($organizationUsers as $key => $organizationUser) {
			foreach ($workspaceUsers as $key2 => $workspaceUser) {
				if ($organizationUser['user_id']==$workspaceUser['userid']) {
					unset($organizationUsers[$key]);
				}
			}
		}

		return $organizationUsers;
	}

	/**
	 * delete the selected workspace user from workspaces_users table
	 * @param  string $workspaceId    ID
	 * @param  int $userId         ID
	 * @param  string $organizationId ID
	 * @return redirect the previous page
	 */
	public function actiondelWorkspaceUser($workspaceId,$userId,$organizationId)
	{
		if(Yii::app()->user->isGuest)
			$this->redirect( array('site/login' ) );

		$command = Yii::app()->db->createCommand();
		$command->delete('workspaces_users', 'userid=:userid && workspace_id=:workspace_id', array(':userid'=>$userId,':workspace_id'=>$workspaceId));
		$this->redirect( array('organisations/workspaces&organizationId='.$organizationId ) );
	}

	/**
	 * add selected user to workspace -> workspaces_users table
	 * @param  string $workspaceId    ID
	 * @param  int $userId         ID
	 * @param  string $organizationId ID
	 * @return redirect the previous page
	 */
	public function actionaddWorkspaceUser($workspaceId,$userId,$organizationId)
	{
		if(Yii::app()->user->isGuest)
			$this->redirect( array('site/login' ) );

			$addUser = Yii::app()->db->createCommand();
			$addUser->insert('workspaces_users', array(
			    'workspace_id'=>$workspaceId,
			    'userid'=>$userId,
			));	
		$this->redirect( array('organisations/workspaces&organizationId='.$organizationId ) );
	}

	/**
	 * organisation users
	 * @param  ID $organisationId 
	 * @return render users.php sends users and organisation ID
	 */
	public function actionUsers($organisationId)
	{
		$organizationUsers= OrganisationUsers::model()->findAll('organisation_id=:organisation_id', 
	    				array(':organisation_id' => $organisationId) );
		$users=array();
		foreach ($organizationUsers as $key => $organizationUser) {
			$users[]= User::model()->findByPk($organizationUser->user_id);
		}

		$this->render('users', array(
			'users'=>$users,
			'organisationId'=>$organisationId));
	}

	/**
	 * delete user from workspaces and organization
	 * @param  ID $userId         
	 * @param  ID $organisationId 
	 * @return redirect previous page
	 */
	public function actionDeleteOrganisationUser($userId,$organisationId)
	{
		$organisationWorkspaces= OrganisationWorkspaces::model()->findAll('organisation_id=:organisation_id', 
	    				array(':organisation_id' => $organisationId) );
		foreach ($organisationWorkspaces as $key => $workspace) {
			$workspaceUser = WorkspacesUsers::model()->findByPk(array('userid'=>$userId,'workspace_id'=>$workspace->workspace_id));
			if ($workspaceUser) {
				$workspaceUser->delete();
			}
		}

		$user = OrganisationUsers::model()->findByPk(array('user_id'=>$userId,'organisation_id'=>$organisationId));
		$user->delete();
		$this->redirect( array('organisations/users&organizationId='.$organisationId ) );
	}

	/**
	 * organizasyona kullanıcı eklemek için, email adresine davetiye gönderiyorum
	 * @param  string $email          
	 * @param  string $organisationId 
	 * @return string error | success
	 */
	public function actionAddUser($email,$organisationId)
	{
		$error="";
		$success="";
		//gönderilecek linkin ilk kısmını oluşturdum
		$link=Yii::app()->getBaseUrl(true);
		$link.='/index.php?r=user/invitation&key=';
		$organisation = Organisations::model()->findByPk($organisationId);

		//email adresinin doğruluğunu check eden regexp
		$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_-]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
		if (preg_match($regexp, $email)) {
		    //Email address is valid
			$user= User::model()->findAllByAttributes(array('email'=>$email) );
			if ($user) {
				$userId = $user[0]->id;
			}
			else
			{
				// a user has NOT this email in users table.
				//we will create new user
				$user = new User;
				$criteria=new CDbCriteria;
				$criteria->select='max(id) AS maxColumn';
				$row = $user->model()->find($criteria);
				
				$userId = $row['maxColumn']+1;
				$user->id = $userId;
				$user->email=$email;
				$user->save();
			}
			
			//yeni davetiye oluşturuyoruz
			$invitation= new OrganisationInvitation;
			$invitation->organisation_id = $organisation->organisation_id;
			$invitation->user_id = $userId;
			$invitation->invitation_id = functions::get_random_string();
			$invitation->save();
			//linke davetiye IDsini de ekliyorum
			$link .= $invitation->invitation_id;

			$message=$organisation->organisation_name. " size editöre katılma isteği gönderdi. İsteği kabul etmek için <a href='".$link."'>tıklayın</a>.<br>".$link;	

			//mail gönderiyorum
			$mail=Yii::app()->Smtpmail;
	        $mail->SetFrom('edubox@linden-tech.com', $organisation->organisation_name);
	        $mail->Subject    = $organisation->organisation_name.' davetiye.';
	        $mail->MsgHTML($message);
	        $mail->AddAddress($email, "");
	        
	        if(!$mail->Send()) {
	            echo "Mailer Error: " . $mail->ErrorInfo;
	        }else {
	            $success="Kullanıcı davet edildi.";
	        }



		} else {
		    //Email address is NOT valid
		    $error = "Girdiğiniz e-posta adresi yanlış";
		}

		$this->render('add_user', array(
			'error'=>$error,
			'success'=>$success));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Organisations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Organisations']))
			$model->attributes=$_GET['Organisations'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Organisations the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Organisations::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Organisations $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organisations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
