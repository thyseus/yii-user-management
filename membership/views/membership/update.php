<?
$this->breadcrumbs=array(
		Yum::t('Memberships')=>array('index'),
		Yum::t('Update'),
		);

?>

<h1> <? echo Yum::t('Membership'); ?> </h1>
<?
$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'user.username',
						'role.price',
		'payment.title',

				),
			)); 

echo Yum::t('Ordered at').': '.date("Y. m. d G:i:s", $model->order_date) . '<br />';
echo Yum::t('Ends at').': ' . date("Y. m. d G:i:s", $model->end_date) . '<br />';
echo Yum::t('Payment date').': '. date("Y. m. d G:i:s", $model->payment_date) . '<br />';

echo CHtml::beginForm(array('//membership/membership/update'));
echo CHtml::hiddenField('YumMembership[id]', $model->id);
echo CHtml::submitButton(Yum::t('Set payment date to today'));
echo CHtml::endForm();
?>
