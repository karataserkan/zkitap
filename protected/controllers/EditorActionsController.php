<?php

class EditorActionsController extends Controller
{

	public $response=null; 
	public $errors=null; 

	public static function isJson($string) {
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
	}
	public function response($response_avoition=null){

		$response['result']=$response_avoition ? $response_avoition : $this->response;
		if ($this->errors) $response['errors']=$this->errors;
		$response_string=trim(json_encode($response));
		
		ob_start();
		header('Content-type: plain/text');
		header("Content-length: " . strlen($response_string) ); // tells file size

		ob_end_clean();
		echo trim($response_string);
	//	session_start();
		//echo $response_string;
		//session_start();
	}
 
	public function error($domain='EditorActions',$explanation='Error', $arguments=null,$debug_vars=null ){
		$error=new error($domain,$explanation, $arguments,$debug_vars);
		$this->errors[]=$error; 
		return $error;
	}

	public function actionEpubDownload()
	{
		$this->render('epub_download',array());
	}

	public function actionPreviewPage($id=null){
		

		$page=Page::model()->findByPk($id);
		
		
		if(!$page){
			$this->render('pageNotFound');
			return;
		}
		$chapter = Chapter::model()->findByPk($page->chapter_id);
		$book = Book::model()->findByPk($chapter->book_id);
		if(!$book){
			$this->render('pageNotFound');
			return;
		}
		$new_page=(object)$page->attributes;

		$components=(object)EditorActionsController::get_page_components($page->page_id);
		if($components){
			$new_page->components=$components;
		}
		$folder= "preview_files/".$id . "/";

		
		if(is_dir($folder))
			functions::deltree($folder);

		mkdir($folder);
		$new_page->file=new file($new_page->page_id . '.html', $folder  );

		
		
		 
		$new_page->file->writeLine(epub3::prepare_PageHtml($new_page,$book->getPageSize(),$folder  ));
		
		Yii::app()->request->redirect("/".$folder.$new_page->page_id . '.html');
		return;
		
	}


	public function actionProfilePhoto($email){
		$user=User::model()->find("email=:email",array('email'=>$email));
		if($user){
			$userMeta=UserMeta::model()->find("user_id=:user_id AND meta_key=:meta_key",array('user_id'=>$user->id,'meta_key'=>'profilePicture'));
			if($userMeta){
				echo $userMeta->meta_value;
			}
			else
			{
				echo null;
			}
		}
		else
		{
			echo null;
		}

	}
	public function actionPublishBook($bookId=null,$id=null){
		if($bookId==null){
			$bookId=$id;
		}
		$this->layout="//layouts/column2";

		$book=Book::model()->findByPk($bookId);
		//$workspace=Workspaces::model()->findByPk($book->workspace_id);
		// $organisationWorkspace=OrganisationWorkspaces::model()->findAll(array(
		//     'condition'=>'workspace_id=:workspace_id',
		//     'params'=>array(':workspace_id'=>$book->workspace_id),
		// ));

		$organisationWorkspace=Yii::app()->db->createCommand('select * from organisation_workspaces where workspace_id="'.$book->workspace_id.'"')->queryRow();
	
		$organisation=Organisations::model()->findByPk($organisationWorkspace['organisation_id']);
		$hosts=OrganisationHostings::model()->findAll(array(
		    'condition'=>'organisation_id=:organisation_id',
		    'params'=>array(':organisation_id'=>$organisation->organisation_id),
		));
		//var_dump($hosts);
		$categories=BookCategories::model()->findAll(array('condition'=>'organisation_id=:organisation_id','order'=>'`category_name` asc','params'=>array('organisation_id'=>$organisation->organisation_id)));
		//$pages=Page::model()->findAll(array("condition"=>"page_id=:page_id","order"=>'`order` asc ,  created asc',"params"=> array('page_id' => $page_id )));
		
		$model=new PublishBookForm;

		$model->contentId=$bookId;
		$model->created=date('Y-n-d g:i:s',time());
		$model->contentTitle=$book->title;
		$model->organisationId=$organisation->organisation_id;
		$model->organisationName=$organisation->organisation_name;
		$model->contentType='epub';
		$model->contentIsForSale="Yes";
		$model->contentPriceCurrencyCode="949";
		$model->contentPrice="0";
		$model->categories="1122";

		$budget=$this->getOrganisationEpubBudget($organisation->organisation_id);
		

		$acl = Yii::app()->db->createCommand()
		    ->select("*")
		    ->from("organisations_meta")
		    ->where("organisation_id=:organisation_id AND meta=:meta", array(':organisation_id' => $organisation->organisation_id,':meta'=>'ACL'))
		    ->queryRow();
		$acls=$acl['value'];

		$this->render('publishBook',array('model'=>$model,'hosts'=>$hosts,'categories'=>$categories,'bookId'=>$bookId,'acls'=>$acls,'budget'=>$budget));
	}

	public function actionGetFileURL($type=null){

		/* 
		generate a temp file url
		
		resposnse olarak URL string donsun

		*/

		do {

			$url='file'.functions::new_id();//functions::get_random_string(30);
			$isVideo= Yii::app()->db->createCommand()
		    ->select("*")
		    ->from("video_id")
		    ->where("id=:id", array(':id' => $url))
		    ->queryRow();

		} while ($isVideo);

		
		

		$this->response['token']= $url;
		$this->response['URL']= Yii::app()->request->hostInfo . "/uploads/files/".$url.".".$type;
		$this->response();

	}



    public function actionUploadFile	( $token=null ) {

    	/*
		get file contents

		find a place to write video file 

		which can be served as file to public access

		create file

		generate file url to  $Url

    	*/
    	    	
    	if ($token && isset($_POST['file'])) {
    		
    		//$videoFileContents = $_POST['video'];
    		
    		
    		//$videoFile = new file(path);


			$file= functions::save_base64_file ( $_POST['file'] , $token , Yii::app()->basePath.'/../uploads/files');
            
       
           	$addVideoId = Yii::app()->db->createCommand()
			->insert('video_id', array('id'=>$token));


            $CompleteURL=Yii::app()->request->hostInfo . "/uploads/files/".$file->filename ;

          


            $this->response['fileUrl']=$CompleteURL;



            
    	} else 
    	$this->error("EA-UpFile","File not sent",func_get_args(),$page);

  		return $this->response();



    	
    }


	public function actionListBooks(){
		$books=Book::model()->findAll();
		
		foreach ($books as $key => $book) {
			$this->response['books'][]=$book->attributes;
		}

		return $this->response();

	}

	public function actionAddToUndoStack($id,$type,$undoAction, $undoParam){
		$username=Yii::app()->user->name;
	}

	public function get_templates(){
			return $templateBooks=Book::model()->findAll(array("condition"=>"workspace_id='layouts'"));
	}

	public function actionGetTemplates(){
		$templateBooks=$this->get_templates();

		foreach ($templateBooks as $key => $templateBook) {
			$return->bookTemplates[]=$templateBook->attributes;

		}
		return $this->response($return);


	}

	public function getPagesOfBook($bookId){
		$defaultChapter=Chapter::model()->find(array("condition"=>"book_id=:book_id","params"=> array('book_id' => $bookId )));

		$bookPages=Page::model()->findAll(array("condition"=>"chapter_id=:chapter_id","params"=> array('chapter_id' => $$defaultChapter->chapter_id )));

		if (!$bookPages) {
			$this->error('getPagesOfBook','Book not found');
			return false;

		}

		return $bookPages;

	}

	public function getPageComponents($page_id=null){
		$pages=Page::model()->findAll(array("condition"=>"page_id=:page_id","order"=>'`order` asc ,  created asc',"params"=> array('page_id' => $page_id )));

	}
	public function addTemplate(){
		
	}

	public function get_page_components($pageId){
		$page=Page::model()->findByPk($pageId);
		if (!$page) {
			$this->error("EA-GPCom","Page Not Found",func_get_args(),$page);
			return false;
		}
		
		

		$components= Component::model()->findAll(  array('condition' => 'page_id=:page_id',
			'params' =>  array(':page_id' =>  $pageId )  )  );


		if(!$components)  {
			$this->error("EA-GPCom","Component Not Found",func_get_args());
			return false;
		}

		$get_page_components= array();

		foreach ($components as $key => &$component) {
			$component->data=$component->get_data();
			$get_page_components[]=$component->attributes;
		}


		return $get_page_components;
	}


	public function actionGetPageComponents($pageId){
		$response=null;
		if($return=$this->get_page_components($pageId)){
			$response['components']=$return;
		} 
		echo $this->response($response);
		//return $this->response($response);
	}

	public function actionGetTemplatePages($template_book_id){
		$templatePages=getPagesOfBook($template_book_id);
		

		foreach ($templatePages as $key => $templatePage) {
			$return->templatePages[]=$templatePage->attributes;
		}

	}


	public function actionIndex(){
		$methodNames=get_class_methods('EditorActionsController');
		foreach ($methodNames as $key => $methodName) {
			# cdoe...
			
			$r = new ReflectionMethod('EditorActionsController', $methodName);
			$params = $r->getParameters();
			foreach ($params as $param) {
				$paramn->name=$param->getName();
				$paramn->isOptional=$param->isOptional() ? "Optional" : "Not Optional";
				if ($param->isDefaultValueAvailable()) $paramn->DefaultValue=var_export($param->getDefaultValue(),true);
				if(substr($methodName,0,6)=='action') 
					$parameters[$methodName]['params'][]=$paramn; 
			    //$param is an instance of ReflectionParameter
			    //echo $param->getName();
			    //echo $param->isOptional();
			    unset($paramn); 
			}
		}
		new dBug($parameters);
	}

	public function addChapter($bookId,$attributes=null){
		
		$book=Book::model()->findByPk($bookId);
		if (!$book) {
			$this->error("EA-AC1","Book Not Found",func_get_args(),$book);
			return false;
		}

		$new_chapter= new Chapter;
		$new_id=functions::new_id();
		
		$new_chapter->chapter_id=$new_id;
		$new_chapter->book_id=$book->book_id;

		$new_chapter->save();
		
		$result= Chapter::model()->findByPk($new_id);
		
 
		if(!$result) {
			$this->error("EA-AC1","Chapter couldn't Found!",func_get_args(),$new_id);
			return false;
		}
		$return->chapter=$result->attributes;
		$return->pages[]=$this->AddPage($result->chapter_id)->attributes;
		return $return;
	}



	public function actionAddChapter($bookId,$attributes=null)
	{
		if($return=$this->addChapter($bookId,$attributes)){
			$response['chapter']=$return->chapter;
			$response['pages']=$return->pages;
		}
		return $this->response($return);
	}



		

	public function addComponent($pageId,$attributes=null){

		
			$page=Page::model()->findByPk($pageId);

			if (!$page) {
				$this->error("EA-ACom","Page Not Found",func_get_args(),$page);
				return false;
			}

			$new_component= new Component;
			$new_id=functions::new_id();
			
			$new_component->id=$new_id;
			$new_component->page_id=$page->page_id;



			$component_attribs=json_decode($attributes);

	                //var_dump($component_attribs);
	                //exit();

			if($component_attribs->data->img->src  ) {
				$component_attribs->data->img->src =$component_attribs->data->img->src;
			}

			if($component_attribs->data->imgs)
				foreach ($component_attribs->data->imgs as $gallery_key => &$gallery_image) {
					if($gallery_image->src)
						$gallery_image->src=functions::compressBase64Image($gallery_image->src);
				}
			//know bug : component type validation


			$new_component->type=$component_attribs->type;
			$new_component->set_data($component_attribs->data);
			//new dBug($component_attribs);
			
			if(!$new_component->save()){
				$this->error("EA-ACom","Component Not Saved",func_get_args(),$new_component);
				return false;
			} 
			$result= Component::model()->findByPk($new_id);

			
			$result->data=$result->get_data();

			

			if(!$result)  {
				$this->error("EA-ACom","Component Not Found",func_get_args(),$new_component);
				return false;
			}


			return $result->attributes;

	}


	public function actionAddComponent($pageId,$attributes=null)
	{
		if(EditorActionsController::isJson($attributes))
		{
			$response=false;

			if($return=$this->addComponent($pageId,$attributes)){
					$response['component']=$return; 
			}
			return $this->response($response);
		}
		else
		{
			return $this->response(json_encode(array("success"=>false,"message"=>"you should wait while the component is being saved!")));

		}

	}


	public function addPage($chapterId,$pageTeplateId=null,$attributes=null){
		$chapter=Chapter::model()->findByPk($chapterId);
		if (!$chapter) { 
			$this->error("EA-ACom","Chapter Not Found",func_get_args(),$chapter);
			return false;
		}

		$new_page= new Page;
		$new_id=functions::new_id();
		
		$new_page->page_id=$new_id;
		$new_page->chapter_id=$chapter->chapter_id;
		$new_page->save();

		if (isset($pageTeplateId)) {
			$components = Component::model()->findAll(array(
				'condition' => 'page_id=:page_id',
				'params' => array(':page_id'=> $pageTeplateId)
				));

			if ($components) {
				foreach ($components as $ckey => $component) {
					$newComponent = new Component;
					$newComponent->id=functions::get_random_string();
					$newComponent->type=$component->type;
					$newComponent->data=$component->data;
					$newComponent->created=date("Y-m-d H:i:s");
					$newComponent->page_id=$new_id;
					$newComponent->save();
				}
			}
		}

		
		$result= Page::model()->findByPk($new_id);
		

		if(!$result) {
			$this->error("EA-ACom","Page Not Found",func_get_args(),$new_component);
			return false;
		}

		return $result->attributes;

	}
	
	public function actionAddPage($chapterId,$attributes=null) 
	{
		if($return=$this->addPage($chapterId,$attributes)){
			$response['page']=$return;
		}
		return $this->response($response);
		
	}
	
	public function deleteChapter($chapterId){
		$result=Chapter::model()->findByPk($chapterId);
		if(!$result){
			$this->error("EA-DC","Chapter Not Found!");
			return false;
		} 
		if( $result->delete() ){return $chapterId;}

	}

	public function actionDeleteChapter($chapterId)
	{	

			return $this->response($this->deleteChapter($chapterId));


	}

	public function deleteComponent($componentId){
		$component=Component::model()->findByPk($componentId);
		if (!$component) {
			$this->error("EA-DCom","Component Not Found",func_get_args(),$component);
			return false;
		}

		if($component->model()->deleteByPk($componentId))
			return true;
		else {
			$this->error("EA-DCom","Component Could Not Deleted",func_get_args(),$componentId);
			return false;
		}
	}

	public function actionDeleteComponent($componentId)
	{
		$response= array( );

		if($return=$this->deleteComponent($componentId) ){
				$response['delete']=$componentId;
		}

		return $this->response($response);
	}


	public function deletePage($pageId){
		$result=Page::model()->findByPk($pageId);
		if(!$result){
			$this->error("EA-DP","Page Not Found!");
			return false;
		} 
		if( $result->delete() ){return $pageId;}

	}

	public function actionDeletePage($pageId)
	{
		return $this->response($this->deletePage($pageId));
	}

	public function UpdateChapter($chapterId,$title=null,$order=null){
		$chapter=Chapter::model()->findByPk($chapterId);
		if (!$chapter) {
			$this->error("EA-UChapter","Chapter Not Found",func_get_args(),$chapterId);
			return false;
		}
		$chapter->title=$title;
		$chapter->order=$order;


		if(!$chapter->save()){
			$this->error("EA-UChapter","Chapter Not Saved",func_get_args(),$chapterId);
			return false;
		}
		return $chapter->attributes;


	}


	public function actionUpdateChapter($chapterId,$title=null,$order=null)
	{

		$response=false;

		if($return=$this->UpdateChapter($chapterId,$title,$order) ){
				$response['chapter']=$return; 
		}

		return $this->response($response);

	}

	public function actionUpdateComponentData($componentId,$data_field,$data_value)
	{
		$this->render('updateComponent');
	}


	public function updateComponent($componentId,$jsonProperties){
		$component=Component::model()->findByPk($componentId);
		if (!$component) {
			$this->error("EA-UWholeCom","Component Not Found",func_get_args(),$component);
			return false;
		}

		// For revision: Save Component State for Undo etc. Here!


		$component_attribs=json_decode($jsonProperties);
		//know bug : component type validation
 


		$component->set_data($component_attribs->data);
		//new dBug($component_attribs);
		
		if(!$component->save()){
			$this->error("EA-UWholeCom","Component Not Saved",func_get_args(),$component);
			return false;
		} 
		 
		$result= Component::model()->findByPk($componentId);
		$result->data=$result->get_data();


		if(!$result)  {
			$this->error("EA-UWholeCom","Component Not Found",func_get_args(),$result);
			return false;
		}


		return $result->attributes;

	}

 

	public function actionUpdateWholeComponentData($componentId,$jsonProperties)
	{
		if(EditorActionsController::isJson($jsonProperties))
		{
			$response=false;

			if($return=$this->updateComponent($componentId,$jsonProperties) ){
					$response['component']=$return; 
			}

			return $this->response($response);
		}
		else
		{
			return $this->response(json_encode(array("success"=>false,"message"=>"you should wait while the component is being saved!")));

		}
	}

	public function UpdatePage($pageId,$chapterId,$order){
		
		$page=Page::model()->findByPk($pageId);
		if (!$page) {
			$this->error("EA-UPage","Page Not Found",func_get_args(),$pageId);
			return false;
		}

		$page->chapter_id=$chapterId;
		$page->order=$order;


		if(!$page->save()){
			$this->error("EA-UPage","UPage Not Saved",func_get_args(),$pageId);
			return false;
		}
		
		return $page->attributes;


	}
 
	public function actionUpdatePage($pageId,$chapterId,$order)
	{

		$response=false;

		if($return=$this->UpdatePage($pageId,$chapterId,$order) ){
				$response['component']=$return; 
		}

		return $this->response($response);
	}

	public function SearchOnBook($currentPageId,$searchTerm=' '){

		$currentPage= Page::model()->findByPk($currentPageId) ;
		$chapter=Chapter:: model()->findByPk($currentPage->chapter_id) ;
		$bookId=$chapter->book_id;

		if(strlen($searchTerm)<2) {
			$this->error("EA-SearchOnBook","Too Short Seach Term",func_get_args(),$searchTerm);
			return null;
		}


		$sql="select * from component 
right join page  using (page_id) 
right join chapter using (chapter_id) 
right join book using (book_id) where book_id='$bookId' and type!='image';";
 		//echo $sql;

		$components = Component::model()->findAllBySql($sql);
		foreach ($components as $keyz => &$value) {
			$searchable="";
			if ($value->get_data())
			foreach ($value->get_data() as $key2 => $items) {
				if ( is_array($items) || is_object($items) )
				foreach ($items as $key => $value2) {
					if($key!='css') $searchable.=serialize($value2);
				}
			}
 
			$searchable.=" ";


			$searchable=str_replace(array('O:',':','"','{','}',';'), ' ', $searchable);
			$searchable_small=functions::ufalt($searchable);
				
			if( 
			 	substr_count ( $searchable_small , functions::ufalt($searchTerm) )==0 
			 ) 
				unset($components[$keyz]);
			else {


				$value->data = $value->get_data();
				$value=$value->attributes;
 
				$value[search]->searchable=$searchable;
				$value[search]->searchTerm=$searchTerm;
				$value[search]->position=strpos($searchable_small,functions::ufalt($searchTerm));

				$value[search]->next_space_position= strpos($searchable, " ", $value[search]->position + strlen($searchTerm)+1 );
				

				$value[search]->previous_space_position= strrpos(substr($searchable,0,$value[search]->position),' ' );



				$value[search]->similar_result=substr($searchable,$value[search]->previous_space_position+1,  $value[search]->next_space_position - $value[search]->previous_space_position);
				$value[search]->similar_result_old=substr($searchable,$value[search]->position,  $value[search]->next_space_position - $value[search]->position);
				

			}
		
		} 
		//new dBug($components);
		usort($components,'sortify');

		return $components;



	}

 
	public function actionSearchOnBook($currentPageId,$searchTerm=' '){
		

		$response=false;

		if($return=$this->SearchOnBook($currentPageId,$searchTerm) ){
				$response['components']=$return; 
		}

		return $this->response($response);
		
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

	public function SendFileToQueue($bookId)
	{
		ob_start();
		$book=Book::model()->findByPk($bookId);
		$bookData=json_decode($book->data,true);

		
		

		if (!empty($_POST)) {
			$budget=$this->getOrganisationEpubBudget($_POST['PublishBookForm']['organisationId']);
			if ($budget<=0) {
				return "budgetError";
			}
		

			$data['organisationId']=$_POST['PublishBookForm']['organisationId'];
			$data['organisationName']=$_POST['PublishBookForm']['organisationName'];
			$data['created']=$_POST['PublishBookForm']['created'];
			$data['contentTitle']=$_POST['contentTitle'];
			$data['contentType']=$_POST['contentType'];
			$data['contentExplanation']=$_POST['contentExplanation'];
			$data['contentIsForSale']=$_POST['contentIsForSale'];
			$data['contentCurrencyCode']=$_POST['contentCurrency'];
			$data['contentPrice']=$_POST['contentPrice'];
			$data['date']=$_POST['date'];
			//$data['contentReaderGroup']=$_POST['contentReaderGroup'];
			$data['contentCover']=$bookData['cover'];
			$data['contentThumbnail']=$bookData['thumbnail'];
			$data['tracking']=htmlspecialchars($_POST['tracking']);
			
			//book detail
			$data['abstract']=$_POST['abstract'];
			$data['language']=$_POST['language'];
			$data['subject']=$_POST['subject'];
			$data['edition']=$_POST['edition'];
			$data['author']=$_POST['author'];
			$data['translator']=$_POST['translator'];
			$data['issn']=$_POST['issn'];

			$data['totalPage']=$ebook->totalPageCount;
			$data['toc']=json_encode($ebook->TOC_Titles);

			if (isset($_POST['acl'])) {
				$acls=$_POST['acl'];

				$allAclsRow=Yii::app()->db->createCommand()
				    ->select("*")
				    ->from("organisations_meta")
				    ->where("organisation_id=:organisation_id AND meta=:meta", array(':organisation_id' => $data['organisationId'],':meta'=>'ACL'))
				    ->queryRow();
				 $allAcls=json_decode($allAclsRow['value']);
				 
				 if (in_array('all', $acls)) {
				 	foreach ($acls as $key => $aclId) {
				 		if ($aclId=='all') {
				 			continue;
				 		}
				 		foreach ($allAcls as $key => $acl) {
							$data['acls'][$acl->id]['id']=$acl->id;
							$data['acls'][$acl->id]['name']=$acl->name;
							$data['acls'][$acl->id]['type']=$acl->type;
							$data['acls'][$acl->id]['val1']=$acl->val1;
							$data['acls'][$acl->id]['val2']=$acl->val2;
							$data['acls'][$acl->id]['comment']=$acl->comment;
						}
				 	}
				 }
				 else
				 {
				 	foreach ($acls as $key => $aclId) {
				 		foreach ($allAcls as $key => $acl) {
							if ($acl->id==$aclId) {
								$data['acls'][$acl->id]['id']=$acl->id;
								$data['acls'][$acl->id]['name']=$acl->name;
								$data['acls'][$acl->id]['type']=$acl->type;
								$data['acls'][$acl->id]['val1']=$acl->val1;
								$data['acls'][$acl->id]['val2']=$acl->val2;
								$data['acls'][$acl->id]['comment']=$acl->comment;
							}
						}
				 	}
				 }
			 }

			if (isset($_POST['host'])) {
				$hosts=$_POST['host'];
				foreach ($hosts as $key => $hostId) {
					$host=OrganisationHostings::model()->findByPk($hostId);
					$data['hosts'][$hostId]['host']=$host->hosting_client_IP;
					$data['hosts'][$hostId]['port']=$host->hosting_client_port;
					$data['hosts'][$hostId]['key1']=$host->hosting_client_key1;
					$data['hosts'][$hostId]['key2']=$host->hosting_client_key2;
					$data['hosts'][$hostId]['id']=$host->hosting_client_id;
					
					$data['hosting_client_IP']=$host->hosting_client_IP;
					$data['hosting_client_id']=$host->hosting_client_id;
				}

			}
			else
			{
				//hard-coded host id!
				/*
				$host=OrganisationHostings::model()->findByPk('GIWwMdmQXL');
				$data['hosts']['GIWwMdmQXL']['host']=$host->hosting_client_IP;
				$data['hosts']['GIWwMdmQXL']['port']=$host->hosting_client_port;
				$data['hosts']['GIWwMdmQXL']['key1']=$host->hosting_client_key1;
				$data['hosts']['GIWwMdmQXL']['key2']=$host->hosting_client_key2;
				$data['hosts']['GIWwMdmQXL']['id']=$host->hosting_client_id;

				$hosting_client_IP=$host->hosting_client_IP;
				$hosting_client_id=$host->hosting_client_id;*/
			}


			if ($_POST['categoriesSirali']) {
				$categories=$_POST['categoriesSirali'];
				foreach ($categories as $key => $categoryId) {
					$siraliCategory=BookCategories::model()->findByPk($categoryId);
					$data['siraliCategory'][$categoryId]['category_id']=$siraliCategory->category_id;
					$data['siraliCategory'][$categoryId]['category_name']=$siraliCategory->category_name;
				}
			}
			$data['siraNo']=$_POST['contentSiraliSiraNo'];
			$data['ciltNo']=$_POST['contentSiraliCiltNo'];



			if (isset($_POST['categories'])&& !empty($_POST['categories'])) {
				$categories=$_POST['categories'];
				foreach ($categories as $key => $categoryId) {
					$category=BookCategories::model()->findByPk($categoryId);
					$data['categories'][$categoryId]['category_id']=$category->category_id;
					$data['categories'][$categoryId]['category_name']=$category->category_name;
				}
			}
			else
			{
				//hard-coded bookcategory
				/*
				$category=BookCategories::model()->findByPk('1122');
				$data['categories'][$categoryId]['category_id']=$category->category_id;
				$data['categories'][$categoryId]['category_name']=$category->category_name;
				*/
			}
			
		}

		
		$host_ip=trim(shell_exec("/sbin/ifconfig eth0 | awk '/inet / { print $2 }' | sed -e s/addr://"));
		//$host_ip="31.210.53.80";
		//$data['contentTrustSecret']=sha1($data['checksum']."ONLYUPLOAD".$bookId.$host_ip);

		

		$data['hosts']=json_encode($data['hosts']);
		$data['acls']=json_encode($data['acls']);
		$data['categories']=json_encode($data['categories']);
		$data['siraliCategory']=json_encode($data['siraliCategory']);

		$queue= new PublishQueue();
		$queue->book_id=$bookId;
		$queue->publish_data=json_encode($data);
		print_r($queue);
		$queue->save();

		$book->publish_time=date('Y-n-d g:i:s',time());
		$book->save();
	}

	private function errorQueue($bookId,$message)
	{
		$updateQueue=PublishQueue::model()->findByPk($bookId);
		$updateQueue->is_in_progress=-1;
		$updateQueue->success=-1;
		$updateQueue->message=json_encode($message);
		$updateQueue->save();
	} 

	public function actionStartPublishing()
	{
		$publishAllSeviye=false;
		if($publishAllSeviye){
				$books=Book::model()->findAll();
				foreach ($books as $key => $book) {
					$book_name=$book->title;
		
					$as=(object) (array(   'organisationId' => 'seviye',   'organisationName' => 'Seviye',   'created' => '2014-4-08 2:31:06',   'contentTitle' => $book_name ,   'contentType' => 'epub',   'contentExplanation' => $book_name ,   'contentIsForSale' => 'Free',   'contentCurrencyCode' => '949',   'contentPrice' => '0',   'date' => '08/04/2014',   'contentCover' => 'data:image/jpeg;base64,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',   'contentThumbnail' => 'data:image/jpeg;base64,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',   'abstract' => 'Seviye Yayınları Kitapları',   'language' => 'Türkçe',   'subject' => 'Seviye Yayınları',   'edition' => '',   'author' => 'Seviye Yayınları',   'translator' => '',   'issn' => '',   'totalPage' => NULL,   'toc' => 'null',   'hosts' => '{"GISSMdmQXL":{"host":"cloud.okutus.com","port":"2222","key1":"MIIEpgIBAAKCAQEA09K0zR2CNXAJtJt4x3aXgLkC7N7et3f6EgN0nAimA0RlRBlr\nOf55m83G\/ThrVZ6vLA+EVsYrog07WrouDtBh7OZ6vUHRD\/0YqtX49pPJR5ahI569\nTofJ7ZViyWcO5DEG0udpUWKgawuEpFdu+aKwE1b89\/ggy6G1IKPzcRAwzZvbfb5g\nPXgHZHf+OOdQQi3qYI7iUhpbIZuMTY9rsd8QmA+Op7PeONVfOJ9QrCYO71TVUdHi\nFOx9xYyOoas+6fLcdkEllmX+XAwxY4UyE4e5BaUhamti9roYcQKBy4Prs\/39rPDA\nrIyYh8CLxDKFRPjb1qL\/4ecwtOqdcTRInTUJmwIDAQABAoIBAQC9JYTPOA9iWlZA\nUSgrrKkih5KmI2lrGRZTaYSCJHLhrfxjL\/OAyMycpMaQrQWjYdx4Eq8QsUqbHQeo\nP2ILVmZrHW\/yecgOZ+nT+teij1sHsujXHtNaQYS9w0yAHae9ek3mnD9+LfyjOZjL\nC0wMXAqwalffsVDPpOlRaTVj+5ooreg+psuDd7IIcF+\/u1jAhweRkhGdCEeWux14\nqjGznyT+4vwD26oakGNOPO5hRw3JfLAvrQcfBxwU1IGAqJh8XQNG0h\/CWjVqFmo3\nHtJZ214\/1lpzkA8bzTlRofDIlGDUH45T0C7rfwgYNBCXKBazbCRzIYtmsc3bLcaB\n3JlXuBERAoGBAPgKp+VG8mIbq3r3YuFHozkyA3plXc3BKUW0aQkMDXW9FXYDRQM8\n\/aDmK09pMVWEW6dnwh1MNZXuiMoWyMCZrM3VdHRDd7TJfWLNfCnCHEZ14ShaAmDY\n9yuEJC1Dv+0ni3zcSe9XlD+MtEVIVcPNTc77Ptwn91E\/aqcpkj4FixlDAoGBANqe\nj7gERkmf+xiOnPETqT0jCozIqRd+Iyza8932FS3wYaZZugx\/aZFibqFeBOImnGpJ\nABmhrgieR38j8HKKvtI0M28YqaKSAwOiHhN97nRarsb2nayeB2zbq9Ml3RbLVVhd\n6AQyEy\/ZwMFAztmOOmcwbnKq3s45OapL3xPuO7zJAoGBAOxHUkpA\/BFi5EXdtI5+\n7EhGkTOdre6bC1LAGbIpjgTTGsdxM+NyzPPhbe5WeU1KKPjeCPZZq03ojNtdOtzl\nRsxIgodh4X0Q1uUwcw9gPgkMr2\/91fgllcYZOVD5EbG6ktBdE\/zvw2OKCAtbbX94\naZ86jFWxqJD3xQP5wLpeE3P7AoGBAJddsaR3UTMo0XHvTDqeok7yNBvF002wyCoG\nb1L\/Tyq\/hNzowyhkD3PZ8z9HGZp7oVD1ulwE1bqh3F7rQ1ALQJPKENKbANjOv8eE\nN87HIpLtNpYLqqAZyopUjmNjk\/B0WGMWoc5F3YMEAbHMbWu0TjukDNTX+exPMt32\nKj5idHoBAoGBAKM0zMue2k1T5PJFpegCTt75L\/qEL5BZJh1eRYNtjd79pfqUo0FT\n8LnVmqoPwB3tHjRaBRU6V12xqe4COSYMS80ErM99faulZNuze2aztBmom8iVDiPV\nEcg14YeaJZgncBjGT2Qd\/D8RAudMr4tNobxc6o9HBElPEuow+TKjjDj4","key2":"MIIEpgIBAAKCAQEA09K0zR2CNXAJtJt4x3aXgLkC7N7et3f6EgN0nAimA0RlRBlr\nOf55m83G\/ThrVZ6vLA+EVsYrog07WrouDtBh7OZ6vUHRD\/0YqtX49pPJR5ahI569\nTofJ7ZViyWcO5DEG0udpUWKgawuEpFdu+aKwE1b89\/ggy6G1IKPzcRAwzZvbfb5g\nPXgHZHf+OOdQQi3qYI7iUhpbIZuMTY9rsd8QmA+Op7PeONVfOJ9QrCYO71TVUdHi\nFOx9xYyOoas+6fLcdkEllmX+XAwxY4UyE4e5BaUhamti9roYcQKBy4Prs\/39rPDA\nrIyYh8CLxDKFRPjb1qL\/4ecwtOqdcTRInTUJmwIDAQABAoIBAQC9JYTPOA9iWlZA\nUSgrrKkih5KmI2lrGRZTaYSCJHLhrfxjL\/OAyMycpMaQrQWjYdx4Eq8QsUqbHQeo\nP2ILVmZrHW\/yecgOZ+nT+teij1sHsujXHtNaQYS9w0yAHae9ek3mnD9+LfyjOZjL\nC0wMXAqwalffsVDPpOlRaTVj+5ooreg+psuDd7IIcF+\/u1jAhweRkhGdCEeWux14\nqjGznyT+4vwD26oakGNOPO5hRw3JfLAvrQcfBxwU1IGAqJh8XQNG0h\/CWjVqFmo3\nHtJZ214\/1lpzkA8bzTlRofDIlGDUH45T0C7rfwgYNBCXKBazbCRzIYtmsc3bLcaB\n3JlXuBERAoGBAPgKp+VG8mIbq3r3YuFHozkyA3plXc3BKUW0aQkMDXW9FXYDRQM8\n\/aDmK09pMVWEW6dnwh1MNZXuiMoWyMCZrM3VdHRDd7TJfWLNfCnCHEZ14ShaAmDY\n9yuEJC1Dv+0ni3zcSe9XlD+MtEVIVcPNTc77Ptwn91E\/aqcpkj4FixlDAoGBANqe\nj7gERkmf+xiOnPETqT0jCozIqRd+Iyza8932FS3wYaZZugx\/aZFibqFeBOImnGpJ\nABmhrgieR38j8HKKvtI0M28YqaKSAwOiHhN97nRarsb2nayeB2zbq9Ml3RbLVVhd\n6AQyEy\/ZwMFAztmOOmcwbnKq3s45OapL3xPuO7zJAoGBAOxHUkpA\/BFi5EXdtI5+\n7EhGkTOdre6bC1LAGbIpjgTTGsdxM+NyzPPhbe5WeU1KKPjeCPZZq03ojNtdOtzl\nRsxIgodh4X0Q1uUwcw9gPgkMr2\/91fgllcYZOVD5EbG6ktBdE\/zvw2OKCAtbbX94\naZ86jFWxqJD3xQP5wLpeE3P7AoGBAJddsaR3UTMo0XHvTDqeok7yNBvF002wyCoG\nb1L\/Tyq\/hNzowyhkD3PZ8z9HGZp7oVD1ulwE1bqh3F7rQ1ALQJPKENKbANjOv8eE\nN87HIpLtNpYLqqAZyopUjmNjk\/B0WGMWoc5F3YMEAbHMbWu0TjukDNTX+exPMt32\nKj5idHoBAoGBAKM0zMue2k1T5PJFpegCTt75L\/qEL5BZJh1eRYNtjd79pfqUo0FT\n8LnVmqoPwB3tHjRaBRU6V12xqe4COSYMS80ErM99faulZNuze2aztBmom8iVDiPV\nEcg14YeaJZgncBjGT2Qd\/D8RAudMr4tNobxc6o9HBElPEuow+TKjjDj4","id":"GISSMdmQXL"}}',   'hosting_client_IP' => 'cloud.okutus.com',   'hosting_client_id' => 'GISSMdmQXL',   'siraNo' => '',   'ciltNo' => '',   'categories' => '{"2112112123":{"category_id":"2112112123","category_name":"Seviye yay\u0131nlar\u0131"}}',   'contentTrustSecret' => '4dfadb0274b8cdf06e328f967db8420f64f19e5b',   'acls' => 'null',   'siraliCategory' => 'null',));
					$queue= new PublishQueue();
					$queue->book_id=$book->book_id;
					$queue->publish_data=json_encode($as);
					$queue->save();
					// code...
				}
				die;

			}

		$this->SendFileToCatalog();
	}	

	private function SendFileToCatalog(){
		ob_start();

		
		$QueueBooks=PublishQueue::model()->findAll('is_in_progress=:is_in_progress AND timestamp > (NOW() - INTERVAL 10 MINUTE)',array('is_in_progress'=>1));
		if(count($QueueBooks)>0){echo "Already in progress!";die();}
		$Queue=PublishQueue::model()->find('is_in_progress=:is_in_progress',array('is_in_progress'=>0));
		if(count($Queue)==0){
			echo "Nothing to do!";
			Yii::app()->db->createCommand("update publish_queue set is_in_progress = 0 , trial = trial + 1 where is_in_progress != 0 and trial<3 ")->query();
			die();
		}
		$booksInQueue=array();
		//foreach ($QueueBooks as $QueueBookKey0 => $Queue) {
			$queueInProgress=PublishQueue::model()->findByPk($Queue->book_id);
			$queueInProgress->is_in_progress=1;
			$queueInProgress->save();
			$booksInQueue[]=$queueInProgress;
			Yii::app()->db->createCommand("update publish_queue set timestamp = CURRENT_TIMESTAMP where book_id ='$Queue->book_id' and trial<3 ")->query();

		//}		

		foreach ($booksInQueue as $QueueBookKey => $QueueBook) {
			$bookId=$QueueBook->book_id;
			echo $bookId;
			$data=json_decode($QueueBook->publish_data,true);
		
			$book=Book::model()->findByPk($bookId);
			$bookData=json_decode($book->data,true);
			$ebook=new epub3($book,false,true);
			

			if (!file_exists($ebook->ebookFile)) {
				$this->error('SendFileToCatalog','File does not exists!');
				$msg="EDITOR_ACTIONS:SendFileToCatalog:0:Could Not Found the created Ebook File". json_encode(array(array('user'=>Yii::app()->user->id),array('bookId'=>$bookId)));
				Yii::log($msg,'error');
				$this->errorQueue($bookId,$msg);

				return;
			}

			$localFile = $ebook->ebookFile; // This is the entire file that was uploaded to a temp location.
			$fp = fopen($localFile, 'r');

			$data['contentId']=$bookId;
			$data['contentFile']='@'.$ebook->ebookFile;
			$data['checksum']=md5_file($ebook->ebookFile);
			//Connecting to website.

			ini_set('max_execution_time', 0);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, Yii::app()->params['catalogExportURL'] );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			ini_set('max_execution_time',0);	

			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 


			$Return['response']=json_decode(curl_exec($ch));

			if (curl_errno($ch)){  
				$this->error('SendFileToCatalog','CURL_ERROR:'.curl_error($ch));
			    $msg="EDITOR_ACTIONS:SendFileToCatalog:0:CURL_ERROR:".curl_error($ch). json_encode(array(array('user'=>Yii::app()->user->id),array('bookId'=>$bookId)));
				Yii::log($msg,'error');
				$this->errorQueue($bookId,$msg);
				
				return;
			}

			$msg = 'File uploaded successfully.';
			curl_close ($ch);
			$Return['msg'] = $msg;

			
			ob_end_clean();
			echo json_encode( $Return );


			$res=$Return;
			$res_res=$res['response'];
			$ip = $_SERVER['REMOTE_ADDR'];
	        if($ip){
	            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	                $ip = $_SERVER['HTTP_CLIENT_IP'];
	            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	            }
	        }
	        else
	        	$ip ='0';
			
			$attr=array();
			$attr['transaction_book_id']=$bookId;
			$attr['transaction_user_id']=Yii::app()->user->id;
			$attr['transaction_organisation_id']=$data['organisationId'];
			$attr['transaction_start_date']=date('Y-n-d g:i:s',time());
			$attr['transaction_method']='withdrawal';
			$attr['transaction_unit_price']=0;
			$attr['transaction_amount_equvalent']=0;
			$attr['transaction_currency_code']=0;
			$attr['transaction_host_ip']=$data['hosting_client_IP'];
			$attr['transaction_host_id']=$data['hosting_client_id'];
			$attr['transaction_remote_ip']=$ip;
			$attr['transaction_type']=$data['contentType'];

			$success=0;
			$errorMessage=array();
			$transaction=new Transactions;
			$transaction['attributes']=$attr;
			$transaction->transaction_amount=0;
			$transaction->transaction_id=functions::new_id();
			if ($res_res->catalog===0) {
				$transaction->transaction_result=0;
				$transaction->transaction_explanation="Catalog Created";
				$success+=1;
			}
			else
			{
				$errorMessage[]="Content could not added to the Catalog Database";
				$transaction->transaction_result=1;
				$transaction->transaction_explanation="Catalog Could NOT Created";
			}
			$transaction->save();
			unset($transaction);
			
			$transaction=new Transactions;
			$transaction['attributes']=$attr;
			$transaction->transaction_amount=0;
			$transaction->transaction_id=functions::new_id();
			if ($res_res->shell_output[0]=='100') {
				$transaction->transaction_result=0;
				$transaction->transaction_explanation="File Created";
				$success+=2;
			}
			else
			{
				$errorMessage[]="python bin/client.py -> AddToCatalog could not work properly. File Could NOT Created. Shell_output must return 100. Now shell_output:".$res_res->shell_output[0]." output:".$res_res->shell_output;
				$transaction->transaction_result=$res_res->cc;
				$transaction->transaction_explanation="File Could NOT Created";
			}
			$transaction->save();
			unset($transaction);

			

			$transaction=new Transactions;
			$transaction['attributes']=$attr;
			$transaction->transaction_amount=0;
			$transaction->transaction_id=functions::new_id();
			if ($res_res->shell_signal===0) {
				$transaction->transaction_result=0;
				$transaction->transaction_explanation="File Uploaded to Cloud";
				$success+=4;
			}
			else
			{
				$errorMessage[]="python bin/client.py -> AddToCatalog could not work properly. File Could NOT Uploaded to Cloud. Shell_signal must return 100. Now shell_signal:".$res_res->shell_signal;
				$transaction->transaction_result=$res_res->shell_signal;
				$transaction->transaction_explanation="File Could NOT Uploaded to Cloud";
			}
			$transaction->save();
			unset($transaction);

			if ($success==7) {
				$transaction=new Transactions;
				$transaction['attributes']=$attr;
				$transaction->transaction_id=functions::new_id();
				$transaction->transaction_result=0;
				$transaction->transaction_explanation="File Published";
				$transaction->transaction_amount=1;
				$transaction->save();



				$deleteFromQueue=PublishQueue::model()->findByPk($bookId);
				$deleteFromQueue->delete();
				functions::delTree($ebook->tempdirParent);




				$mail=Yii::app()->Smtpmail;
		        $mail->SetFrom(Yii::app()->params['noreplyEmail'], "OKUTUS");
		        $mail->Subject= $data['contentTitle']." kitabınız yayınlandı.";


				$users=UserBook::model()->findAll('book_id=:book_id',array('book_id'=>$bookId));

				foreach ($users as $key => $user) {
					$userInfo=User::model()->findByPk($user->user_id);
		        	$mail->AddAddress($userInfo->email, "");
				}


				$message=$data['contentTitle']." yayınlandı. reader.okutus.com adresinden kitabınızı inceleyebilirsiniz. Reader'da yayınladığınız kitapları görmek için üye değilseniz kayıt olarak giriş yapabilirsiniz.";
		        $mail->MsgHTML($message);
		        $mail->Send();







			}
			else
			{
				$this->errorQueue($bookId, $errorMessage);
			}

		}

		return $Return;

	}

	public function actionSendFileToCatalog($bookId=null,$id=null){

		if($bookId==null){
			$bookId=$id;
		}
		

		$response=false;

		if($return=$this->SendFileToQueue($bookId) ){
			if ($return=="budgetError") {
				$response="budgetError";
			}
			else
			{
				$response['sendFileInfo']=$return; 
				$response['sendFile']=true;		
			}
		}else{
			$response['sendFile']=false;
		}	
		

		return $this->response($response);
	}


	public function actionExportTimeStamp($bookId=null,$id=null){
		if($bookId==null){
			$bookId=$id;
		}
		$book=Book::model()->findByPk($bookId);
		$ebook=new epub3($book);
		$stamp=new TimeStamp();
		if(file_exists($ebook->ebookFile)){
			$exportedPath=$ebook->getEbookFile();
			$date=new DateTime();
			$timestamp=$date->getTimestamp();
			$outputPath=Yii::app()->params['timestamps'].$bookId."_".$timestamp;
			$oppub=$outputPath.".epub";
			$opzd=$outputPath.".zd";

			copy($exportedPath,$oppub);
			$response=$stamp->doStamp($oppub,$opzd);
			print_r($response);

		}
		die();	

	}

	public function actionExportBook($bookId=null,$id=null){
		if($bookId==null){
			$bookId=$id;
		}
		
		$book=Book::model()->findByPk($bookId);
		$ebook=new epub3($book);
		//if ($ebook) readfile($ebook->download() );
		
		//echo $ebook->getEbookFile();
		//die();
		//echo $ebook->getNiceName('pdf');
		

		if($ebook->download())
		{
			$msg="EDITOR_ACTIONS:EXPORT_BOOK:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('bookId'=>$bookId)));
			Yii::log($msg,'info');
		}
	}

	public function actionExportPdfBook($bookId=null){
		$book=Book::model()->findByPk($bookId);
		$ebook=new epub3($book);
		//echo $ebook->getEbookFile();
		//die();
		//echo $ebook->getNiceName('pdf');
		//die();
		$converter=new EpubConverter($ebook->getEbookFile(), $ebook->getNiceName('pdf'),5);
		$converter->extract();
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=".$ebook->getSanitizedFilename());
		header("Pragma: no-cache");
		readfile($ebook->getNiceName('pdf'));
		$msg="EDITOR_ACTIONS:EXPORT_PDF_BOOK:0:". json_encode(array(array('user'=>Yii::app()->user->id),array('bookId'=>$bookId)));
		Yii::log($msg,'info');
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
    public function getActionParams()
        {
                return  array_merge($_POST, $_GET);
        }

	/*public function runAction($id, $params=array()){

    	$params = array_merge($_POST, $params);
		print_r($this->filters);die;
    	parent::runAction($id, $params);
	}
	*/
}

 function sortify($a,$b){
	if( levenshtein( substr( $a[search]->similar_result, 0, 250) ,$a[search]->searchTerm ) > 
		levenshtein( substr( $b[search]->similar_result, 0 , 250) , $b[search]->searchTerm ) ){
		return 1;
	}
	else return -1;
}

