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
	public function actionIndex($id=null)
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(Yii::app()->user->isGuest)
			$this->redirect( array('site/login' ) );

		if (isset($id) && $id) {
			$all_books= $this->getWorkspaceBooks($id);
			$workspace=Workspaces::model()->findByPk($id);
		}
		else
		{
			$workspacesOfUser= $this->getUserWorkspaces();
			$workspace=(object)$workspacesOfUser[0];
			//$workspace=Workspace::model()->findByPk($workspace->workspace_id);
			$all_books= $this->getWorkspaceBooks($workspace->workspace_id);
		}

		$this->render('index',array('all_books'=>$all_books,
			'workspace'=>$workspace));
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

	/**
	 * getUserWorkspaces
	 * @return array user workspaces
	 */
	public function getUserWorkspaces()
	{
		$userid=Yii::app()->user->id;

		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->join("user u","x.userid=u.id")
	    ->where("userid=:id", array(':id' => $userid ) )->queryAll();
	    
	    return $workspacesOfUser;	
	}

	public function getWorkspaceBooks($workspace_id)
	{
		$all_books= Book::model()->findAll('workspace_id=:workspace_id', 
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
		
		$newUser->id=$userId;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$msg="SITE:LOGIN:SignIn:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id));
				Yii::log($msg,'profile');
				$this->redirect(Yii::app()->user->returnUrl);
			}
			else
			{
				$msg="SITE:LOGIN:SignIn:1:". json_encode($_POST['LoginForm']);
				Yii::log($msg,'profile');
			}
				
		}

		if (isset($_GET['User'])) {
			$attributes=$_GET['User'];
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
						$workspace= new Workspaces;
						$workspace->workspace_id=functions::new_id();
						$workspace->workspace_name = $newUser->name." Books";
						$workspace->creation_time=date('Y-n-d g:i:s',time());
						if ($workspace->save()) {
							$msg="SITE:LOGIN:CreateWorkspace:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>"a workspace created for new user"));
							Yii::log($msg,'info');
							$workspaceUser=new WorkspacesUsers;
							$workspaceUser->workspace_id=$workspace->workspace_id;
							$workspaceUser->userid=$newUser->id;
							$workspaceUser->added=date('Y-n-d g:i:s',time());
							$workspaceUser->owner=$newUser->id;
							if ($workspaceUser->save()) {
								$msg="SITE:LOGIN:CreateWorkspaceUser:0:". json_encode(array('user'=> Yii::app()->user->name,'userId'=>Yii::app()->user->id,'message'=>"workspaceUser created for new user and new workspace"));
								Yii::log($msg,'info');
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
		$this->render('login',array('model'=>$model,'newUser'=>$newUser));
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
