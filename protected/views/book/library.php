<?foreach($books as $book){?>
    <h1><?= $book->title ?></h1>
    <p><?= $book->author ?></p>
    <p><?= CHtml::link(__('Düzenle'),array('editor/edit',"bookId"=>$book->id))?></p>


<?}?>