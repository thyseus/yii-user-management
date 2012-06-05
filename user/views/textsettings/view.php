<?php
$this->title = Yum::t('Yum Text Settings');
$this->breadcrumbs=array(
	Yum::t('Yum Text Settings')=>array('admin'),
	$model->language,
);

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'language',
		'text_email_registration',
		'text_email_recovery',
		'text_email_activation',
		'text_friendship_new',
		'text_profilecomment_new',
		'text_membership_ordered',
		'text_payment_arrived',
		//'text_membership_header',
		//'text_membership_footer',
	),
)); 

echo CHtml::link(Yum::t('Edit text'), array('//user/yumTextSettings/update', 'id' => $model->id));
?>


