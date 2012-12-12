<?php
$this->breadcrumbs=array(
		Yum::t('Translation')=>array('admin'),
		Yum::t('Manage'),
		);
?>

<h2><?php echo Yum::t('Manage Translations'); ?> </h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'category-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				array('name' => 'language',
					'filter' => Yum::getAvailableLanguages(),
					),
				array('name' => 'message',
					'type' => 'raw'),
				array('name' => 'category',
					'type' => 'raw'),
				array('name' => 'translation',
					'type' => 'raw'),
				array(
					'class'=>'CButtonColumn',
					'template' => '{update}',
					'updateButtonUrl'=>'Yii::app()->controller->createUrl("update", array(
							"message" => $data->message,
							"category" => $data->category,
							"language" => $data->language))',
					),
				),
			)); ?>

			<?php echo CHtml::link(Yum::t('Create new Translation'), array('create')); ?>
