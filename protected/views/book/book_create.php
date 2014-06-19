<section>
	<div id="content" class="col-lg-12">
    
    <div class="page-header">
			<h3 class="content-title pull-left">Eser Oluşturma</h3>
		</div>
    
							<div class="col-md-10 creating_book_box">
								<!-- BOX -->
								<div class="box border blue" id="bookCreateWizard">
									<div class="box-title">
										<h4><i class="fa fa-book"></i><?php _e('Eser Oluşturma '); ?> - <span class="stepHeader"><?php _e('Aşama'); ?> 1 / 3</h4>
									</div>
									<div class="box-body form">
										<!-- <form id="wizForm" action="#" class="form-horizontal" > -->
									<?php 
										$form=$this->beginWidget('CActiveForm', array(
											'id'=>'FileForm',
											'enableAjaxValidation'=>false,
											'htmlOptions'=>array(
												'enctype'=>"multipart/form-data",
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
												 <li class="epub_select pdf_select">
													<a href="#book_information" data-toggle="tab" class="wiz-step">
													<span class="step-number">2</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Eser Bilgileri'); ?> </span>   
													</a> 
												 </li>
												 <li class="epub_select">
													<a href="#book_res" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Çözünürlük'); ?> </span>   
													</a> 
												 </li>
												 <li class="epub_select">
													<a href="#book_templates" data-toggle="tab" class="wiz-step">
													<span class="step-number">4</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Şablonlar'); ?> </span>   
													</a> 
												 </li>
												 <li class="pdf_select">
													<a href="#pdf_upload" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Pdf Yükle'); ?> </span>   
													</a> 
												 </li>
											  </ul>
											  <div id="bar" class="progress progress-striped progress-sm active" role="progressbar">
												 <div class="progress-bar progress-bar-warning"></div>
											  </div>
											  <div class="tab-content">
												 <div class="alert alert-danger display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													<?php _e('Lütfen gerekli alanları doldurup tekrar deneyiniz.'); ?>
												 </div>
												 <div class="alert alert-success display-none">
													<a class="close" aria-hidden="true" href="#" data-dismiss="alert">×</a>
													Your form validation is successful!
												 </div>
												<div class="tab-pane active" id="book_type">
													<div class="form-group">
														<label for="radio" class="control-label col-md-4"><?php _e('Eser Türü'); ?><span class="required">*</span></label>
														<div class="col-md-8">
														<input id="ytsize" type="hidden" value="" name="book_type">
															<span id="book_type">
																<div class="" id="uniform-book_type_0">
																	<span class="">
																		<input class="uniform" id="book_type_0" value="epub" type="radio" name="book_type">
																	</span>
																<label for="book_type_0"><img src="../../../css/ui/img/bookcreate/epub.png" /></label><br>
																</div>
																<div class="" id="uniform-book_type_1">
																	<span class="">
																		<input class="uniform" id="book_type_1" value="pdf" type="radio" name="book_type">
																	</span>
																<label for="book_type_1"><img src="../../../css/ui/img/bookcreate/pdf.png" /></label><br>
																</div>
																<!--
                                                                <div class="" id="uniform-book_type_2">
																	<span class="">
																		<div class="radio" id="uniform-book_type_2"><span><input class="uniform" id="book_type_2" value="word" type="radio" name="book_type"></span></div>
																	</span>
																<label for="book_type_2"><div class="coming_soon_layer">YAKINDA...</div><img src="../../../css/ui/img/bookcreate/word.png"></label><br>
																</div>
																-->
															</span>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book_information">
												<div class="form-group">
														<label for="radio" class="control-label col-md-5"><?php _e('Çalışma Grubu'); ?><span class="required">*</span></label>
														<div class="col-md-7">
															<span id="workspaces">
																<?php 
																$i=0;
																foreach ($workspaces as $workspace_id => $workspace_name): ?>
																<div class="" id="uniform-workspaces_<?php echo $i; ?>">
																	<span class="checked">
																		<input id="workspaces_<?php echo $i; ?>" value="<?php echo $workspace_id; ?>" checked="checked" type="radio" name="workspaces">
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
														<label  class="col-md-5 control-label">
														<?php _e("Eser Adı"); ?><span class="required">*</span>
														</label>
														<div class="col-md-7">
                                                        <input class="form-control" name="book_name" type="text">
														</div>
													</div>
													<div class="form-group">
														<label  class="col-md-5 control-label">
														<?php _e("Yazar"); ?><span class="required">*</span>
														</label>
														<div class="col-md-7">
															<input class="form-control" name="book_author" type="text">
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book_res">
													<div class="form-group">
														<label for="radio" class="control-label col-md-6"><?php _e('Boyutlar'); ?><span class="required">*</span></label>
														<div class="col-md-6">

																<input id="book_size_1" value="800x600" type="radio" class="book_size" name="book_size">
																<label for="book_size_1">800 X 600</label><br>
																

																<input id="book_size_0" value="1024x768" type="radio" class="book_size" name="book_size">
																<label for="book_size_0">1024 X 768</label><br>
																
																<input id="book_size_2" value="1280x960" type="radio" class="book_size" name="book_size">
																<label for="book_size_2">1280 X 960</label>
															
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book_templates">
													<div class="form-group">
														<label for="radio" class="control-label col-md-6"><?php _e('Şablonlar'); ?></label>
														<div class="col-md-6">
															<input id="ytsize" type="hidden" value="" name="templates">
															<span id="templates">

															</span>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="pdf_upload">
													<div class="form-group">
														<label for="pdf" class="control-label col-md-6"><?php _e('Pdf Yükle'); ?></label>
														<div class="col-md-6">
															<!-- <input name="pdf" type="file" multiple="" /> -->
															<?php echo $form->fileField($model, 'pdf_file'); ?>
															<?php echo $form->error($model,'pdf_file'); ?>
														</div>
													</div>
												</div>
										   </div>
										   <div class="wizard-buttons">
											  <div class="row">
												 <div class="col-md-12">
													<div class="col-md-offset-5 col-md-9">
													   <a href="javascript:;" class="btn btn-default prevBtn">
														<i class="fa fa-arrow-circle-left"></i> <?php _e('Geri'); ?> 
													   </a>
													   <a href="javascript:;" class="btn brand_color_for_buttons nextBtn">
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