<?php
/* @var $this FaqController */
/* @var $dataProvider CActiveDataProvider */
?>
<br><br><br>
<div class="col-md-9">
	<div class="tab-content">
	   <div class="tab-pane active" id="tab1">
		  <div class="panel-group" id="accordion">
		<?php if(isset($data) && !empty($data)): ?>
			  <?php foreach ($data as $faq_key => $faq): ?>
			  <div class="panel panel-default">
				 <div class="panel-heading">
					<h3 class="panel-title"> 
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $faq_key; ?>">
							<?php echo $faq->faq_question; ?>
						</a>
					</h3>
				 </div>
				 <div id="collapse<?php echo $faq_key; ?>" class="panel-collapse collapse" style="height: 0px;">
					<div class="panel-body">
						<?php echo $faq->faq_answer; ?>
						<?php if(!empty($faq->keywords)): ?>
						<?php foreach ($faq->keywords as $keyword_key => $keyword):?>
							<a href="/faq/keyword?keywords=<?php echo $keyword['keyword']; ?>" class="btn btn-warning">
								<span><?php echo $keyword['keyword']; ?></span>
							</a>
						<?php endforeach; ?>
						<?php endif; ?>
					</div>
				 </div>
			  </div>
			<?php endforeach; ?>
		<?php endif; ?>
		   </div>
	   </div>
	  
	</div>
</div>