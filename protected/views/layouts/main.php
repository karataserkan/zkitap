<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="tr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
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
	case 'organisations':
	case 'user'
		?>

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/cloud-admin.css" >
	<link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/themes/night.css" >
	<link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/responsive.css" >
	
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	
	<!-- FONTS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/webfonts/open_sans/open_sans.css" />
		
	<!-- DATE RANGE PICKER -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<!-- UNIFORM -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/uniform/css/uniform.default.min.css" />
	<!-- ANIMATE -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/animatecss/animate.min.css" />

	
		
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/bootstrap-dist/js/bootstrap.min.js"></script>
	<!-- BLOCK UI -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
	<!-- ISOTOPE -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/isotope/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/isotope/imagesloaded.pkgd.min.js"></script>
	<!-- COLORBOX -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/colorbox/jquery.colorbox.min.js"></script>
		
	<!-- DATE RANGE PICKER -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-daterangepicker/moment.min.js"></script>
	
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
	<!-- SLIMSCROLL -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/script.js"></script>

	<!-- UNIFORM -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/uniform/jquery.uniform.min.js"></script>
	<!-- BACKSTRETCH -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/backstretch/jquery.backstretch.min.js"></script>

	
	<!-- /JAVASCRIPTS -->


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
		<link href="/css/nprogress.css" rel="stylesheet">

		<!-- JS Libraries -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-1.9.1.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-ui-1.10.3.custom.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/Chart.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.autogrow-min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.dropdown.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-ui-draggable-alsoDrag.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.ui.rotatable.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/nprogress.js"></script>
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
