<div class="view" style="float: left;margin: 5px;"  >

<h2> <? echo $data->role->title; ?> </h2>
<p> <? echo $data->role->description; ?> </p>

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
<? if(isset($data->payment)) echo $data->payment->title; ?>
<? } ?>

<?
		echo Yum::t('This membership is still {days} days active', array(
					'{days}' => $data->daysLeft()));
?>

</div>
