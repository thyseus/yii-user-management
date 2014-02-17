<?php
$this->breadcrumbs=array(
	'Pakete',
	'Bestellungen'
);

		?>

<h1> Bestellungen </h1>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'membership-has-company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'company.name',
		array(
				'name'=>'order_date',
				'value' =>'date("Y. m. d G:i:s", $data->order_date)'),
		array(
				'name'=>'end_date',
				'value' =>'date("Y. m. d G:i:s", $data->end_date)'),
		array(
				'name'=>'payment_date',
				'value' =>'date("Y. m. d G:i:s", $data->payment_date)'),
		'membership.type',
		'membership.fee',
		'payment.title',
	),
)); ?>
