<?php

class ManagementController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','organisations'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$this->render('index');

	}
	public function actionOrganisations(){
		$page =(int) (isset($_GET['page']) ? $_GET['page'] : 1);  // define the variable to “LIMIT” the query
        

        $query1 = Yii::app()->db->createCommand() //this query contains all the data
        ->select(array('*'))
        ->from(array('organisations'))
        ->order('organisation_id')
        ->limit(Yii::app()->params['listPerPage'], ($page-1)*Yii::app()->params['listPerPage'] ) // the trick is here!
        ->queryAll();
        
        $item_count = Yii::app()->db->createCommand() // this query get the total number of items,
        ->select('count(*) as count')
        ->from(array('organisations'))
        ->queryAll(); // do not LIMIT it, this must count all items!

// the pagination itself
        $pages = new CPagination($item_count[0]['count']);
        $pages->setPageSize(Yii::app()->params['listPerPage']);
        

// render
        $this->render('organisations',array(
            'query1'=>$query1,
            'item_count'=>(int)$item_count[0]['count'],
            'page_size'=>Yii::app()->params['listPerPage'],
            'pages'=>$pages,
                ));
		

	}

}