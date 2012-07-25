<div class="view">

<h2> <? echo $data->role->description; ?> </h2>

<?
echo Yum::t('Order number'). ': '.$data->id . '<br />';
if($data->role->price != 0)
	if($data->payment_date == 0) 
	echo Yum::t('Membership has not been payed yet');
	else {
		echo Yum::t('Membership payed at: {date}', array(
					'{date}' =>  date('d. m. Y', $data->payment_date)));
		echo '<br />';
		echo Yum::t('Membership ends at: {date} ', array(
					'{date}' =>  date('d. m. Y', $data->end_date)));  
		echo '<br />';
	}
?>

<? if($data->role->price != 0) { ?>
<br /> 
<? echo Yum::t('Ordered at') . ': '; ?>
<? echo date('d. m. Y', $data->order_date); ?> 
<br /> 
<? echo Yum::t('Payment type') . ': '; ?>
<? if(isset($data->payment)) echo $data->payment->title . '<br />'; ?>
<? } ?>

<?
if($data->end_date != 0)
	echo Yum::t('This membership is still active {days} days', array(
				'{days}' => $data->daysLeft()));
	?>


<? if($data->isActive()) { ?>
<?= CHtml::beginForm(array('//membership/membership/extend')); ?>
<p> <?= Yum::t('When the membership expires'); ?>: </p>
<?
$options = array(
		0 => Yum::t('Automatically extend subscription'),
		'cancel' => Yum::t('Cancel Subscription'));
foreach( $data->getPossibleExtendOptions('downgrade') as $key => $option)
	$options[$key] = $option;
foreach( $data->getPossibleExtendOptions('upgrade') as $key => $option)
	$options[$key] = $option;

echo CHtml::hiddenField('membership_id', $data->id);
echo CHtml::dropDownList('subscription',
		$data->subscribed == -1 ? 'cancel' : $data->subscribed, $options); 
echo CHtml::submitButton(Yum::t('Save'));
?>
	<?= CHtml::endForm(); ?>
<? } ?>
</div>
