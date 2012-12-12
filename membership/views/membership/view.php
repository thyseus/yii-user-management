<?php
$this->breadcrumbs=array(
'Memberships'=>array('index'),
	$model->id,
	);

?>

<h1><?php echo Yii::t('app', 'View');?> Membership #<?php echo $model->id; ?></h1>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.CDetailView', array(
'data'=>$model,
	'attributes'=>array(
					'id',
		'type',
		'fee',
		'period',
),
	)); ?>


	<h2><?php echo CHtml::link(Yii::t('app','{relation}',array('{relation}'=>'MembershipHasCompanys')), array('MembershipHasCompany/admin'));?></h2>
<ul><?php foreach($model->membershipHasCompanys as $foreignobj) { 

					printf('<li>%s</li>', CHtml::link($foreignobj->order_date, array('membershiphascompany/view', 'id' => $foreignobj->id)));

					} ?></ul>
