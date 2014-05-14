<?php

class SiteController extends Controller
{
	public $layout = '//layouts/column2';
	/**
	 * Declares class-based actions.
	 */

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}




	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

		functions::event('tripData',NULL, function($var){

		?>
			/* Header */
				{ 
			       content : "Okutus Editor'e HoşGeldiniz, Tanıtım için ileriye basınız.",
			       position:'screen-center',
			       delay:-1
			   },
		
			/* Header */
			   { 
			       sel : $('#sidebar-collapse i'),
			       content : 'Menuyü açıp kapatabilirsiniz.',
			       position:'e',
			       callback:function () {$('#header-user img').click();}
			       //expose: true
			   },
			   { 
			       sel : $('#header-user'),
			       content : 'Profil Ayarları ve Çıkış',
			       position:'w',
			       callback:function () {$('#header-user img').click();}
			       //expose: true
			   },

			 /* Left Menu */
			   { 
			       sel : $('#sidebar'),
			       content : 'Tüm Seçenekler',
			       position:'e',
			       expose: true
			   },

			   { 
			       sel : $($('#sidebar ul li')[0]),
			       content : 'Başlangıç Ekranı',
			       position:'e',
			       //expose: true
			   },
			   { 
			       sel : $($('#sidebar ul li')[1]),
			       content : 'Kitaplarınız',
			       position:'e',
			       //expose: true
			   },
			   { 
			       sel : $($('#sidebar ul li')[2]),
			       content : 'Tüm yardımcı kaynaklar ve Destek Talebi için',
			       position:'e',
			       //expose: true
			   },
			   { 
			       sel : $($('#sidebar ul li')[3]),
			       content : 'Hesap Ayarlarınızı Yapabilirisiniz',
			       position:'e',
			       //expose: true,
			        callback:function(){$($('#sidebar >div> ul>li')[4]).find('a').click();}
			   },
			   { 
			       sel : $($('#sidebar ul li')[4]),
			       content : 'Şablonlarınıza erişip, değiştirebilir ve yenilerini oluşturabilirsiniz.',
			       position:'e',
			       //expose: true,
			       callback:function(){$($('#sidebar >div> ul>li')[5]).find('a').click();}
			   },
			   { 
			       sel : $($('#sidebar ul li a')[5]),
			       content : 'Organizasyonunuzu Yönetebilirsiniz.',
			       position:'e',
			       //expose: true,
			       callback:function(){$($('#sidebar >div> ul>li')[5]).find('a').click();}
			   },

			 /* Content */
			   { 
			       sel : $('#filter-controls'),
			       content : 'Çalışma Alanı Hızlı Filtrelerini kullanarak kitaplarınıza hızlı erişebilirsiniz.',
			       position:'s',
			       expose: true,
			       callback:function(){$('a[data-filter=".owner"]').click();}
			   },
			   { 
			       sel : $('a[data-filter=".owner"]'),
			       content : 'Sahibi Olduklarınıza',
			       position:'s',
			       callback:function(){$('a[data-filter=".editor"]').click();}
			   },
			   { 
			       sel : $('a[data-filter=".editor"]'),
			       content : 'Editörü Olduklarınıza',
			       position:'s',
			       //expose: true,
			       callback:function(){$('a[data-filter="*"]').click();}
			   },
			   { 
			       sel : $('a[data-filter="*"]'),
			       content : 'ya da kısaca Hepsine',
			       position:'s',
			       //expose: true
			   },
   			   { 
			       sel : $('#addNewBookBtn'),
			       content : 'Şimdi Yeni Bir Kitap Ekleyiniz',
			       position:'w',
			       //expose: true,
			       delay: -1
			   },
		
		
		
		
		
					
		
					<?php
	});

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(Yii::app()->user->isGuest)
			$this->redirect( array('site/login' ) );

		$workspaces=$this->getUserWorkspaces();

		$this->render('index',array('workspaces'=>$workspaces));
	}

	public function actionDashboard()
	{
		$meta_books= Yii::app()->db
		    ->createCommand("SELECT * FROM user_meta WHERE user_id=:user_id AND meta_key=:meta_key ORDER BY created DESC LIMIT 4")
		    ->bindValues(array(':user_id' => Yii::app()->user->id, ':meta_key' => 'lastEditedBook'))
		    ->queryAll();
		 if ($meta_books) {
			 foreach ($meta_books as $key => $book) {
			 	$books[]=Book::model()->findByPk($book['meta_value']);
			 }		 	
		 }

		
		$this->render('dashboard',array('books'=>$books));
	}

	public function actionRemoveUser($userId,$bookId)
	{
		$command = Yii::app()->db->createCommand();
		$command->delete('book_users', 'user_id=:user_id && book_id=:book_id', array(':user_id'=>$userId,':book_id'=>$bookId));

		$msg="SITE:REMOVE_USER:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId)));
		Yii::log($msg,'info');

		$this->redirect('index');
	}

	//kullanıcı haklarını burada düzenliyorum
	public function actionRight($userId,$bookId,$type)
	{
		if(Yii::app()->user->isGuest)
			$this->redirect( array('site/login' ) );
		
		$detectSQLinjection=new detectSQLinjection($userId);
		if (!$detectSQLinjection->ok()) {
			error_log("detectSQLinjection SC:R:".$Yii::app()->user->id." userId: ".$userId);
			$this->redirect('index');	
		}

		$detectSQLinjection=new detectSQLinjection($bookId);
		if (!$detectSQLinjection->ok()) {
			error_log("detectSQLinjection SC:R:".$Yii::app()->user->id." bookId: ".$bookId);
			$this->redirect('index');	
		}

		$detectSQLinjection=new detectSQLinjection($type);
		if (!$detectSQLinjection->ok()) {
			error_log("detectSQLinjection SC:R:".$Yii::app()->user->id." bookId: ".$type);
			$this->redirect('index');	
		}

		$hasRight=Yii::app()->db
		    ->createCommand("SELECT * FROM book_users WHERE user_id=:user_id AND book_id=:book_id")
		    ->bindValues(array(':user_id' => $userId, ':book_id' => $bookId))
		    ->execute();
	    
	    if ($hasRight) {
	    	
	    	
		    if(Yii::app()->db
		    ->createCommand("UPDATE book_users SET type = :type WHERE user_id=:user_id AND book_id=:book_id")
		    ->bindValues(array(':type' => $type, ':user_id' => $userId, ':book_id' => $bookId))
		    ->execute())
		    {
		    	$msg="SITE:RIGHT:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId,'type'=>$type)));
				Yii::log($msg,'info');
		    }
		    else
		    {
		    	$msg="SITE:RIGHT:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'bookId'=>$bookId,'type'=>$type)));
				Yii::log($msg,'info');
		    }
		}
	    else
	    {
	    	$addUser = Yii::app()->db->createCommand();
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
	    }
		
	    $this->redirect(array('/site/index'));
		//$this->render('index');
	}

	/**
	* this returns the user type for $bookId
	* return owner | editor | user | false
	*/
	public function userType($bookId)
	{
		$userid=Yii::app()->user->id;

		$bookOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("book_users")
	    ->where("book_id=:book_id", array(':book_id' => $bookId))
	    ->andWhere("user_id=:user_id", array(':user_id' => $userid))
	    ->queryRow();
	    
	    return ($bookOfUser) ? $bookOfUser['type'] : false;
	}

	//kitabın kullanıcılarını return ediyorum
	public function bookUsers($bookId)
	{
		$bookUsers = Yii::app()->db->createCommand()
		->select ("*")
		->from("book_users")
		->where("book_id=:book_id", array(':book_id' => $bookId))
		->join("user","user_id=id")
		->queryAll();

		return $bookUsers;
	}

	/**
	 * is user has an organization?
	 * @return organization
	 */
	public function organization()
	{
		$organization = Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("organisation_users")
	    ->where("user_id=:user_id", array(':user_id' => Yii::app()->user->id))
	    ->queryRow();
	    return  ($organization) ? $organization : null ;
	}

	/**
	 * workspaceUsers
	 * @param  ID $workspace_id 
	 * @return array               workspace users
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

	public function getTemplateWorkspaces()
	{
		$workspace = Yii::app()->db->createCommand()
		->select ("*")
		->from("organisations_meta")
		->where("meta=:meta", array(':meta' => 'template'))
		->queryAll();

		return $workspace;
	}

	/**
	 * getUserWorkspaces
	 * @return array user workspaces
	 */
	public function getUserWorkspaces()
	{
		$userid=Yii::app()->user->id;
		$templates=$this->getTemplateWorkspaces();

		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("user u","x.userid=u.id")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
	    
	    foreach ($templates as $key => $template) {
	    	foreach ($workspacesOfUser as $key => $workspace) {
		    	if ($template['value']===$workspace['workspace_id']) {
		    		unset($workspacesOfUser[$key]);
		    	}
	    	}
	    }

	    return $workspacesOfUser;	
	}

	public function getWorkspaceBooks($workspace_id)
	{
		$all_books= Book::model()->findAll('workspace_id=:workspace_id AND (publish_time IS NULL OR publish_time=0)', 
	    				array(':workspace_id' => $workspace_id) );
		return $all_books; 
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}


	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/column1';
		$model=new LoginForm;

		$newUser = new User;
		$criteria=new CDbCriteria;
		$criteria->select='max(id) AS maxColumn';
		$row = $newUser->model()->find($criteria);		
		$userId = $row['maxColumn']+1;
		$loginError="";
		$newUser->id=$userId;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		$passResetError="";
		if (isset($_GET['Reset'])) {
			$email=$_GET['Reset']['email'];

		$detectSQLinjection=new detectSQLinjection($email);
		if (!$detectSQLinjection->ok()) {
			error_log("detectSQLinjection SC:L:".$Yii::app()->user->id." email: ".$email);
			$this->redirect('index');	
		}
			$user= User::model()->find('email=:email', 
	    				array(':email' => $email) );
			if (!empty($user)) {
				$meta=new UserMeta;
				$meta->user_id=$user->id;
				$meta->meta_key='passwordReset';
				$link=Yii::app()->getBaseUrl(true);
				$link.='/user/forgetPassword?id=';
				$meta->meta_value=$email;
		        $meta->created=time();
	        	$meta->save();


				$mail=Yii::app()->Smtpmail;
		        $mail->SetFrom(Yii::app()->params['noreplyEmail'], "OKUTUS");

		        $mail->Subject= "Password Reset";
		        $mail->AddAddress($email, "");
	        	
				$link .= base64_encode($meta->id);
				$message="Şifre sıfırlama isteği gönderdiniz. <a href='".$link."'>Buraya tıklayarak</a> şifrenizi değiştirebilirsiniz. Şifre değiştirme isteğiniz 10 dakika sonra geçersiz olacaktır.<br>".$link;
		        $mail->MsgHTML($message);

		        if($mail->Send()) {
		        	$passResetSuccess=__("Şifre yenileme maili gönderildi. Mailinizdeki linke tıklayarak 10 dakika içerisinde şifrenizi yeniden oluşturabilirsiniz.");
	        	}
	        	else
	        	{
	        		$passResetError=__("Mail gönderirlirken beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.");
	        	}
			}
			else
			{
				$passResetError=__("Girilen email adresine ait kullnıcı bulunamadı.");
			}

		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$login_history=new LoginHistory;
			$login_history->user_email=$_POST['LoginForm']['email'];
			$login_history->time=date("Y-m-d H:i:s");
			$login_history->ip=$_SERVER['REMOTE_ADDR'];

			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{

				$msg="SITE:LOGIN:SignIn:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id));
				
				$login_history->status=0;
				$login_history->message=$msg;
				Yii::log($msg,'profile');
				$login_history->save();
				$this->redirect(Yii::app()->user->returnUrl);
			}
			else
			{
				$msg="SITE:LOGIN:SignIn:1:". json_encode($_POST['LoginForm']);
				$login_history->status=1;
				$login_history->message=$msg;
				Yii::log($msg,'profile');
				$login_history->save();
				$loginError="E-Posta veya şifrenizi yanlış girdiniz.";
			}
				
		}

		if (isset($_POST['User'])) {
			$attributes=$_POST['User'];
			
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

			$detectSQLinjection=new detectSQLinjection($attributes['email']);
			if (!$detectSQLinjection->ok()) {
				error_log("detectSQLinjection SC:L:".$Yii::app()->user->id." attributes['email']: ".$attributes['email']);
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
					if ($newUser->save()) {
						$msg="SITE:LOGIN:SignUp:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id));
						Yii::log($msg,'profile');

						$organisation= new Organisations;
						$organisation->organisation_id=functions::new_id();
						$organisation->organisation_name=$newUser->name;
						$organisation->organisation_admin=$newUser->id;
						$organisation->save();
						$organisation_user=new OrganisationUsers;
						$organisation_user->user_id=$newUser->id;
						$organisation_user->organisation_id=$organisation->organisation_id;
						$organisation_user->role='owner';
						$organisation_user->save();

						$workspace= new Workspaces;
						$workspace->workspace_id=functions::new_id();
						$workspace->workspace_name = $newUser->name;
						$workspace->creation_time=date('Y-n-d g:i:s',time());
						if ($workspace->save()) {
							$msg="SITE:LOGIN:CreateWorkspace:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>"a workspace created for new user"));
							Yii::log($msg,'info');
							$workspaceUser=new WorkspacesUsers;
							$workspaceUser->workspace_id=$workspace->workspace_id;
							$workspaceUser->userid=$newUser->id;
							$workspaceUser->added=date('Y-n-d g:i:s',time());
							$workspaceUser->owner=$newUser->id;


							$addWorkspaceOrganization = Yii::app()->db->createCommand();
							if($addWorkspaceOrganization->insert('organisation_workspaces', array(
							    'organisation_id'=>$organisation->organisation_id,
							    'workspace_id'=>$workspace->workspace_id,
							)))
							{
								$msg="ORGANISATION WORKSPACE:CREATE:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('workspaceId'=>$workspace->workspace_id,'organisationId'=>$organisation->organisation_id)));
								Yii::log($msg,'info');
							}
							else
							{
								$msg="ORGANISATION WORKSPACE:CREATE:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('workspaceId'=>$workspace->workspace_id,'organisationId'=>$organisation->organisation_id)));
								Yii::log($msg,'info');
							}


							if ($workspaceUser->save()) {

								$templateWorkspace=new Workspaces;
								$templateWorkspace->workspace_id=functions::new_id();
								$templateWorkspace->workspace_name = $newUser->name." Şablonlar";
								$templateWorkspace->creation_time=date('Y-n-d g:i:s',time());
								if ($templateWorkspace->save()) {
									$templateWorkspaceUser=new WorkspacesUsers;
									$templateWorkspaceUser->workspace_id=$templateWorkspace->workspace_id;
									$templateWorkspaceUser->userid=$newUser->id;
									$templateWorkspaceUser->added=date('Y-n-d g:i:s',time());
									$templateWorkspaceUser->owner=$newUser->id;
									$templateWorkspaceUser->save();
									
									$addTemplateWorkspaceOrganization = Yii::app()->db->createCommand();
									$addTemplateWorkspaceOrganization->insert('organisation_workspaces', array(
									    'organisation_id'=>$organisation->organisation_id,
									    'workspace_id'=>$templateWorkspace->workspace_id,
									));

									$addOrganizationMeta = Yii::app()->db->createCommand();
									$addOrganizationMeta->insert('organisations_meta', array(
									    'organisation_id'=>$organisation->organisation_id,
									    'meta'=>'template',
									    'value'=>$templateWorkspace->workspace_id,
									));

								}


								$msg="SITE:LOGIN:CreateWorkspaceUser:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>"workspaceUser created for new user and new workspace"));
								Yii::log($msg,'info');
								$model->password=$attributes['password'];
								$model->email=$attributes['email'];
								$model->validate();
								$model->login();
								$this->redirect(array('/site/index?id='.$workspace->workspace_id));
							}
							else
							{
								$msg="SITE:LOGIN:CreateWorkspaceUser:1:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>"workspaceUser could NOT created for new user and new workspace"));
								Yii::log($msg,'info');
							}
						}
						else
						{
							$msg="SITE:LOGIN:CreateWorkspace:1:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>"a workspace could NOT created for new user"));
							Yii::log($msg,'info');
						}
					}
					else
					{
						$msg="SITE:LOGIN:SignUp:1:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id));
						Yii::log($msg,'profile');
					}
				}
				else
				{
					$msg="SITE:LOGIN:SignUp:1:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>'passwords not matching'));
					Yii::log($msg,'profile');
				}	
			}
			else
			{
				$msg="SITE:LOGIN:SignUp:1:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>'Duplicate email address'));
				Yii::log($msg,'profile');
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model,'newUser'=>$newUser,'passResetError'=>$passResetError,'passResetSuccess'=>$passResetSuccess,'loginError'=>$loginError));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$msg="SITE:LOGOUT:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id));
		Yii::log($msg,'profile');
		$this->redirect(array('login'));
		//$this->redirect(Yii::app()->homeUrl);
		
	}
}
