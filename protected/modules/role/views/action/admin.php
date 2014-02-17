<div class="container">
<div class="span12">
<div class="row">

<?php
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Manage'),
);

?>
<h1> <?php echo Yum::t('Manage Actions'); ?></h1>

<?php

echo CHtml::link(
		Yum::t('Create new Action'), array(
			'//role/action/create'), array('class' => 'btn')); 

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'action-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'comment',
		'subject',
		array(
			'class'=>'CButtonColumn',
		),
	),
			'htmlOptions' => array('class' => 'table table-striped table-condensed admin-user'),
)); ?>
</div>
</div>
</div>
