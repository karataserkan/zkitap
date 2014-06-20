<?php

class UserController extends Controller
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
				'actions'=>array('index','view','invitation','signup','forgetPassword','verifyEmail','respondBookInvitation','acceptInvitation','registerUser','respondOrganisationInvitation',),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','profile','updatePhoto','updateProfile','sendConfirmationId','checkConfirmationId','messageStatusCallback','reSendEmailVerification'),
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

	public function actionReSendEmailVerification()
	{
		$meta=UserMeta::model()->find('meta_key=:meta_key AND user_id=:user_id',array('meta_key'=>'emailVerify','user_id'=>Yii::app()->user->id));
		$user=User::model()->findByPk(Yii::app()->user->id);

		$verifyEmailId=functions::new_id();
		if (!$meta) {
			$meta=new UserMeta;
			$meta->user_id=Yii::app()->user->id;
			$meta->meta_key='emailVerify';
			$meta->created=time();
		}
		
		$meta->meta_value=$verifyEmailId;
		if($meta->save()){
	    	$link=Yii::app()->getBaseUrl(true);
			$link .='/user/verifyEmail/';
			$link .= $verifyEmailId;
			
	        $mail=new Email;
			$mail->setTo(array($user->email));
			$mail->setSubject('E-posta adresinizi doğrulayın');
			$mail->setFile('6Verify_Your_Email.tr_TR.html');
			$mail->setAttributes(array('title'=>'E-posta adresinizi doğrulayın','link'=>$link));

	        if($mail->sendMail()){
	        	echo "0";
	        }else{
	        	echo "1";
	        }
		}else{
        	echo "1";
		}

	}

	public function actionVerifyEmail($id)
	{
		$this->layout = '//layouts/column1';
		$result="1";
		$meta=UserMeta::model()->find('meta_key=:meta_key AND meta_value=:meta_value',array('meta_key'=>'emailVerify','meta_value'=>$id));
		if ($meta) {
			$meta->meta_value="verified";
			if ($meta->save()) {
				$result="0";
			}else{
				$result="1";
			}
		}

		$this->render('verifyEmail',array(
				'result'=>$result
			));
	}

	public function actionSendConfirmationId()
	{
		if (isset($_POST['tel']) AND $_POST['tel']) {
			$userConfirmation=UserMeta::model()->find('user_id=:user_id and meta_key=:meta_key',array('user_id'=>Yii::app()->user->id,'meta_key'=>'confirm'));
			$userConfirmation->meta_value=functions::get_random_string(6,'0123456789');
			$userConfirmation->save();

			$tel=str_replace(' ', '', $_POST['tel']);

			$user=User::model()->findByPk(Yii::app()->user->id);
			$user->tel=$tel;
			$user->save();


			spl_autoload_unregister(array('YiiBase','autoload'));
			require('Services/Twilio.php');
			spl_autoload_register(array('YiiBase','autoload'));
			$account_sid = Yii::app()->params['twilioSid']; 
			$auth_token = Yii::app()->params['twilioToken'];
			
			$client = new Services_Twilio($account_sid, $auth_token); 
			$message = $client->account->messages->sendMessage(
			  Yii::app()->params['twilioFrom'],
			  $tel,
			  "OKUTUS aktivasyon kodunuz: ".$userConfirmation->meta_value
			);
			if ($message->sid) {
				echo "0";
			}
			else
			{
				echo "1";
			}
			error_log($message->sid);

			//else
		}
		else
			echo "1";

	}

	public function actionMessageStatusCallback()
	{
		error_log(json_encode($_POST));
		error_log($_POST);
	}


	public function actionCheckConfirmationId()
	{
		if (isset($_POST['code']) AND $_POST['code']) {
			$userConfirmation=UserMeta::model()->find('user_id=:user_id and meta_key=:meta_key',array('user_id'=>Yii::app()->user->id,'meta_key'=>'confirm'));
			if ($userConfirmation->meta_value==$_POST['code']) {
				$userConfirmation->meta_value="confirmed";
				if($userConfirmation->save())
				{
					echo "0";
				}else
				{
					echo "1";
				}
			}else
			{
				echo "1";
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

	public function actionRespondOrganisationInvitation($key,$respond){
		$invitation=Invitation::model()->find('invitation_key=:invitation_key',array('invitation_key'=>$key));
		if ($respond=="1") {
			$organisationUser=OrganisationUsers::model()->find('organisation_id=:organisation_id AND user_id=:user_id',array('organisation_id'=>$invitation->type_id,'user_id'=>$invitation->user_id));
			if (!$organisationUser) {
				$organisationNewUser=new OrganisationUsers;
				$organisationNewUser->user_id=$invitation->user_id;
				$organisationNewUser->organisation_id=$invitation->type_id;
				$organisationNewUser->role="user";
				$organisationNewUser->save();
			}
			$invitation->status=1;
		}else{
			$invitation->status=2;
		}
		$invitation->save();
		$this->redirect(array('/site/index'));
	}

	public function actionRespondBookInvitation($key,$respond){
		

		$invitation=Invitation::model()->find('invitation_key=:invitation_key',array('invitation_key'=>$key));
		
		if ($respond=="1") {
			$book=Book::model()->findByPk($invitation->type_id);
			$workspaceUser=WorkspacesUsers::model()->find('workspace_id=:workspace_id AND userid=:userid',array('workspace_id'=>$book->workspace_id,'userid'=>$invitation->user_id));
			$organisationWorkspaces=OrganisationWorkspaces::model()->find('workspace_id=:workspace_id',array('workspace_id'=>$book->workspace_id));

			$organisationUser=OrganisationUsers::model()->find('organisation_id=:organisation_id AND user_id=:user_id',array('organisation_id'=>$organisationWorkspaces->organisation_id,'user_id'=>$invitation->user_id));
			if (!$organisationUser) {
				$organisationNewUser=new OrganisationUsers;
				$organisationNewUser->user_id=$invitation->user_id;
				$organisationNewUser->organisation_id=$organisationWorkspaces->organisation_id;
				$organisationNewUser->role="user";
				$organisationNewUser->save();
			}

			if (!$workspaceUser) {
				$newWorkspaceUser=new WorkspacesUsers;
				$newWorkspaceUser->workspace_id=$book->workspace_id;
				$newWorkspaceUser->userid=$invitation->user_id;
				$newWorkspaceUser->added=date('Y-n-d g:i:s',time());
				$newWorkspaceUser->owner=$invitation->user_id;
				$newWorkspaceUser->save();
			}

			$bookUser=BookUsers::model()->find('user_id=:user_id AND book_id=:book_id',array('user_id'=>$invitation->user_id,'book_id'=>$invitation->type_id));
			if (!$bookUser) {
				$bookUser=new BookUsers;
				$bookUser->user_id=$invitation->user_id;
				$bookUser->book_id=$invitation->type_id;
			}

			$bookUser->type=$invitation->type_data;
			$bookUser->created=date('Y-n-d g:i:s',time());

			if ($bookUser->save()) {
		    	$msg="SITE:RIGHT:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId,'type'=>$type)));
				Yii::log($msg,'info');
			}else{
				$msg="SITE:RIGHT:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId,'type'=>$type)));
				Yii::log($msg,'info');
			}


			$invitation->status=1;
		}else{
			$invitation->status=2;
		}

		$invitation->save();
		$this->redirect(array('/site/index'));
	}

	public function actionRegisterUser()
	{
		if (isset($_POST['User'])) {
			$attributes=$_POST['User'];
			$newUser=new User;
			$criteria=new CDbCriteria;
			$criteria->select='max(id) AS maxColumn';
			$row = $newUser->model()->find($criteria);		
			$userId = $row['maxColumn']+1;
			$loginError="";
			$newUser->id=$userId;
			$meta=new UserMeta;
			$meta->user_id=$newUser->id;
			$meta->meta_key='profilePicture';
			$meta->meta_value=$attributes['data'];
			$meta->created=time();
			$meta->save();
			
			$detectSQLinjection=new detectSQLinjection($attributes['name']);
			if (!$detectSQLinjection->ok()) {
				error_log("detectSQLinjection SC:L:".$Yii::app()->user->id." attributes['name']: ".$attributes['name']);
				$this->redirect('index');	
			}

			$detectSQLinjection=new detectSQLinjection($attributes['surname']);
			if (!$detectSQLinjection->ok()) {
				error_log("detectSQLinjection SC:L:".$Yii::app()->user->id." attributes['surname']: ".$attributes['surname']);
				$this->redirect('index');	
			}


			$newUser->name=$attributes['name'];
			$newUser->surname=$attributes['surname'];
			$newUser->email=$attributes['email'];
			$newUser->created=date('Y-n-d g:i:s',time());

			

			$hasEmail= User::model()->findAll('email=:email', 
	    				array(':email' => $attributes['email']) );

			if (empty($hasEmail)) {
				if ($attributes['password']==$attributes['passwordR']) {
					$newUser->password=md5(sha1($attributes['password']));
					$newUser->save();

					$welcomelink=Yii::app()->getBaseUrl(true);
					
					$welcomeMail=new Email;
					$welcomeMail->setTo(array($newUser->email));
					$welcomeMail->setSubject('OKUTUS\'a Hoş Geldiniz');
					$welcomeMail->setFile('7WelcomeMail.tr_TR.html');
					$welcomeMail->setAttributes(array('title'=>'OKUTUS\'a Hoş Geldiniz','link'=>$welcomelink,'username'=>$newUser->name.' '.$newUser->surname));
					$welcomeMail->sendMail();

					$model=new LoginForm;
					$model->password=$attributes['password'];
					$model->email=$attributes['email'];
					$model->validate();
					$model->login();
					$invitation=Invitation::model()->find('invitation_key=:invitation_key',array('invitation_key'=>$attributes['key']));
					$invitation->user_id=$newUser->id;
					$invitation->new_user=0;
					$invitation->save();
					if ($invitation->type=="book") {
						$this->redirect(array('respondBookInvitation','key'=>$attributes['key'],'respond'=>1));
					}elseif ($invitation->type=="organisation") {
						$this->redirect(array('respondOrganisationInvitation','key'=>$attributes['key'],'respond'=>1));
					}
				}
			}
		}
	}

	public function actionAcceptInvitation($key){
		if(!$key){
			//404 sayfasına yönlenecek burda
			die();
		}

		$invitation=Invitation::model()->find('invitation_key=:invitation_key AND status=:status',array('invitation_key'=>$key,'status'=>0));

		if (!$invitation) {
			//404 sayfasına yönlenecek burda
			die();
		}

		if ($invitation->type=="book") {
			if ($invitation->new_user) {
				$this->render('newUserWithInvitation',array('key'=>$key));
			}else{
				$this->render('newUserToBook',array('key'=>$key));
			}
		}elseif ($invitation->type="organisation") {
			if ($invitation->new_user) {
				$this->render('newUserWithInvitation',array('key'=>$key));
			}else{
				$this->render('newUserToOrganisation',array('key'=>$key));
			}

		}elseif ($invitation->type="workspace") {
		}

	}

	/**
	 * davet edilen kullanıcı key ile birlikte geliyor. invitation tablosundan user ve organisation bulunuyor.
	 * kullanıcı yeni ise şifre ve isim kaydediliyor
	 * kullanıcı organizasyona kaydediliyor
	 * kullanıcının tekrar aynı linki kullanamaması için invitationı siliyorum
	 * @param  varchar $key 
	 * @return model User, is Newuser or Not
	 */
	public function actionInvitation($key=null)
	{
		$invitation = OrganisationInvitation::model()->findByPk($key);
		$user=$this->loadModel($invitation->user_id);

		if ($invitation) {
			//$invitation->delete();
			//
			
			$isBookInvitation=Book::model()->findByPk($invitation->organisation_id);

			$isOrganisationUser=OrganisationUsers::model()->find('user_id=:user_id AND organisation_id=:organisation_id',array('user_id'=>$user->id,'organisation_id'=>$invitation->organisation_id));
			
			$newUser=false;
			if ($user->name == "" || $user->surname=="" || $user->password=="") {
				$newUser=true;
			}
			if(isset($_POST['User']))
			{
				$user->attributes=$_POST['User'];
				$user->password=md5(sha1($_POST['User']["password"]));
				$user->created=date('Y-n-d g:i:s',time());
				if ($user->save()) {
						$workspace= new Workspaces;
						$workspace->workspace_id=functions::new_id();
						$workspace->workspace_name = $user->name." Books";
						$workspace->creation_time=date('Y-n-d g:i:s',time());
						if ($workspace->save()) {
							$workspaceUser=new WorkspacesUsers;
							$workspaceUser->workspace_id=$workspace->workspace_id;
							$workspaceUser->userid=$user->id;
							$workspaceUser->added=date('Y-n-d g:i:s',time());
							$workspaceUser->owner=$user->id;
							if ($workspaceUser->save()) {
								$model=new LoginForm;
								$model->password=$user->password;
								$model->email=$user->email;
								$model->validate();
								$model->login();
								$invitation->delete();
								$this->redirect('/site/index');
							}
						}
				}
				//$this->redirect( array('site/login' ) );
			}else
			{
				if (!$isOrganisationUser) {
					if ($isBookInvitation) {
						//$isOrganisationUser=OrganisationUsers::model()->find('user_id=:user_id AND organisation_id=:organisation_id',array('user_id'=>$user->id,'organisation_id'=>$invitation->organisation_id));
						$organisation=Organisations::model()->findByPk($isOrganisationUser->organisation_id);
					}else{
						$organisation=Organisations::model()->findByPk($invitation->organisation_id);
					}
					$organisationUser= new OrganisationUsers;
					$organisationUser->user_id=$user->id;
					$organisationUser->organisation_id=$organisation->organisation_id;
					$organisationUser->role="user";
					if($organisationUser->save())
					{
						$msg="USER:INVITATION:0:". json_encode(array('userId'=>$user->id,'organisationId'=>$organisation->organisation_id,'role'=>'user', 'message'=>'invitation accepted'));
						Yii::log($msg,'info');
					}
					else
					{
						$msg="USER:INVITATION:1:". json_encode(array('userId'=>$user->id,'organisationId'=>$organisation->organisation_id,'role'=>'user', 'message'=>'invitation accept error'));
						Yii::log($msg,'info');
					}
				}

				if ($isBookInvitation) {
					$addWorkspaceUser=new WorkspacesUsers;
					$addWorkspaceUser->workspace_id=$isBookInvitation->workspace_id;
					$addWorkspaceUser->userid=$user->id;
					$addWorkspaceUser->added=date('Y-n-d g:i:s',time());
					$addWorkspaceUser->owner=$user->id;
					$addWorkspaceUser->save();
					$addUser = Yii::app()->db->createCommand();
					if($addUser->insert('book_users', array(
					    'user_id'=>$user->id,
					    'book_id'=>$isBookInvitation->organisation_id,
					    'type'   =>"editor"
					)))
					{
						$invitation->delete();
						$msg="SITE:RIGHT:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$isBookInvitation->id)));
						Yii::log($msg,'info');
					}
					else
					{
						$msg="SITE:RIGHT:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$isBookInvitation->id)));
						Yii::log($msg,'info');
					}
				}else{
					
				}

			}

			$this->render('invitation',array(
				'model'=>$user,
				'newUser'=>$newUser
			));
		}
	}

	public function deleteOldKeys()
	{
		$query="delete from user_meta where meta_key='passwordReset' AND ((".time()."-created)/60)>10";
		$command = Yii::app()->db->createCommand($query);
		$command->execute();
		//$query->queryAll($query);
	}

	public function actionForgetPassword($id=null)
	{
		$userMeta=UserMeta::model()->find('meta_key=:meta_key AND meta_value=:meta_value',array('meta_key'=>'passwordReset','meta_value'=>$id));
		$this->deleteOldKeys();
		$result=0;
		
		// $id=base64_decode($id);
		// $meta= Yii::app()->db->createCommand()
  //   		->select('*')
  //   		->from('user_meta')
  //   		->where('id=:id', array(':id'=>$id))
  //   		->andWhere('meta_key=:meta_key', array(':meta_key'=>"passwordReset"))
  //   		->queryRow()
		// ;
		if ($userMeta) {
			$created=$userMeta->created;
			$now=time();
			
		  	$time = ($now-$created)/60;

			if ($time<10) {

				if (isset($_POST['Reset'])) {
					$attributes=$_POST['Reset'];
					if ($attributes['password']==$attributes['password2']) {
						$newpassword=md5(sha1($attributes['password']));
						$user=User::model()->findByPk($userMeta->user_id);
						$user->password=$newpassword;
						$user->save();

						$mail=new Email;
						$mail->setTo(array($user->email));
						$mail->setSubject('Okutus Editör hesabının şifresi değiştirildi');
						$mail->setFile('3Password_Changed.tr_TR.html');
						$mail->setAttributes(array('title'=>'Okutus Editör hesabının şifresi değiştirildi'));
						$mail->sendMail();


						$result=1;
					}

				}
				$this->layout = '//layouts/column1';
				$this->render('forget_password',array('result'=>$result));
			}
		}
	}

	public function actionProfile()
	{
		//echo Yii::app()->user->id;
		$user=User::model()->findByPk(Yii::app()->user->id);
		$userProfileMeta=UserMeta::model()->find('user_id=:user_id AND meta_key=:meta_key',array('user_id'=>Yii::app()->user->id,'meta_key'=>'profilePicture'));
		$this->render('profile',array('user'=>$user,'userProfileMeta'=>$userProfileMeta));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionUpdatePhoto()
	{

		$meta=UserMeta::model()->find('user_id=:user_id AND meta_key=:meta_key',array('user_id'=>Yii::app()->user->id,'meta_key'=>'profilePicture'));

		if (!$meta) {
			$meta=new UserMeta;
		}
		if (isset($_POST['img'])) {
			$meta->user_id=Yii::app()->user->id;
			$meta->meta_key='profilePicture';
			$meta->meta_value=$_POST['img'];
			$meta->created=time();
			$meta->save();
			
		}
	}


	public function actionUpdateProfile()
	{
		$message="Bilgiler Güncellendi";
		$user=User::model()->findByPk(Yii::app()->user->id);
			if ($_POST['name']) {
				$user->name=$_POST['name'];
			}
			if ($_POST['surname']) {
				$user->surname=$_POST['surname'];
			}
			if ($_POST['email']) {
				$user->email=$_POST['email'];



				$meta=UserMeta::model()->find('user_id=:user_id AND meta_key=:meta_key',array('user_id'=>$user->id,'meta_key'=>'emailVerify'));
				if (!$meta) {
					$meta=new UserMeta;
					$meta->user_id=$user->id;
					$meta->meta_key='emailVerify';
				}

				$resetId=functions::new_id(20);

				$link=Yii::app()->getBaseUrl(true);
				$link.='/user/verifyEmail/';
				$meta->meta_value=$resetId;
		        $meta->created=time();
	        	$meta->save();

				$link .= $resetId;

	        	$mail=new Email;
				$mail->setTo(array($user->email));
				$mail->setSubject('OKUTUS E-post Adresi Doğrulama');
				$mail->setFile('1email_adress_changed_please_verify_tr_TR.html');
				$mail->setAttributes(array('title'=>'OKUTUS Şifre Sıfırlama','link'=>$link));
		        $mail->sendMail();

			}

			if ($_POST['passwordEski']) {
				$passOld=md5(sha1($_POST['passwordEski']));
				if ($user->password==$passOld) {
					if ($_POST['passwordYeni']==$_POST['passwordYeni2']) {
						$user->password=md5(sha1($_POST['passwordYeni']));
						$mail=new Email;
						$mail->setTo(array($user->email));
						$mail->setSubject('Okutus Editör hesabının şifresi değiştirildi');
						$mail->setFile('3Password_Changed.tr_TR.html');
						$mail->setAttributes(array('title'=>'Okutus Editör hesabının şifresi değiştirildi'));
						$mail->sendMail();
					}
					else
					{
						$message = "Yeni Şifre ve Yeni Şifre Tekrarı aynı değil";
					}
				}
				else
				{
					$message = "Eski şifreyi yanlış girdiniz";
				}
			}
			$user->save();
			echo $message;
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
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
