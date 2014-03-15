<section>
	<div class="row">
							<div class="col-md-10">
								<!-- BOX -->
								<div class="box border red" id="bookCreateWizard">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i><?php _e('Eser Oluşturma '); ?> - <span class="stepHeader"><?php _e('Aşama'); ?> 1 / 3</h4>
									</div>
									<div class="box-body form">
										<!-- <form id="wizForm" action="#" class="form-horizontal" > -->
									<?php 
										$form=$this->beginWidget('CActiveForm', array(
											'id'=>'formWizard',
											'enableAjaxValidation'=>false,
											'htmlOptions'=>array(
										                     //   'onsubmit'=>"return false;",/* Disable normal form submit */
										                       //'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
										                     ),
										)); 
										?>
										<div class="wizard-form">
										   <div class="wizard-content">
											  <ul class="nav nav-pills nav-justified steps">
												 <li>
													<a href="#book_type" data-toggle="tab" class="wiz-step">
													<span class="step-number">1</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Eser Türü'); ?> </span>   
													</a>
												 </li>
												 <li>
													<a href="#book_information" data-toggle="tab" class="wiz-step">
													<span class="step-number">2</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Eser Bilgileri'); ?> </span>   
													</a> 
												 </li>
												 <li>
													<a href="#book_res" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Çözünürlük'); ?> </span>   
													</a> 
												 </li>
												 <li>
													<a href="#book_templates" data-toggle="tab" class="wiz-step">
													<span class="step-number">4</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Şablonlar'); ?> </span>   
													</a> 
												 </li>
											  </ul>
											  <div id="bar" class="progress progress-striped progress-sm active" role="progressbar">
												 <div class="progress-bar progress-bar-warning"></div>
											  </div>
											  <div class="tab-content">
												 <div class="alert alert-danger display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													Your form has errors. Please correct them to proceed.
												 </div>
												 <div class="alert alert-success display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													Your form validation is successful!
												 </div>
												<div class="tab-pane active" id="book_type">
													<div class="form-group">
														<label for="radio" class="control-label col-md-3"><?php _e('Eser Türü'); ?></label>
														<div class="col-md-4">
														<input id="ytsize" type="hidden" value="" name="book_type">
															<span id="book_type">
																<div class="" id="uniform-book_type_0">
																	<span class="checked">
																		<input class="uniform" id="book_type_0" value="epub" checked="checked" type="radio" name="book_type">
																	</span>
																<label for="book_type_0">Epub</label><br>
																</div>
																<div class="" id="uniform-book_type_1">
																	<span class="">
																		<input class="uniform" id="book_type_1" value="pdf" type="radio" name="book_type">
																	</span>
																<label for="book_type_1">Pdf</label><br>
																</div>
															</span>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book_information">
												<div class="form-group">
														<label for="radio" class="control-label col-md-3"><?php _e('Çalışma Grubu'); ?></label>
														<div class="col-md-4">
														<input id="ytsize" type="hidden" value="" name="workspaces">
															<span id="workspaces">
																<?php 
																$i=0;
																foreach ($workspaces as $workspace_id => $workspace_name): ?>
																<div class="" id="uniform-workspaces_<?php echo $i; ?>">
																	<span class="checked">
																		<input class="uniform" id="workspaces_<?php echo $i; ?>" value="<?php echo $workspace_id; ?>" checked="checked" type="radio" name="workspaces">
																	</span>
																<label for="workspaces_<?php echo $i; ?>"><?php echo $workspace_name; ?></label><br>
																</div>
																<?php 
																$i++;
																endforeach; ?>
															</span>
														</div>
													</div>
												<div class="form-group">
														<label  class="col-md-3 control-label">
														<?php _e("Eser Adı"); ?>
														</label>
														<div class="col-md-4">
															<input class="form-control" name="book_name" type="text">
														</div>
													</div>
													<div class="form-group">
														<label  class="col-md-3 control-label">
														<?php _e("Yazar"); ?>
														</label>
														<div class="col-md-4">
															<input class="form-control" name="book_author" type="text">
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book_res">
													<div class="form-group">
														<label for="radio" class="control-label col-md-3"><?php _e('Boyutlar'); ?></label>
														<div class="col-md-4">
														<input id="ytsize" type="hidden" value="" name="book_size">
															<span id="book_size">
																<div class="" id="uniform-book_size_0">
																	<span class="">
																		<input class="uniform" id="book_size_1" value="800x600" type="radio" name="book_size">
																	</span>
																<label for="book_size_1">800 X 600</label><br>
																</div>
																<div class="" id="uniform-book_size_1">
																	<span class="checked">
																		<input class="uniform" id="book_size_0" value="1024x768" checked="checked" type="radio" name="book_size">
																	</span>
																<label for="book_size_0">1024 X 768</label><br>
																</div>
																<div class="" id="uniform-book_size_2">
																	<span class="">
																		<input class="uniform" id="book_size_2" value="1280x960" type="radio" name="book_size">
																	</span>
																<label for="book_size_2">1280 X 960</label>
																</div>
															</span>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book_templates">
													<div class="form-group">
														<label for="radio" class="control-label col-md-3"><?php _e('Şablonlar'); ?></label>
														<div class="col-md-4">
														<input id="ytsize" type="hidden" value="" name="templates">
															<span id="templates">
																<?php 
																$j=0;
																foreach ($main_templates as $key => $template): ?>
																<div class="" id="uniform-templates_<?php echo $j; ?>">
																	<span class="checked">
																		<input class="uniform" id="templates_<?php echo $j; ?>" value="<?php echo $template->book_id; ?>" checked="checked" type="radio" name="templates">
																	</span>
																<label for="templates_<?php echo $j; ?>"><img src="<?php echo $template->getData('thumbnail'); ?>" width="150px" height="150px"><?php echo $template->title; ?></label><br>
																</div>
																<?php 
																$j++;
																endforeach; 
																foreach ($user_templates as $key => $workspaces): 
																	foreach ($workspaces as $key => $template):
																	?>
																		<div class="" id="uniform-templates_<?php echo $j; ?>">
																			<span class="checked">
																				<input class="uniform" id="templates_<?php echo $j; ?>" value="<?php echo $template->book_id; ?>" checked="checked" type="radio" name="templates">
																			</span>
																		<label for="templates_<?php echo $j; ?>"><img src="<?php echo $template->getData('thumbnail'); ?>" width="150px" height="150px"><?php echo $template->title; ?></label><br>
																		</div>
																		<?php 
																		$j++;
																	endforeach;
																endforeach; ?>
															</span>
														</div>
													</div>
												</div>
										   </div>
										   <div class="wizard-buttons">
											  <div class="row">
												 <div class="col-md-12">
													<div class="col-md-offset-3 col-md-9">
													   <a href="javascript:;" class="btn btn-default prevBtn">
														<i class="fa fa-arrow-circle-left"></i> <?php _e('Geri'); ?> 
													   </a>
													   <a href="javascript:;" class="btn btn-primary nextBtn">
														<?php _e('Devam'); ?> <i class="fa fa-arrow-circle-right"></i>
													   </a>
													   <a href="javascript:;" class="btn btn-success submitBtn" id="templateCreate">
														<?php _e('Oluştur'); ?> <i class="fa fa-arrow-circle-right"></i>
													   </a>                            
													</div>
												 </div>
											  </div>
										   </div>
										</div>
									 <?php $this->endWidget(); ?>
									 <!-- </form> -->
									</div>
								</div>
								<!-- /BOX -->
							</div>
						</div>
</section>
<script>
		jQuery(document).ready(function() {		
			$('#templateCreate').hide();
			App.setPage("wizards_validations");  //Set current page
			App.init(); //Initialise plugins and elements
			BookCreateWizard.init();
		});
	</script>


<script type="text/javascript">
 	$('form').addClass('form-horizontal');
</script>
<script type="text/javascript">
	$('span div span').on('click','[name="book_size"]',function(){
		var sizes=$(this).val();
		console.log(sizes);
		$.getJSON( "/book/getTemplates/"+sizes, function( data ) {
		console.log(data);
		//   var items = [];
		//   $.each( data, function( key, val ) {
		//     items.push( "<li id='" + key + "'>" + val + "</li>" );
		//   });
		 
		//   $( "<ul/>", {
		//     "class": "my-new-list",
		//     html: items.join( "" )
		//   }).appendTo( "body" );
		 });
	});
</script>
<script type="text/javascript">
	var BookCreateWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            var wizform = $('#formWizard');
			var alert_success = $('.alert-success', wizform);
            var alert_error = $('.alert-danger', wizform);
            
			/*-----------------------------------------------------------------------------------*/
			/*	Validate the form elements
			/*-----------------------------------------------------------------------------------*/
            wizform.validate({
                doNotHideMessage: true,
				errorClass: 'error-span',
                errorElement: 'span',
                rules: {
                    contentTitle:{
                        required: true
                    },
                    contentType:{
                        required: true
                    },
                    contentExplanation:{
                        required: true
                    },
                    contentIsForSale:{
                        required: true
                    },
                    contentCurrency:{
                        required: true
                    },
                    contentPrice:{
                        number: true,
                       // required: true
                    },
                    contentReaderGroup:{
                        required: true
                    },
                    host:{
                        required: true
                    },

                    

                    card_cvc: {
						required: true,
                        digits: true,
                        minlength: 3,
                        maxlength: 3
                    },
                    
                },

                invalidHandler: function (event, validator) { 
                    alert_success.hide();
                    alert_error.show();
                },

                highlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); 
                },

                unhighlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-error'); 
                },

                success: function (label) {
                    if (label.attr("for") == "gender") { 
                        label.closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); 
                    } else { 
                        label.addClass('valid') 
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); 
                    }
                }
            });
            
            var data;
            $(".datepicker-fullscreen").pickadate({format:'dd/mm/yyyy'});
            $(".siraliDisplay").hide();
            var formDisplay = function(){
            };

            /*-----------------------------------------------------------------------------------*/
            /*  Initialize Bootstrap Wizard
            /*-----------------------------------------------------------------------------------*/
            $('#bookCreateWizard').bootstrapWizard({
                'nextSelector': '.nextBtn',
                'previousSelector': '.prevBtn',
                onNext: function (tab, navigation, index) {
                    alert_success.hide();
                    alert_error.hide();
                    if (wizform.valid() == false) {
                        return false;
                    }

                    var total = navigation.find('li').length;
                    var current = index + 1;
                    $('.stepHeader', $('#bookCreateWizard')).text('Step ' + (index + 1) + ' of ' + total);
                    jQuery('li', $('#bookCreateWizard')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }
                    if (current == 1) {
                        $('#bookCreateWizard').find('.prevBtn').hide();
                    } else {
                        $('#bookCreateWizard').find('.prevBtn').show();
                    }
                    if (current >= total) {
                        $('#bookCreateWizard').find('.nextBtn').hide();
                        $('#bookCreateWizard').find('.submitBtn').show();
                        formDisplay();
                    } else {
                        $('#bookCreateWizard').find('.nextBtn').show();
                        $('#bookCreateWizard').find('.submitBtn').hide();
                    }
                },
                onPrevious: function (tab, navigation, index) {
                    alert_success.hide();
                    alert_error.hide();
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    $('.stepHeader', $('#bookCreateWizard')).text('Step ' + (index + 1) + ' of ' + total);
                    jQuery('li', $('#bookCreateWizard')).removeClass("done");
                    var li_list = navigation.find('li');
                    for (var i = 0; i < index; i++) {
                        jQuery(li_list[i]).addClass("done");
                    }
                    if (current == 1) {
                        $('#bookCreateWizard').find('.prevBtn').hide();
                    } else {
                        $('#bookCreateWizard').find('.prevBtn').show();
                    }
                    if (current >= total) {
                        $('#bookCreateWizard').find('.nextBtn').hide();
                        $('#bookCreateWizard').find('.submitBtn').show();
                    } else {
                        $('#bookCreateWizard').find('.nextBtn').show();
                        $('#bookCreateWizard').find('.submitBtn').hide();
                    }
                },
				onTabClick: function (tab, navigation, index) {
                    bootbox.alert('On Tab click is disabled');
                    return false;
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#bookCreateWizard').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });


            $('#bookCreateWizard').find('.prevBtn').hide();
            $('#templateCreate').click(function () {
                msg = Messenger().post({
                    message:"Şablon oluşturuluyor. Lütfen Bekleyiniz",
                    type:"info",
                    showCloseButton: true,
                    hideAfter: 100
                });
                wizform.ajaxSubmit({
                    url:'/book/createTemplate/<?php echo $workspace_id; ?>',
                    success:function(response) {
                            msg.update({
                                message: 'Şablon oluşturma başarılı.',
                                type: 'success',
                                hideAfter: 5
                            })
                        // bootbox.alert("Eser yayÄ±nlama baÅŸarÄ±lÄ±.",function(){
                             window.location.href = '/organisations/templates/<?php echo $workspace_id; ?>';
                        // });
                    },
                    error:function() { 
                        msg.update({
                            message: 'Beklenmedik bir hata oluştu. Lütfen tekrar deneyin.',
                            type: 'error',
                            hideAfter: 5
                        })
                        // bootbox.alert("Beklenmedik bir hata oluÅŸtu. LÃ¼tfen tekrar deneyin.");
                    },

                });
            }).hide();
            
        }
    };
}();
</script>