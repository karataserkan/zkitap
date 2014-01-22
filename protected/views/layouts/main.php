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

	<!-- EASY PIE CHART -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery-easing/jquery.easing.min.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/easypiechart/jquery.easypiechart.min.js"></script>
		<!-- FLOT CHARTS -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/flot/jquery.flot.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/flot/jquery.flot.time.min.js"></script>
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/flot/jquery.flot.selection.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/flot/jquery.flot.resize.min.js"></script>
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/flot/jquery.flot.pie.min.js"></script>
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/flot/jquery.flot.stack.min.js"></script>
		<!-- GRITTER -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/gritter/js/jquery.gritter.min.js"></script>

</head>

<body class="editor_blue">

