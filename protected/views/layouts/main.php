<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="tr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="tr" />
	<link rel="icon" type="image/png" href="/css/favicon.png" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<!-- default styles and js -->



<?php 
$controller = Yii::app()->getController()->getId();
$action=Yii::app()->controller->action->id;		
?>
<?php 
switch ($controller) {
	case 'site':
		?>
		<!-- default styles and js -->



		<!-- Style Sheets Reset -->
		<link rel="stylesheet" type="text/css" href="/css/screen.css" media="screen, projection">
		<link rel="stylesheet" type="text/css" href="/css/print.css" media="print">
		<link href="/css/editor_blue/jquery-ui-1.10.3.custom.css" rel="stylesheet">
		<link href="/css/editor_blue/jquery.ui.rotatable.css" rel="stylesheet">

		<!-- Style Sheets -->
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<link rel="stylesheet" type="text/css" href="/css/linden-editor-icons.css">
		<link rel="stylesheet" type="text/css" href="/css/form.css">

		<!-- JS Libraries -->
		<script src="/js/lib/jquery-1.9.1.js"></script>
		<script src="/js/lib/jquery-ui-1.10.3.custom.js"></script>
		<script src="/js/lib/Chart.js"></script>
		<script src="/js/lib/jquery.autogrow-min.js"></script>
		<script src="/js/lib/jquery.dropdown.js"></script>
		<script src="/js/lib/jquery-ui-draggable-alsoDrag.js"></script>
		<script src="/js/lib/jquery.ui.rotatable.js"></script>
		<script src="http://can.dev.lindneo.com:1881/socket.io/socket.io.js"></script>

		<!-- JS Modules -->
		<script src="/js/app/lindneo.js"></script>	
		<script src="/js/app/modules/dataservice.js"></script>	
		<script src="/js/app/modules/tlingit.js"></script>
		<script src="/js/app/modules/nisga.js"></script>
		<script src="/js/app/modules/tsimshian.js"></script>
		<script src="/js/app/modules/toolbox.js"></script>

		

		<!-- Page JS Codes -->
		<script src="/js/app/other/page-drag-drop.js"></script>
		<script src="/js/app/other/page-load.js"></script>
			

		<?php
		break;
	default:
		?>
		<!-- Style Sheets Reset -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/editor_blue/jquery-ui-1.10.3.custom.css" rel="stylesheet">
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/editor_blue/jquery.ui.rotatable.css" rel="stylesheet">

		<!-- Style Sheets -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/linden-editor-icons.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

		<!-- JS Libraries -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-1.9.1.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-ui-1.10.3.custom.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/Chart.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.autogrow-min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.dropdown.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-ui-draggable-alsoDrag.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.ui.rotatable.js"></script>
		<script src="<?php echo Yii::app()->request->hostInfo; ?>:1881/socket.io/socket.io.js"></script>

		<!-- JS Modules -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/lindneo.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/modules/dataservice.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/modules/tlingit.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/modules/nisga.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/modules/tsimshian.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/modules/toolbox.js"></script>

		<!-- JS Components -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/text-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/image-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/gallery-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/video-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/sound-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/quiz-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/popup-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/shape-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/graph-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/link-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/sidebar-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/table-component.js"></script>	

		<!-- Page JS Codes -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/other/page-drag-drop.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/other/page-load.js"></script>
		<?php
		break;
}
?>
	

</head>

<body>

<div class="container editor_blue" id="page" >
	

	<div id="header">
		<div id='login_area' style='float:right;'>
			<?php
			if(Yii::app()->user->isGuest){
				echo CHtml::link('<a>' . __('Giriş yap')  .'</a>',array('site/login'));
			}else{
				 echo CHtml::link( __('Çıkış')  . '('.Yii::app()->user->name.')',array('site/logout'));

			}
			?>
		</div>
		
		<div id="logo" style='float:left'>
			<a href="<?php echo $this->createUrl('site/index');  ?>"/> <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/logo.png" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" /></a>
					
		</div>
		


	<?php echo $content; ?>


</div><!-- page -->

</body>
</html>
