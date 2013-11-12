<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link href="<?php echo Yii::app()->request->baseUrl; ?>css/editor_blue/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<script src="<?php echo Yii::app()->request->baseUrl; ?>js/jquery-1.9.1.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>js/jquery-ui-1.10.3.custom.js"></script>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>js/Tlingit.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>js/Tsimshian.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>js/Nisga.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/linden-editor-icons.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container editor_blue" id="page" >
	
	

	<div id="header">
		<div id='login_area' style='float:right;'>
			<?php
			if(Yii::app()->user->isGuest){
				echo CHtml::link('Login',array('site/login'));
			}else{
				echo CHtml::link('Logout ('.Yii::app()->user->name.')',array('site/logout'));

			}
			?>
		</div>
		
		<div id="logo" style='float:left'>
			<a href='<?php $this->createUrl('/site/index');  ?>'/> <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/logo.png" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" /></a>
		</div>
		




	<?php echo $content; ?>




</div><!-- page -->

</body>
</html>
