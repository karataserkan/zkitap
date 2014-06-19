<section>
	<div class="row">
							<div class="col-md-10">
								<!-- BOX -->
								<div class="box border red" id="formWizard">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i><?php _e('Şablon '); ?> - <span class="stepHeader"><?php _e('Aşama'); ?> 1 / 3</h4>
									</div>
									<div class="box-body form">
										<!-- <form id="wizForm" action="#" class="form-horizontal" > -->
									<?php 
										$form=$this->beginWidget('CActiveForm', array(
											'id'=>'wizForm',
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
													<a href="#template" data-toggle="tab" class="wiz-step">
													<span class="step-number">1</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Şablon Bilgileri'); ?> </span>   
													</a>
												 </li>
												 <li>
													<a href="#selectsize" data-toggle="tab" class="wiz-step">
													<span class="step-number">2</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Sayfa Boyutları'); ?> </span>   
													</a> 
												 </li>
												 <li>
													<a href="#save" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Oluştur'); ?> </span>   
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
												<div class="tab-pane active" id="template">
													<div class="form-group">
														<label  class="col-md-3 control-label">
														<?php _e("İsim"); ?>
														</label>
														<div class="col-md-4">
															<input class="form-control" name="isim" type="text">
														</div>
													</div>
													<div class="form-group">
														<label  class="col-md-3 control-label">
														<?php _e("Yazar"); ?>
														</label>
														<div class="col-md-4">
															<input class="form-control" name="yazar" type="text">
														</div>
													</div>
												</div>
												<div class="tab-pane" id="selectsize">
													<div class="form-group">
														<label for="radio" class="control-label col-md-3"><?php _e('Boyutlar'); ?></label>
														<div class="col-md-4">
														<input id="ytsize" type="hidden" value="" name="size">
															<span id="size">

																<input id="size_0" value="1024x768" checked="checked" type="radio" name="size">
																<label for="size_0">1024 X 768</label><br>

																		<input id="size_1" value="800x600" type="radio" name="size">
																<label for="size_1">800 X 600</label><br>
																		<input id="size_2" value="1280x960" type="radio" name="size">
																<label for="size_2">1280 X 960</label>
															</span>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="save">
													<span style="width:100%; text-align:center; margin:25px 0">Şablon bilgileri ve sayfa boyutları alındı. Son olarak oluştur butonuna tıklayınız.</span>
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
			FormWizard.init();
		});
	</script>


<script type="text/javascript">
 	$('form').addClass('form-horizontal');
</script>
<script type="text/javascript">
var wizform = $('#wizForm');
	 $('#templateCreate').click(function () {
                var isim=$('[name="isim"]').val();
                var yazar=$('[name="yazar"]').val();
                if (isim.length & yazar.length) {
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
            }else{
            	msg = Messenger().post({
                    message:"Lütfen Gerekli Alanlarını Doldurunuz",
                    type:"info",
                    showCloseButton: true,
                    hideAfter: 100
                });
            };
            })
</script>