<?php
$this->breadcrumbs=array(
	Yum::t('Usergroups')=>array(Yii::t('app', 'index')),
	Yum::t( 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app', 'List') . ' Usergroup',
			'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' Usergroup',
		'url'=>array('create')),
	);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('usergroup-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> <?php echo Yii::t('app', 'Manage'); ?> Usergroups</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'owner_id',
		'title',
		'description',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
