<?php

class EditorActionsController extends Controller
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
 
	public function error($domain='EditorActions',$explanation='Error', $arguments=null,$debug_vars=null ){
		$error=new error($domain,$explanation, $arguments,$debug_vars);
		$this->errors[]=$error; 
		return $error;
	}

	public function actionPublishBook($bookId=null,$id=null){
		if($bookId==null){
			$bookId=$id;
		}
		$this->layout="//layouts/column2";

		$book=Book::model()->findByPk($bookId);
		//$workspace=Workspaces::model()->findByPk($book->workspace_id);
		$organisationWorkspace=OrganisationWorkspaces::model()->findAll(array(
		    'condition'=>'workspace_id=:workspace_id',
		    'params'=>array(':workspace_id'=>$book->workspace_id),
		));

		$organisation=Organisations::model()->findByPk($organisationWorkspace[0]->organisation_id);

		$hosts=OrganisationHostings::model()->findAll(array(
		    'condition'=>'organisation_id=:organisation_id',
		    'params'=>array(':organisation_id'=>$organisation->organisation_id),
		));

		$categories=BookCategories::model()->findAll('organisation_id=:organisation_id',array('organisation_id'=>$organisation->organisation_id));

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

		$this->render('publishBook',array('model'=>$model,'hosts'=>$hosts,'categories'=>$categories,'bookId'=>$bookId));
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
		return $this->response($response);
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
		$response=false;

		if($return=$this->addComponent($pageId,$attributes)){
				$response['component']=$return; 
		}
		return $this->response($response);
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
		$response=false;

		if($return=$this->updateComponent($componentId,$jsonProperties) ){
				$response['component']=$return; 
		}

		return $this->response($response);

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

	public function SendFileToCatalog($bookId){

		ob_start();
		$book=Book::model()->findByPk($bookId);
		$bookData=json_decode($book->data,true);

		$ebook=new epub3($book);


		if (!file_exists($ebook->ebookFile)) {
			$this->error('SendFileToCatalog','File does not exists!');
			$msg="EDITOR_ACTIONS:SendFileToCatalog:0:Could Not Found the created Ebook File". json_encode(array(array('user'=>Yii::app()->user->id),array('bookId'=>$bookId)));
			Yii::log($msg,'error');
			return;
		}
		

		if (!empty($_POST)) {
			$budget=$this->getOrganisationBudget($_POST['PublishBookForm']['organisationId']);
			foreach ($budget as $key => $item) {
				if ($item['transaction_type']==$_POST['contentType']) {
					if ($item['amount']<=0) {
						return "budgetError";
					}
				}
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
			$data['contentReaderGroup']=$_POST['contentReaderGroup'];
			//$data['contentCover']=$bookData['cover'];
			$data['contentThumbnail']=$bookData['thumbnail'];
			
			//book detail
			$data['abstract']=$_POST['abstract'];
			$data['language']=$_POST['language'];
			$data['subject']=$_POST['subject'];
			$data['edition']=$_POST['edition'];
			$data['author']=$_POST['author'];
			$data['translator']=$_POST['translator'];
			$data['issn']=$_POST['issn'];

			if (isset($_POST['host'])) {
				$hosts=$_POST['host'];
				foreach ($hosts as $key => $hostId) {
					$host=OrganisationHostings::model()->findByPk($hostId);
					$data['hosts'][$hostId]['host']=$host->hosting_client_IP;
					$data['hosts'][$hostId]['port']=$host->hosting_client_port;
					$data['hosts'][$hostId]['key1']=$host->hosting_client_key1;
					$data['hosts'][$hostId]['key2']=$host->hosting_client_key2;
					$data['hosts'][$hostId]['id']=$host->hosting_client_id;
					
					$hosting_client_IP=$host->hosting_client_IP;
					$hosting_client_id=$host->hosting_client_id;
				}

			}
			else
			{
				$host=OrganisationHostings::model()->findByPk('GIWwMdmQXL');
				$data['hosts']['GIWwMdmQXL']['host']=$host->hosting_client_IP;
				$data['hosts']['GIWwMdmQXL']['port']=$host->hosting_client_port;
				$data['hosts']['GIWwMdmQXL']['key1']=$host->hosting_client_key1;
				$data['hosts']['GIWwMdmQXL']['key2']=$host->hosting_client_key2;
				$data['hosts']['GIWwMdmQXL']['id']=$host->hosting_client_id;

				$hosting_client_IP=$host->hosting_client_IP;
				$hosting_client_id=$host->hosting_client_id;
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
				$category=BookCategories::model()->findByPk('1122');
				$data['categories'][$categoryId]['category_id']=$category->category_id;
				$data['categories'][$categoryId]['category_name']=$category->category_name;
			}
			
		}

		$data['contentId']=$bookId;
		$data['contentFile']='@'.$ebook->ebookFile;
		$data['checksum']=md5_file($ebook->ebookFile);
		$data['contentTrustSecret']=sha1($data['checksum']."ONLYUPLOAD".$bookId."31.210.53.80");

		

		$data['hosts']=json_encode($data['hosts']);
		$data['categories']=json_encode($data['categories']);
		$data['siraliCategory']=json_encode($data['siraliCategory']);
		$localFile = $ebook->ebookFile; // This is the entire file that was uploaded to a temp location.
		$fp = fopen($localFile, 'r');

		//Connecting to website.

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, Yii::app()->params['catalogExportURL'] );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		$Return['response']=json_decode(curl_exec($ch));

		if (curl_errno($ch)){  
			$this->error('SendFileToCatalog','CURL_ERROR:'.curl_error($ch));
		    $msg="EDITOR_ACTIONS:SendFileToCatalog:0:CURL_ERROR:".curl_error($ch). json_encode(array(array('user'=>Yii::app()->user->id),array('bookId'=>$bookId)));
			Yii::log($msg,'error');
			return;
		}

		$msg = 'File uploaded successfully.';
		curl_close ($ch);
		$Return['msg'] = $msg;
		ob_end_clean();


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
		$attr['transaction_host_ip']=$hosting_client_IP;
		$attr['transaction_host_id']=$hosting_client_id;
		$attr['transaction_remote_ip']=$ip;
		$attr['transaction_type']=$data['contentType'];

		$success=0;

		$transaction=new Transactions;
		$transaction['attributes']=$attr;
		$transaction->transaction_amount=0;
		$transaction->transaction_id=functions::new_id();
		if ($res_res->catalog===0) {
			$transaction->transaction_result=0;
			$transaction->transaction_explanation="Catalog Created";
			$success++;
		}
		else
		{
			$transaction->transaction_result=1;
			$transaction->transaction_explanation="Catalog Could NOT Created";
		}
		$transaction->save();
		unset($transaction);
		
		$transaction=new Transactions;
		$transaction['attributes']=$attr;
		$transaction->transaction_amount=0;
		$transaction->transaction_id=functions::new_id();
		if ($res_res->cc) {
			$transaction->transaction_result=0;
			$transaction->transaction_explanation="File Created";
			$success++;
		}
		else
		{
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
			$success++;
		}
		else
		{
			$transaction->transaction_result=$res_res->shell_signal;
			$transaction->transaction_explanation="File Could NOT Uploaded to Cloud";
		}
		$transaction->save();
		unset($transaction);

		if ($success==3) {
			$transaction=new Transactions;
			$transaction['attributes']=$attr;
			$transaction->transaction_id=functions::new_id();
			$transaction->transaction_result=0;
			$transaction->transaction_explanation="File Published";
			$transaction->transaction_amount=1;
			$transaction->save();
		}


		return $Return;

	}

	public function actionSendFileToCatalog($bookId=null,$id=null){

		if($bookId==null){
			$bookId=$id;
		}
		

		$response=false;

		if($return=$this->SendFileToCatalog($bookId) ){
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

