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
				'actions'=>array('create','update','workspaces','delWorkspaceUser','addWorkspaceUser','users','addUser','deleteOrganisationUser','account','bookCategories','deleteCategory','createBookCategory','updateBookCategory','templates','aCL','addACL','publishedBooks','deleteACL','removeFromCategory','addBalance','selectPlan','checkoutPlan','deneme','changeTitle'),
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

	public function actionDeneme()
	{
		print_r($this->freeWorkspaceUsers('seviye_ws1','qwertyu'));
	}

	public function actionWorkspace()
	{
		$model=new Organisations;
		$model->organisation_id=Yii::app()->request->getPost('organisationId');
		$workspace_name=Yii::app()->request->getPost('workspace_name');
		$workspace_id=Yii::app()->request->getPost('workspace_id');
		$status=Yii::app()->request->getPost('status');

		$model->workspace_id = functions::new_id(15);
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

	public function actionSelectPlan($id=0,$current=0)
	{
		if ($id) {
			$this->render('select_plan',array('organisation'=>$id,'current'=>$current));
		}
	}

	public function actionCheckoutPlan($id=0)
	{
		if (isset($_POST['tutar']) AND isset($_POST['tutar']) AND isset($_POST['plan_id']) AND isset($_POST['name']) AND isset($_POST['number']) AND isset($_POST['month']) AND isset($_POST['year']) AND isset($_POST['ccv'])) {
			$user=Yii::app()->user->id;
			$userModel=User::model()->findByPk($user);
			$email=$userModel->email;
			$type='plan';
			$tutar=$_POST['tutar'];
			$plan_id=$_POST['plan_id'];
			$kartOwner=$_POST['name'];
			$kartNumber=$_POST['number'];
			$kartMonth=$_POST['month'];
			$kartYear=$_POST['year'];
			$kartCCV=$_POST['ccv'];
			
			$ticketUrl = Yii::app()->params['panda_host'].'/api/getTransactionTicket';
			$ch = curl_init( $ticketUrl );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			$ticket = curl_exec( $ch );
			error_log('ticket: '.$ticket);
			error_log('ticketUrl: '.$ticketUrl);

			if ($ticket) {
				$transaction=new Transactions;
				$transaction->transaction_id=$ticket;
				$transaction->transaction_type="plan";
				$transaction->transaction_method="deposit";
				$transaction->transaction_explanation=$plan_id;
				$transaction->transaction_amount=1;
				$transaction->transaction_unit_price=$tutar;
				$transaction->transaction_amount_equvalent=$tutar;
				$transaction->transaction_start_date=date('Y-n-d g:i:s',time());
				$transaction->transaction_organisation_id=$id;

				$transaction->save();

				$url = Yii::app()->params['panda_host'].'/api/addPlan';
				$params = array(
								'transaction'=>$ticket,
								'email'=>$email,
								'type_name'=>$type,
								'type_id'=>$plan_id,
								'amount'=>$tutar
								);
				error_log('params: '.$params);
				$ch = curl_init( $url );
				curl_setopt( $ch, CURLOPT_POST, 1);
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt( $ch, CURLOPT_HEADER, 0);
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec( $ch );
				echo $response;
				error_log('response: '.$response);
				$transaction->transaction_result=0;
				$transaction->transaction_end_date=date('Y-n-d g:i:s',time());
				$transaction->save();
			}
		}
		else
		{
			echo "1";
		}

	}


	public function actionAddBalance($plan=0,$organisation=0)
	{
	 	$tutar="0";
		if ($plan==2) {
		  $tutar="49.99";
		}elseif ($plan==3) {
		  $tutar="199.99";
		}elseif ($plan==4) {
		  $tutar="299.99";
		}

		//url: "<?php echo Yii::app()->params['panda_host']; /api/transaction",

		$this->render('add_money',array('tutar'=>$tutar,'plan_id'=>$plan,'organisation'=>$organisation));
	}

	public function actionRemoveFromCategory($id)
	{
		$book=Book::model()->findByPk($id);
		$book->publish_time=NULL;
		$book->save();

		$url = Yii::app()->params['catalog'].'/api/remove';
		$params = array(
						'id'=>$id,
						);
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec( $ch );

		$this->redirect('/site/index');
	}

	public function actionACL($id)
	{
		$ACLs=$this->getACL($id);

		 $this->render('organisationACL',array('acls'=>$ACLs,'organisation_id'=>$id));
	}

	public function actionAddACL($id)
	{
		if (isset($_POST['acl'])) {
			$data=json_decode($_POST['acl'],true);
			$this->addACL($id,$data[0]['value'],$data[2]['value'],$data[3]['value'],$data[1]['value'],$data[4]['value'],$data[5]['value']);
		}
		
	}

	public function actionDeleteACl($id,$acl_id)
	{
		$acls=$this->getACL($id);
		$acls=json_decode($acls);
		$new=array();
		foreach ($acls as $key => $acl) {
			if ($acl->id!=$acl_id) {
				$new[$key]=$acl;	
			}
		}
		$lastACLs=json_encode($new);
		$updateOrganisationMeta = Yii::app()->db->createCommand();
		$updateOrganisationMeta->update('organisations_meta',
										array('value'=>$lastACLs), 
										'organisation_id=:organisation_id AND meta=:meta',
										array(':organisation_id'=>$id,':meta'=>'ACL'));

		$this->redirect(array('organisations/aCL/'.$id));
	}

	public function getACL($id){
		$acls = Yii::app()->db->createCommand()
		    ->select("*")
		    ->from("organisations_meta")
		    ->where("organisation_id=:organisation_id AND meta=:meta", array(':organisation_id' => $id,':meta'=>'ACL'))
		    ->queryRow();
		 return $acls['value'];
	}

	public function addACL($id,$name,$val1,$val2,$type,$comment,$status){
		$Acl=$this->getACL($id);
		if ($Acl) {
			$ACLs=json_decode($Acl);
		}
		else
		{
		$addorganisationMeta = Yii::app()->db->createCommand();
			$addorganisationMeta->insert('organisations_meta', array(
			    'organisation_id'=>$id,
			    'meta'=>'ACL',
			    'value'=>''
,			));
			$ACLs=array();
		}
		$found_flag=false;
		$new_ACLs=array();
		foreach ($ACLs as $ACL_item) {
			if(($ACL_item->id)==$status)
			{
				$found_flag=true;
				$ACL_item->id=$status;
				$ACL_item->name=$name;
				$ACL_item->type=$type;
				$ACL_item->val1=$val1;
				$ACL_item->val2=$val2;
				$ACL_item->comment=$comment;
			}
			$new_ACLs[]=$ACL_item;
		}
		$ACLs=$new_ACLs;
		if(!$found_flag)
		{
			$acl_id=functions::new_id(10);
			$newAcl['id']=$acl_id;
			$newAcl['name']=$name;
			$newAcl['type']=$type;
			$newAcl['val1']=$val1;
			$newAcl['val2']=$val2;
			$newAcl['comment']=$comment;
			$ACLs[]=$newAcl;
		}
		$lastACLs=json_encode($ACLs);

		$updateOrganisationMeta = Yii::app()->db->createCommand();
		$updateOrganisationMeta->update('organisations_meta',
										array('value'=>$lastACLs), 
										'organisation_id=:organisation_id AND meta=:meta',
										array(':organisation_id'=>$id,':meta'=>'ACL'));

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

	public function actionCreateBookCategory()
	{

		if(isset($_POST['category_name'])&&isset($_POST['organisationId']))
		{
			$status=Yii::app()->request->getPost('status');
			$category_name=Yii::app()->request->getPost('category_name');
			$retrieved_model=BookCategories::model()->find('category_id=:category_id',array(':category_id'=>$status));

			if($retrieved_model){
				$retrieved_model->category_name=$category_name;
				if($retrieved_model->save())
				{
					echo "success";
				}
				else
				{
					echo "fail:db";
				}

			}
			else
			{
			$category=new BookCategories;
			$category->category_id=functions::new_id(10);
			$category->category_name=$_POST['category_name'];
			$category->organisation_id=$_POST['organisationId'];
			$category->periodical=($_POST['periodical']) ? 1 : 0 ;
			if($category->save()){
				echo "success";
			}
			else
			{
				echo "fail:db";
			}
		}
		}
		else
		{
			echo "fail";
		}

		//$this->redirect(array('bookCategories','id'=>$_POST['organisation']));
	}

	public function actionUpdateBookCategory()
	{
		if(isset($_POST['categoryId'])&& isset($_POST['categoryName'])&&isset($_POST['organisation']))
		{
			$category=BookCategories::model()->findByPk($_POST['categoryId']);
			$category->category_name=$_POST['categoryName'];
			$category->save();
		}

		$this->redirect(array('bookCategories','id'=>$_POST['organisation']));
	}

	public function actionBookCategories($id=0)
	{
		$categories=false;
		if ($id) {
			$categories=BookCategories::model()->findAll('organisation_id=:organisation_id',array('organisation_id'=>$id));
		}
		$this->render('categories',array(
			'categories'=>$categories,
			'organisationId'=>$id
		));
	}

	public function actionDeleteCategory($category_id,$organisationId)
	{
		$category=BookCategories::model()->findByPk($category_id)->delete();
		$this->redirect(array('bookCategories','id'=>$organisationId));
	}

	public function getOrganisationEpubBudget($id)
	{
		$budget = Yii::app()->db->createCommand("select transaction_type, transaction_organisation_id,  SUM(amount)  as amount 
			from ( select transaction_type, transaction_organisation_id, transaction_currency_code, SUM(transaction_amount) as amount , SUM(transaction_amount_equvalent) as amount_equvalent  
		from transactions 
		where transaction_result = 0 and transaction_method = 'deposit'  
		group by transaction_type, transaction_organisation_id  
		Union select transaction_type, transaction_organisation_id, transaction_currency_code,  -1 * SUM(transaction_amount) as amount , -1 * SUM(transaction_amount_equvalent) as amount_equvalent  
		from transactions where transaction_result = 0 and transaction_method = 'withdrawal'  group by transaction_type, transaction_organisation_id, transaction_currency_code ) as tables 
		group by transaction_type, transaction_organisation_id")->queryAll();

		$amount=0;
		foreach ($budget as $key => $tr) {
			if ($tr['transaction_organisation_id']!=$id || $tr['transaction_type']!='epub')
				{
					unset($budget[$key]);
				}
				else{
					$amount=$tr['amount'];
				}
		}


		return $amount;
	}

	public function getRemainPlanDays($id){
		$lastDay=0;
		$plans=Transactions::model()->findAll('transaction_type="plan" AND transaction_method="deposit" AND transaction_result=0 AND transaction_organisation_id=:transaction_organisation_id AND `transaction_start_date`>= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND `transaction_start_date` <= CURDATE() ORDER BY `transaction_start_date`',array('transaction_organisation_id'=>$id));
		if ($plans) {
			foreach ($plans as $key => $plan) {
				if ($key==0) {
					$date = new DateTime($plan->transaction_start_date);
					$lastDay=$date->add(new DateInterval('P30D'));
				}
				else
					$lastDay=$lastDay->add(new DateInterval('P30D'));

			}
			$lastDay=$date->format('d-m-Y');
		}

		return $lastDay;
	}

	public function actionChangeTitle()
	{
		if (isset($_POST['title'])&&isset($_POST['organisation'])) {
			$organisation=Organisations::model()->findByPk($_POST['organisation']);
			$organisation->organisation_name=$_POST['title'];
			if($organisation->save())
			{
				echo "0";
			}else{
				echo "1";
			}
		}else{
			echo "1";
		}
	}
	
	public function actionAccount($id)
	{
		$books = Yii::app()->db->createCommand("SELECT count(*) as book FROM `book` b WHERE b.`workspace_id`=(select workspace_id from organisation_workspaces w where w.organisation_id='".$id."' and w.`workspace_id`=b.`workspace_id`)")->queryRow();
		$workspaces=Yii::app()->db->createCommand("SELECT count(*) as w FROM `organisation_workspaces` WHERE `organisation_id`='".$id."'")->queryRow();
		$hosts=Yii::app()->db->createCommand("SELECT count(*) as w FROM `organisation_hostings` WHERE `organisation_id`='".$id."'")->queryRow();
		$category=Yii::app()->db->createCommand("SELECT count(*) as w FROM `book_categories` WHERE `organisation_id`='".$id."'")->queryRow();
		$budget=$this->getOrganisationEpubBudget($id);
		$organisation=Organisations::model()->findByPk($id);
		$plan=Transactions::model()->find('transaction_type="plan" AND transaction_method="deposit" AND transaction_result=0 AND transaction_organisation_id=:transaction_organisation_id AND `transaction_start_date`>= DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND `transaction_start_date` <= CURDATE()',array('transaction_organisation_id'=>$id));
		$remainDay=0;
		$lastDay=$this->getRemainPlanDays($id);
		if ($lastDay) {
			$datetime1 = new DateTime('now');
			$datetime2 = new DateTime($lastDay);
			 $interval = $datetime1->diff($datetime2);
			 $remainDay=$interval->format('%a');
		}
		$this->render("account",array('book'=>$books['book'],'workspace'=>$workspaces['w'],'host'=>$hosts['w'],'category'=>$category['w'],'budget'=>$budget,'id'=>$id,'plan'=>$plan,'remainDay'=>$remainDay,'lastDay'=>$lastDay,'organisation'=>$organisation));
	}

	public function actionTemplates($id)
	{
		$templates=Book::model()->findAll('workspace_id=:workspace_id',array('workspace_id'=>$id));
		$this->render('templates',array(
			'templates'=>$templates,
			'workspace_id'=>$id
			));
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

	public function getUserWorkspaces()
	{
		$userid=Yii::app()->user->id;
		$templates=$this->getTemplateWorkspaces();

		$workspacesOfUser= Yii::app()->db->createCommand()
	    ->select("*")
	    ->from("workspaces_users x")
	    ->join("workspaces w",'w.workspace_id=x.workspace_id')
	    ->join("user u","x.userid=u.id")
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

	public function actionPublishedBooks($id)
	{
		$workspaces=OrganisationWorkspaces::model()->findAll('organisation_id=:organisation_id',array('organisation_id'=>$id));
		$qu='';
		foreach ($workspaces as $key => $workspace) {
			$qu.='workspace_id="'.$workspace->workspace_id.'" OR ';
		}
		$qu=substr($qu, 0, -3);
			$books= Book::model()->findAll(' ('.$qu.') AND publish_time IS NOT NULL AND publish_time!=0');
		$this->render('published_books',array(
			'books'=>$books,
			));
	}

	public function getOrganisationBudget($id)
	{
		$budget = Yii::app()->db->createCommand("select transaction_type, transaction_organisation_id,  SUM(amount)  as amount 
			from ( select transaction_type, transaction_organisation_id, transaction_currency_code, SUM(transaction_amount) as amount , SUM(transaction_amount_equvalent) as amount_equvalent  
		from transactions 
		where transaction_result = 0 and transaction_method = 'deposit'  
		group by transaction_type, transaction_organisation_id  
		Union select transaction_type, transaction_organisation_id, transaction_currency_code,  -1 * SUM(transaction_amount) as amount , -1 * SUM(transaction_amount_equvalent) as amount_equvalent  
		from transactions where transaction_result = 0 and transaction_method = 'withdrawal'  group by transaction_type, transaction_organisation_id, transaction_currency_code ) as tables 
		group by transaction_type, transaction_organisation_id")->queryAll();

		foreach ($budget as $key => $tr) {
			if ($tr['transaction_organisation_id']!=$id)
				{
					unset($budget[$key]);
				}
		}

		return $budget;
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
				$this->createTemplateWorkspace($model->organisation_id);
				$this->redirect(array('view','id'=>$model->organisation_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function createTemplateWorkspace($organisationId)
	{
		$model=new Workspaces;
		$model->workspace_id=functions::new_id();
		$model->workspace_name='Templates';
		$model->creation_time=date('Y-n-d g:i:s',time());
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
					return false;
				}

				$addWorkspaceOwner = Yii::app()->db->createCommand();
				$addWorkspaceOwner->insert('workspaces_users', array(
				    'workspace_id'=>$model->workspace_id,
				    'userid'=>Yii::app()->user->id,
				    'owner'=>'1',
				));

				$addorganisationMeta = Yii::app()->db->createCommand();
				if($addorganisationMeta->insert('organisations_meta', array(
				    'organisation_id'=>$organisationId,
				    'meta'=>'template',
				    'value'=>$model->workspace_id,
				)))
					return true;
			}

			return false;
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
	public function actionIndex($organizationId=null,$id=null)
	{
		if($organizationId==null){
			$organizationId=$id;
		}
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
					'organisationId'=>$organizationId,
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
		if($command->delete('workspaces_users', 'userid=:userid && workspace_id=:workspace_id', array(':userid'=>$userId,':workspace_id'=>$workspaceId)))
		{
			$msg="ORGANISATIONS:DEL_WORKSPACE_USER:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'workspaceId'=>$workspaceId,'organisationId'=>$organizationId)));
			Yii::log($msg,'info');
		}
		$this->redirect( array('organisations/workspaces?organizationId='.$organizationId ) );
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

			$msg="ORGANISATIONS:ADD_WORKSPACE_USER:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'workspaceId'=>$workspaceId,'organisationId'=>$organizationId)));
			Yii::log($msg,'info');

		$this->redirect( array('organisations/workspaces?organizationId='.$organizationId ) );
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
			if(Yii::app()->user->id!==$organizationUser->user_id)
				$users[]= User::model()->findByPk($organizationUser->user_id);
		}

		$invitated=OrganisationInvitation::model()->findAll('organisation_id=:organisation_id',array('organisation_id'=>$organisationId));
		
		$invitatedUsers=array();
		foreach ($invitated as $key => $user) {
			$invitatedUsers[]=User::model()->findByPk($user->user_id);
		}

		$this->render('users', array(
			'users'=>$users,
			'organisationId'=>$organisationId,
			'invitated'=>$invitatedUsers
			));
	}

	/**
	 * delete user from workspaces and organization
	 * @param  ID $userId         
	 * @param  ID $organisationId 
	 * @return redirect previous page
	 */
	public function actionDeleteOrganisationUser()
	{
		if (isset($_POST['userId']) AND isset($_POST['organisationId'])) {
			$userId=$_POST['userId'];
			$organisationId=$_POST['organisationId'];
			
			$organisationWorkspaces= OrganisationWorkspaces::model()->findAll('organisation_id=:organisation_id', 
		    				array(':organisation_id' => $organisationId) );
			foreach ($organisationWorkspaces as $key => $workspace) {
				$workspaceUser = WorkspacesUsers::model()->findByPk(array('userid'=>$userId,'workspace_id'=>$workspace->workspace_id));
				if ($workspaceUser) {
					$workspaceUser->delete();
				}
			}

			$user = OrganisationUsers::model()->findByPk(array('user_id'=>$userId,'organisation_id'=>$organisationId));
			if($user->delete())
			{
				$msg="ORGANISATIONS:DELETE_ORGANISATION_USER:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'organisationId'=>$organizationId)));
				Yii::log($msg,'info');
			}
			else
			{
				$msg="ORGANISATIONS:DELETE_ORGANISATION_USER:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'organisationId'=>$organizationId)));
				Yii::log($msg,'info');
			}
		}

		//$this->redirect( array('organisations/users?organizationId='.$organisationId ) );
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
		$link.='/user/invitation?key=';
		$organisation = Organisations::model()->findByPk($organisationId);

		//email adresinin doğruluğunu check eden regexp
		$regexp = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_-]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
		if (preg_match($regexp, $email)) {
		    //Email address is valid
			$user= User::model()->findByAttributes(array('email'=>$email) );
			if ($user) {
				$userId = $user->id;
			}
			else
			{
				// a user has NOT this email in users table.
				//we will create new user
				$user = new User;
				$criteria=new CDbCriteria;
				$criteria->select='max(id) AS maxColumn';
				$row = $user->model()->find($criteria);
				
				$userId = $row['maxColumn']+1;//functions::new_id();
				$user->id = $userId;
				$user->email=$email;
				$user->save();
			}
			
			//yeni davetiye oluşturuyoruz
			$invitation= new OrganisationInvitation;
			$invitation->organisation_id = $organisation->organisation_id;
			$invitation->user_id = $userId;
			$invitation->invitation_id = functions::new_id();
			$invitation->save();
			//linke davetiye IDsini de ekliyorum
			$link .= $invitation->invitation_id;

			$message=$organisation->organisation_name. " size editöre katılma isteği gönderdi. İsteği kabul etmek için <a href='".$link."'>tıklayın</a>.<br>".$link;	

			//mail gönderiyorum
			$mail=Yii::app()->Smtpmail;
	        $mail->SetFrom(Yii::app()->params['noreplyEmail'], $organisation->organisation_name);
	        $mail->Subject    = $organisation->organisation_name.' davetiye.';
	        $mail->MsgHTML($message);
	        $mail->AddAddress($email, "");
	        
	        if(!$mail->Send()) {
	            echo "Mailer Error: " . $mail->ErrorInfo;
	            $msg="ORGANISATIONS:ADD_USER:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'organisationId'=>$organisation->organisation_id,'message'=>'Mailer Error'.$mail->ErrorInfo)));
				Yii::log($msg,'info');
	        }else {
	            $success=__("Kullanıcı davet edildi.");
	            $msg="ORGANISATIONS:ADD_USER:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('userId'=>$userId,'organisationId'=>$organisation->organisation_id)));
				Yii::log($msg,'info');
	        }
		} else {
		    //Email address is NOT valid
		    $error = __("Girdiğiniz e-posta adresi geçersiz.");
		    $msg="ORGANISATIONS:ADD_USER:1:". json_encode(array(array('user'=>Yii::app()->user->id),array('organisationId'=>$organisation->organisation_id,'message'=>'invalid email address')));
			Yii::log($msg,'info');
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
