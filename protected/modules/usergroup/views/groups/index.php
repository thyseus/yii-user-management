<?php
$this->breadcrumbs = array(
		Yum::t('Usergroups'),
		Yum::t('Browse'),
		);

$this->title = Yum::t('Usergroups'); ?>

<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
			)); ?>

<?php echo CHtml::link(Yum::t('Create new Usergroup'), array(
			'//usergroup/groups/create')); ?>
