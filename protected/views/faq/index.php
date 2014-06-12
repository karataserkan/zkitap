<?php
/* @var $this FaqController */
/* @var $dataProvider CActiveDataProvider */
?>
<script>
		jQuery(document).ready(function() {	
			$('#li_faq').addClass('current');	
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
<?php $user=User::model()->findByPk(Yii::app()->user->id); ?>
<!-- POPUP EDITORS -->
<div class="modal fade" id="addTicket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		  <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> <?php _e("Destek iste"); ?></h4>
		</div>
		<div class="modal-body">
		 	<form id="destek" class="form-horizontal">
				<div class="form-group centering_with_text_align support_alert_messages" id="dFeedback" style="display:none">
					<div class="col-md-12">
						<span class="alert alert-danger" id="feedback"></span>
					</div>
				</div>
				<div class="form-group centering_with_text_align support_alert_messages" id="dSuccessFeedback" style="display:none">
					<div class="col-md-12">
						<span class="alert alert-success" id="succesF"></span>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-12">
						<input class="form-control" name="konu" placeholder="Konu" id="konu" type="text">															
					</div>
				</div>	
				<div class="form-group">
					<div class="col-md-12">
						<textarea class="form-control" name="mesaj" placeholder="Mesaj" id="mesaj" type="text"></textarea>
					</div>
				</div>	
		 	</form>
		</div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-primary brand_color_for_buttons" id="send_ticket"><?php _e("Gönder"); ?></a>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Vazgeç"); ?></button>
	      </div>
		</div>
	  </div>
	</div>
 <script type="text/javascript">
	$('#send_ticket').click(function(){
		var email='<?php echo $user->email; ?>';
		var konu=$('#konu').val();
		var mesaj=$('#mesaj').val();
		var request=JSON.stringify({
			from_email:email,
			subject:konu,
			body:mesaj,
			allUserData:'<?php echo json_encode ($user->attributes); ?>',
			name:'<?php echo $user->name; ?>',
			surname:'<?php echo  $user->surname; ?>'
		});
		request=btoa(encodeURI(request));

		if (email && konu && mesaj) {
			$.ajax({
					type: "POST",
	                data: {request:request},
	                url:'http://crm.linden-tech.com/addTicketFromOkutus.php'
	            }).done(function(html){
	            	console.log(html);
	        		$('#dSuccessFeedback').show();
					$('#succesF').text('Destek talebiniz alındı. En yakın zamanda sizinle iletişime geçeceğiz.').prepend("<i class='fa fa-check'></i> ");    	
	            });
		}else{
			$('#dFeedback').show();
			$('#feedback').text('Lütfen bilgileri eksiksiz giriniz!').prepend("<i class='fa fa-exclamation-circle'></i> ");
		};

	});
</script>
<!-- POPUP END -->



					<div id="content" class="col-lg-12" style="min-height:1063px !important">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<!-- STYLER -->
									
									<!-- /STYLER -->
										<h3 class="content-title pull-left" >Destek</h3>
                                        
                                        <a data-id="addTicket" data-toggle="modal" data-target="#addTicket" class="btn pull-right pageheader_button_margin brand_color_for_buttons"><i class="fa fa-exclamation-circle"></i> Destek İste</a>
								</div>
							</div>
						</div>
						<!-- /PAGE HEADER -->
						<!-- FAQ -->
						<div class="row">
							<!-- NAV -->
							<div id="list-toggle" class="col-md-3">
								<div class="list-group">
								<?php 
								if($categories):
								foreach ($categories as $key => $category) {?>
								  <a href="#<?php echo $category->faq_category_id; ?>" data-toggle="tab" class="list-group-item <?php echo (!$key) ? 'active':''; ?>"><i class="fa fa-tags"></i> <?php echo $category->faq_category_title; ?></a>
									
								<?php }
								endif; ?>
								</div>
							</div>
							<!-- /NAV -->
							<!-- CONTENT -->
							<div class="col-md-9">
								<div class="tab-content">
							<?php
								if($categories):
								   foreach ($categories as $k => $category) {?>
									<div class="tab-pane <?php echo (!$k) ? 'active':''; ?>" id="<?php echo $category->faq_category_id; ?>">
									  <div class="panel-group" id="accordion">
										<?php
										$i=0;
									  	foreach ($faqs as $key => $data): 
								  			if (!empty($data['categories'])) {
										  		foreach ($data['categories'] as $key2 => $faqCategory) {
										  			if($faqCategory->faq_category_id==$category->faq_category_id)
										  			{ 
										  				$i++;
										  				?>
													  <div class="panel panel-default">
														 <div class="panel-heading">
															<h3 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1_<?php echo $i.(($key)+1).$category->faq_category_id; ?>"><?php echo $i. '. ' .$data['faq']->faq_question; ?> </a> </h3>
														 </div>
														 <div id="collapse1_<?php echo $i.(($key)+1).$category->faq_category_id; ?>" class="panel-collapse <?php echo ($i==1)?'in':'collapse';?> <?php echo (! $key) ? 'in' : '' ;?>">
															<div class="panel-body"> <?php echo $data['faq']->faq_answer; ?> </div>
														 </div>
													  </div>
													  <?php
										  			}
										  		}
								  			}
									  		?>
										<?php endforeach; ?> 
									  </div>
									  
									</div>
								  <?php }
								  endif; ?>
								</div>
							</div>
							<!-- /CONTENT -->
						
<?php //echo CHtml::link(__('Ekle'),"/faq/create",array('class'=>'btn white radius')); ?>
<script type="text/javascript">
	$('.list-group-item').on('click',function(){
		$('.list-group-item').removeClass('active');
		$(this).toggleClass('active');
	});
</script>
