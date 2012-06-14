<?
$this->breadcrumbs=array(
		Yum::t('Memberships')=>array('index'),
		Yum::t('Manage'),
		);
?>

<h1> <? echo Yum::t('Memberships'); ?></h1>

<?
$locale = CLocale::getInstance(Yii::app()->language);

$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'membership-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				array('name' => 'id',
					'htmlOptions' => array('style' => 'width: 20px;')),
				'user.username',
				'role.title',
				array(
					'name'=>'order_date',
					'value' =>'date("Y. m. d G:i:s", $data->order_date)',
					'filter' => false,
					),
				array(
					'name'=>'end_date',
					'value' =>'date("Y. m. d G:i:s", $data->end_date)',
					'filter' => false,
					),
				array(
					'name'=>'payment_date',
					'value' =>'($data->payment_date === null || $data->payment_date == 0) ? Yum::t("Not yet payed") : date("Y. m. d G:i:s", $data->payment_date)',
					'filter' => array('not_payed' => Yum::t('Not yet payed')),
					),
				'role.price',
				'payment.title',
				array(
						'header' => Yum::t('Time left'),
						'value' => '$data->timeLeft()', 
						'type' => 'raw'),
				array(
						'class'=>'CButtonColumn',
						'template' => '{update}{delete}',
						),
				),
				)); ?>
