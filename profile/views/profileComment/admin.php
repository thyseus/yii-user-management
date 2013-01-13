<?php
$this->title = Yum::t('app', 'Manage').' Profile Comments';
$this->breadcrumbs=array(
	'Profile Comments'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app', 'List') . ' ProfileComment',
			'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create') . ' ProfileComment',
		'url'=>array('create')),
	);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('profile-comment-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'profile-comment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		'profile_id',
		'comment',
		array(
				'name'=>'createtime',
				'value' =>'date("Y. m. d G:i:s", $data->createtime)'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
