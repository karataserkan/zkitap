<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php functions::_lang_code(); ?>" lang="<?php functions::_lang_code(); ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta name="language" content="<?php functions::_lang_code(); ?>" />
	
    <link rel="icon" href="/css/images/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/css/images/favicon.ico" type="image/x-icon">
    
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<!-- default styles and js -->



			<!-- CSS -->


		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/cloud-admin.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/brands/linden/linden.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/themes/default.css" >
		<link rel="stylesheet" type="text/css"  href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/responsive.css" >
		
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/select2/select2.min.css" rel="stylesheet">
		
		<!-- FONTS -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/webfonts/open_sans/open_sans.css" />
			
		<!-- DATE RANGE PICKER -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
		<!-- UNIFORM -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/uniform/css/uniform.default.min.css" />
		<!-- ANIMATE -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/css/animatecss/animate.min.css" />


		<!-- Expand Search box -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ExpandingSearchBar/css/component.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-wizard/wizard.css" />

		<!-- HUBSPOT MESSENGER -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/hubspot-messenger/css/messenger.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/hubspot-messenger/css/messenger-theme-future.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/hubspot-messenger/css/messenger-spinner.min.css" />
		<!-- DATE PICKER -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/datepicker/themes/default.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/datepicker/themes/default.date.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/datepicker/themes/default.time.min.css" />

			
		<!-- JAVASCRIPTS -->
		<!-- Placed at the end of the document so the pages load faster -->
		<!-- JQUERY -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery/jquery-2.0.3.min.js"></script>
		<!-- JQUERY UI-->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/select2/select2.min.js"></script>
		<!-- BOOTSTRAP -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/bootstrap-dist/js/bootstrap.min.js"></script>
		<!-- BLOCK UI -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jQuery-BlockUI/jquery.blockUI.min.js"></script>
		<!-- ISOTOPE -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/isotope/jquery.isotope.min.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/isotope/imagesloaded.pkgd.min.js"></script>
		<!-- COLORBOX -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/colorbox/jquery.colorbox.min.js"></script>
        <!-- Expand Search box -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ExpandingSearchBar/js/classie.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ExpandingSearchBar/js/modernizr.custom.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/ExpandingSearchBar/js/uisearch.js"></script> 
			
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
		<!-- TYPEHEAD -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/typeahead/typeahead.min.js"></script>
		<!-- AUTOSIZE -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/autosize/jquery.autosize.min.js"></script>
		<!-- COUNTABLE -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/countable/jquery.simplyCountable.min.js"></script>
		<!-- INPUT MASK -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
		<!-- FILE UPLOAD -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<!-- SELECT2 -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/select2/select2.min.js"></script>
		<!-- UNIFORM -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/uniform/jquery.uniform.min.js"></script>
		
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.form.min.js"></script>

			<!-- WIZARD -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
		<!-- WIZARD -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery-validate/jquery.validate.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/jquery-validate/additional-methods.min.js"></script>
		<!-- BOOTBOX -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootbox/bootbox.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/bootstrap-wizard/form-wizard.js"></script>
		<!-- HUBSPOT MESSENGER -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/hubspot-messenger/js/messenger.min.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/hubspot-messenger/js/messenger-theme-flat.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/hubspot-messenger/js/messenger-theme-future.js"></script>
		<!-- DATE PICKER -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/datepicker/picker.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/datepicker/picker.date.js"></script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/datepicker/picker.time.js"></script>

  		<!-- Trip.js Tutorial-->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/trip.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/trip.css" />
		<script type="text/javascript">
		var trip,tripData;
		var options={
			    tripTheme : "white",
			    onTripStart : function() {
			      console.log("onTripStart");
			    },
			    onTripEnd : function() {
			      console.log("onTripEnd");
			    },
			    onTripStop : function() {
			      console.log("onTripStop");
			    },
			    onTripChange : function(index, tripBlock) {
			      console.log("onTripChange");
			    },
			    backToTopWhenEnded : true,
			    delay : 5000,
			    prevLabel: 'Geri',
			    nextLabel: 'İleri',
			    finishLabel: 'Bitir',
			    showNavigation: true,
			    showCloseBox:true
			    //overlayZindex:9999999999999999999
			  };

		var Key =
			{
			    BACKSPACE: 8,
			    TAB: 9,
			    ENTER: 13,
			    ESC: 27,
			    PAGEUP: 33,
			    PAGEDOWN: 34,
			    END: 35,
			    HOME: 36,
			    LEFT: 37,
			    UP: 38,
			    RIGHT: 39,
			    DOWN: 40,
			    HELP: 47,
			    H: 72,
			    K: 75,
			    N: 78,
			    R: 82,
			    NUMERIC_PLUS: 107,
			    F1: 112,
			    F2: 113,
			    F3: 114,
			    F4: 115,
			    F5: 116,
			    F6: 117,
			    F7: 118,
			    F8: 119,
			    F9: 120,
			    F10: 121,
			    F11: 122,
			    F12: 123,
			    PLUS: 187,
			    MINUS: 189,
			    V: 86
			}

			 function tripStart(){
				trip= new Trip(tripData, options);
			    trip.start();
			}
			$(document).ready(function(){
				

				$(document).bind('keypress', function(event) {
			      switch(event.keyCode) {
			      	
			        case Key.BACKSPACE:
			        case Key.HOME:
			         if (event.ctrlKey && event.shiftKey){
			         	console.log('Help is on the way!' + event.keyCode);
						tripStart();

			         }
			        break;
			      }
			    });
			    
			});
		</script>
		<!-- EASY PIE CHART -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/jquery-easing/jquery.easing.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/easypiechart/jquery.easypiechart.min.js"></script>
	<!-- FLOT CHARTS -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.time.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.selection.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.resize.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.pie.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.stack.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/dashboard/flot/jquery.flot.crosshair.min.js"></script>

		<script type="text/javascript">

		$(document).ready(function(){

			tripData=[<?php functions::event('tripData'); ?>];
			//tripStart();
		});
		</script>


		<?php if (Yii::app()->controller->action->id=="bookCreate"):?>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/ui/js/book_create.js"></script>
		<?php endif; ?>
</head>

<body class="editor_blue">

