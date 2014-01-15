<?php
/* @var $this OrganisationHostingsController */
/* @var $model OrganisationHostings */

$this->breadcrumbs=array(
	'Organisation Hostings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OrganisationHostings', 'url'=>array('index')),
	array('label'=>'Create OrganisationHostings', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#organisation-hostings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Organisation Hostings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'organisation-hostings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'organisation_id',
		'hosting_client_IP',
		'hosting_client_port',
		'hosting_client_id',
		'hosting_client_key1',
		'hosting_client_key2',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
