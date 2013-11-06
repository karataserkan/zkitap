<?php
// yeni satır
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->title,
);
/*
$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->book_id)),
	array('label'=>'Delete Book', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->book_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Book', 'url'=>array('admin')),
);
*/
if($page=null)
		{
			$chapter=Chapter::model()->find('book_id=:book_id', array(':book_id' => $model->book_id ));
				$page=Page::model()->find('chapter_id=:chapter_id', array(':chapter_id' => $chapter->chapter_id ));

		} else 
$page=Page::model()->findByPk($page); 
print_r($page);

//$chapter=Chapter::model()->findByPk($page->chapter_id);

?>
	<style>
	.span-19 { width: 100%}
	.component{
		float:left;
		margin-right:10px;
		background: #ccc;

	}
	.ui-draggable{
		z-index:9999999;
	}
	.toolbox{float:left;border-right: 1px dashed #ccc;border-left: 1px dashed #ccc;padding: 5px;}
	.tool{float:left;}
	</style>
	<h1><?php echo $model->title; ?></h1>
	<hr>
	<div id='components'>
		<div class='component'>Text</div>
		<div class='component'>Image</div>
		<div class='component'>Gallery</div>
	</div>

	<div id='styler_box' style='clear:both'>
		<div class='toolbox'>
			<div class='tool radio'>Left Align</div>
			<div class='tool radio'>Right Align</div>
			<div class='tool select'>
				<select id='font-type'>
					<option value='helvetica'>Helvetica</option> 
					<option value='arial'>Arial</option> 
				</select> 
			</div>
			<div class='tool check'>Right Allign</div>
		</div>
		<div class='toolbox'>
			<div class='tool text'>ImageUrl: <input type='text' id='imagesrc' /></div>
		</div>
	</div>
		<a href='?r=chapter/create&book_id=<?php echo $model->book_id; ?>' >Add Chapter</a>
	<?php if(isset($chapter)) { ?>
		<a href='?r=page/create&chapter_id=<?php echo (isset($this->current_chapter) ? $this->current_chapter->chapter_id :  $chapter->chapter_id); ?>' >Add Page</a>
	<?php } ?>
	<div style='clear:both;'>


	</div>

</div> <!-- Top Box -->
<div id='author_pane' style='width:1240px; margin: 0 auto;margin-top:210px;'> <!-- Outhor Pane -->
<div id='editor_view_pane' style='background:#000; padding:5px;margin:5px;float:left;'>
	<div id='ruler' style='background:yellow; padding:25px;margin:5px;' >
		<div id='guide'> 
			<div id='current_page' style='background:white;border:thin solid black;zoom:1;padding:1cm;  height:700px;width:600px;position:relative' >
				Page Here Drag&drops 
			</div>
		</div> <!-- guide -->
	</div><!-- ruler -->


</div><!-- editor_pane -->


	<div id='chapters_pages_view' style='float:left; overflow:scroll;height:800px' >
		<?php 
		$page_NUM=0;

		$chapters=Chapter::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'book_id=:book_id', "params" => array(':book_id' => $model->book_id )));
		//print_r($chapters);
		foreach ($chapters as $key => $chapter) {
		
				$pagesOfChapter=Page::model()->findAll(array('order'=>  '`order` asc ,  created asc', "condition"=>'chapter_id=:chapter_id', "params" =>array(':chapter_id' => $chapter->chapter_id )) );
						$chapter_page=0;
				foreach ($pagesOfChapter as $key => $pages) {
					
					/* if( $pages->page_id
						==
						$page->page_id ){
						$this->current_page=$page;
						$this->current_chapter=$chapter;
					}*/
					$page_NUM++;
					?>
						<a href='<?php $this->createUrl("book/author", array('bookId' => $model->book_id,'page'=>$pages->page_id ));?>' >
							<?php
							if($chapter_page==0){
								?> 
								<div class='chapter' chapter_id='<?php echo $pages->chapter_id; ?>' chapter_id='<?php echo $pages->page_id; ?>' style='border:1px solid #000;width:30px;height:45px;padding:10px;margin:10px;'>
									<?php echo $chapter->title; ?>
								
								<?php
							} else {
								?>
								<div class='page' chapter_id='<?php echo $pages->chapter_id; ?>' chapter_id='<?php echo $pages->page_id; ?>'   style='border:1px solid #000;width:30px;height:45px;padding:10px;margin:20px;'>

								<?php
							}
							?>
							<?php echo $page_NUM . " $chapter_page"; ?>
							</div>
						</a>	
					<?php
					$chapter_page++;
				}

		}
		//$this->current_chapter=null;
		?>
		
			
	</div>


</div> <!-- Outhor Pane -->



