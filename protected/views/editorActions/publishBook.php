<section>
	<div class="row">
							<div class="col-md-10">
								<!-- BOX -->
								<div class="box border red" id="formWizard">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i><?php _e('Yayınlama'); ?> - <span class="stepHeader"><?php _e('Aşama'); ?> 1 / 3</h4>
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
													<a href="#host" data-toggle="tab" class="wiz-step">
													<span class="step-number">1</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Sunucu Bilgileri'); ?> </span>   
													</a>
												 </li>
												 <li>
													<a href="#book" data-toggle="tab" class="wiz-step">
													<span class="step-number">2</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Kitap Bilgileri'); ?> </span>   
													</a> 
												 </li>
												 <li>
													<a href="#money" data-toggle="tab" class="wiz-step">
													<span class="step-number">3</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Fiyat Bilgileri'); ?> </span>   
													</a> 
												 </li>
												 <li>
													<a href="#confirm" data-toggle="tab" class="wiz-step">
													<span class="step-number">4</span>
													<span class="step-name"><i class="fa fa-check"></i> <?php _e('Onay'); ?> </span>   
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

												 

												

												 <div class="tab-pane active" id="host">
													
													<?php
													foreach ($hosts as $key => $host) {
														$contentHostIds[$host->hosting_client_id]=$host->hosting_client_IP.' : '.$host->hosting_client_port;
													}
													//$contentHostIds['GIWwMdmQXL']='cloud.lindneo.com';
													?>


													<?php echo $form->hiddenField($model,'contentId'); ?>
													<?php echo $form->hiddenField($model,'organisationId'); ?>
													<?php echo $form->hiddenField($model,'organisationName'); ?>
													<?php echo $form->hiddenField($model,'created'); ?>
												

													<div class="form-group">
														<label  class="col-md-3 control-label">
														<?php _e("Sunucular"); ?><span class="required">*</span>
														</label>
														<div class="col-md-9">
															<div class="checker" id="uniform-PublishBookForm_contentHostId_2">
																<span class="checked">
																	<input class="uniform" id="PublishBookForm_contentHostId_2" checked="checked" value="GIWwMdmQXL" type="checkbox" name="host[]">
																</span>
															</div>
															<label for="PublishBookForm_contentHostId_2">cloud.lindneo.com : 2222</label>
															<br>
														<?php echo $form->checkBoxList($model,'contentHostId',$contentHostIds,array('class'=>'uniform','name'=>'host')); ?>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="book">
													<div class="form-group">
														<label class="control-label col-md-3" for="PublishBookForm_contentTitle"><?php _e('Kitap İsmi') ?><span class="required">*</span></label>
														
														<div class="col-md-4">
															<?php echo $form->textField($model,'contentTitle',array('class'=>'form-control','name'=>'contentTitle','placeholder'=>__("Lütfen bir isim girin!"))); ?>
															<span class="error-span"></span>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3" for="PublishBookForm_contentType"><?php _e('Kitap Tipi') ?><span class="required">*</span></label>
														<div class="col-md-4">
															<?php echo $form->radioButtonList($model,'contentType',array('epub'=>'Epub','epdf'=>'Epdf','pdf'=>'pdf'),array('class'=>'uniform','name'=>'contentType')); ?>
														</div>
													</div>

													<div class="form-group">
														<label class="control-label col-md-3"><?php _e('Kitap Açıklaması'); ?><span class="required">*</span></label>
														<div class="col-md-4">
															<?php echo $form->textArea($model,'contentExplanation',array('class'=>'form-control','name'=>'contentExplanation','placeholder'=>__('Lütfen bir açıklama girin!'))); ?>
														  <span class="error-span"></span>
													   </div>
													</div>
												</div>
												<div class="tab-pane" id="money">

													<div class="form-group">
														<label for="PublishBookForm_contentIsForSale" class="control-label col-md-3"><?php _e('Is For Sale?'); ?><span class="required">*</span></label>
														<div class="col-md-4">
														<?php echo $form->radioButtonList($model,'contentIsForSale',array('Yes'=>__('Evet'),'Free'=>__('Hayır')),array('class'=>'uniform','name'=>'contentIsForSale')); ?>
														</div>
													</div>

													<div class="form-group">
													<label for="PublishBookForm_contentPriceCurrencyCode" class="control-label col-md-3"><?php _e('Para Birimi'); ?><span class="required">*</span></label>
													<div class="col-md-4">
													<?php echo $form->radioButtonList($model,'contentPriceCurrencyCode',array('949'=>'Türk Lirası','998'=>'Dolar','978'=>'Euro'),array('class'=>'uniform','name'=>'contentCurrency')); ?>
													</div></div>

													<div class="form-group">
														<label for="PublishBookForm_contentPrice" class="control-label col-md-3"><?php _e('Kitap Fiyatı') ?><span class="required">*</span></label>
														<div class="col-md-4">
														<?php echo $form->textField($model,'contentPrice',array('class'=>'form-control','name'=>'contentPrice','placeholder'=>__('Lütfen bir fiyat girin!'))); ?>
													</div>
													</div>

													<div class="form-group">
														<label for="PublishBookForm_contentReaderGroup" class="control-label col-md-3"><?php _e('Reader Group'); ?><span class="required">*</span></label>
														<div class="col-md-4">
															<?php echo $form->textField($model,'contentReaderGroup',array('class'=>'form-control','name'=>'contentReaderGroup')); ?>
														</div>
													</div>
												 </div>
												 <div class="tab-pane" id="confirm">
													<h3 class="block">Yayınlama Özeti</h3>
													<div class="well">
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e("Sunucu"); ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="host"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e('Kitap İsmi') ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="contentTitle"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e('Kitap Tipi') ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="contentType"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e('Kitap Açıklaması'); ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="contentExplanation"></p>
														   </div>
														</div>
														
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e('Is For Sale?'); ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="contentIsForSale"></p>
														   </div>
														</div>
														
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e('Kitap Fiyatı') ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="contentPrice"></p>
														   </div>
														</div>
														<div class="form-group">
														   <label class="control-label col-md-3"><?php _e('Reader Group'); ?>:</label>
														   <div class="col-md-4">
															  <p class="form-control-static" data-display="contentReaderGroup"></p>
														   </div>
														</div>
														<div class="form-group">
														   <div class="col-md-2">
														   </div>
														   <div class="col-md-1" style="text-align:right">
															  <input type="checkbox" id="rights" name="rights" class="uniform" value="accepted" checked /> 
														   </div>
														   
														   <label class="control-label col-md-3" style="text-align:left"> Kullanıcı Sözleşmesini Kabul Ediyorum.</label>
														</div>
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
													   <a href="javascript:;" class="btn btn-success submitBtn">
														<?php _e('Yayınla'); ?> <i class="fa fa-arrow-circle-right"></i>
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
			App.setPage("wizards_validations");  //Set current page
			App.init(); //Initialise plugins and elements
			FormWizard.init();
		});
	</script>

<script type="text/javascript">
 	$('form').addClass('form-horizontal');
</script>