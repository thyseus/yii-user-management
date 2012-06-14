<?
if($messages) {
	echo '<table class="new_messages">';
	printf('<th>%s</th><th>%s</th>',
			Yum::t('From'),
			Yum::t('Subject'));
	foreach($messages as $message) {
		printf('<tr><td class="first-row">%s</td><td class="last-row">%s</td></tr>',
				substr($message->from_user->username, 0, 10),
				CHtml::link(substr($message->title, 0, 40), array
					('//message/message/view', 'id' => $message->id)));
	}
	echo '</table>';
} else
echo Yum::t('No new messages'); 
?>
