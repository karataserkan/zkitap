<?php
/* @var $this FaqController */
/* @var $dataProvider CActiveDataProvider */
?>
<script>
		jQuery(document).ready(function() {		
			App.setPage("gallery");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
<div class="row">
					<div id="content" class="col-lg-12" style="min-height:1063px !important">
						<!-- PAGE HEADER-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<!-- STYLER -->
									
									<!-- /STYLER -->
										<h3 class="content-title pull-left" >Destek</h3>
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
						</div>
<?php //echo CHtml::link(__('Ekle'),"/faq/create",array('class'=>'btn white radius')); ?>
<script type="text/javascript">
	$('.list-group-item').on('click',function(){
		$('.list-group-item').removeClass('active');
		$(this).toggleClass('active');
	});
</script>