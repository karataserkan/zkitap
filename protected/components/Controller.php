<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	public function init()
	{

		$language=Yii::app()->request->getQuery('language');
		$language_cookie=Yii::app()->request->cookies['language'];
		$cookie_time=time() + (10 * 365 * 24 * 60 * 60);
		if(!isset($language_cookie))
			{
				
				$cookie_var=new CHttpCookie('language', 'tr_TR');
				$cookie_var->expire=$cookie_time;
				Yii::app()->request->cookies['language'] = $cookie_var;
				Yii::app()->language='tr_TR';
			}
		else if(isset($language))
			{
				$cookie_var=new CHttpCookie('language', $language);
				$cookie_var->expire=$cookie_time;
				Yii::app()->request->cookies['language'] = $cookie_var;
				Yii::app()->language=$language;
			}
		else if(isset($language_cookie))
			{
				Yii::app()->language=(string)$language_cookie;
			}
	}
	//public function getActionParams() { return array_merge($_GET, $_POST); }

}
