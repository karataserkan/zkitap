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

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cloud-admin.css" > 
<!-- Style Sheets Reset -->
			
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/editor_blue/jquery.ui.rotatable.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery-collision.min.js"></script>
		<!-- Wrap TEXT -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.slickwrap.js"></script>
		<script src="<?php echo Yii::app()->request->hostInfo; ?>:1881/socket.io/socket.io.js"></script>
		<!-- BOOTSTRAP -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-dist/js/bootstrap.min.js"></script>
		<!-- Jquery Selection -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.selection.js"></script>
		<!-- HTML5 VİDEO -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/runtime.js"></script>
		<!-- MathJax -->
		<script type="text/x-mathjax-config">
	      MathJax.Hub.Config({
	        tex2jax: {
	          inlineMath: [["$","$"],["\\(","\\)"]]
	        }
	      });
	      MathJax.Hub.Register.StartupHook("HTML-CSS Jax Ready",function () {
			  var VARIANT = MathJax.OutputJax["HTML-CSS"].FONTDATA.VARIANT;
			  VARIANT["normal"].fonts.unshift("MathJax_Arial");
			  VARIANT["bold"].fonts.unshift("MathJax_Arial-bold");
			  VARIANT["italic"].fonts.unshift("MathJax_Arial-italic");
			  VARIANT["-tex-mathit"].fonts.unshift("MathJax_Arial-italic");
			});
			MathJax.Hub.Register.StartupHook("SVG Jax Ready",function () {
			  var VARIANT = MathJax.OutputJax.SVG.FONTDATA.VARIANT;
			  VARIANT["normal"].fonts.unshift("MathJax_SansSerif");
			  VARIANT["bold"].fonts.unshift("MathJax_SansSerif-bold");
			  VARIANT["italic"].fonts.unshift("MathJax_SansSerif-italic");
			  VARIANT["-tex-mathit"].fonts.unshift("MathJax_SansSerif-italic");
			});
	    </script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/facybox/facybox.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/facybox/facybox.css" media="screen" />
		<script type="text/javascript">
		$(document).ready(function() {

		$("a[rel*=facybox]").facybox({
	        // noAutoload: true
	      });
		$('#facybox').css('z-index','9999');
		});
		</script>
		<!-- ACE HTML
		<style type="text/css" media="screen">
		    #editor { 
		        position: absolute;
		        top: 0;
		        right: 0;
		        bottom: 0;
		        left: 0;
		    }
		</style>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ace/ace.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ace/theme/twilight.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ace/mode-javascript.js"></script> -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/cheef_ace/ace/ace.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/cheef_ace/ace/theme-twilight.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/cheef_ace/ace/mode-html.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/cheef_ace/jquery-ace.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/cheef_ace/css/editor.css" media="screen" />
		
		<!-- JS Slider -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jssor.core.js"></script>
	    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jssor.utils.js"></script>
	    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jssor.slider.js"></script>

	    <!-- İSCROLL-->
	    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/iscroll.js"></script>
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
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/html-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/wrap-component.js"></script>	
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/latex-component.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/slider-component.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/tag-component.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/plink-component.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/thumb-component.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/components/rtext-component.js"></script>	
		<!-- Page JS Codes -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/other/page-drag-drop.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app/other/page-load.js"></script>

</head>

<body class="editor_blue">


<?php echo $content; ?>
</body>
</html>