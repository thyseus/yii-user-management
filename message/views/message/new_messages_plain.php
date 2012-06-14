<? 
if($messages) {
	echo '<div class="success">';

	echo Yum::t('You have new messages!');

	echo '<ul>';
	foreach($messages as $message) {
		printf("<li><span> %s</span> &nbsp; %s</li>",
				CHtml::link($message->title, array(
						'//message/message/view', 'id' => $message->id)),
				CHtml::link(Yum::t('Reply'), array(
							'//message/message/compose',
							'to_user_id' => $message->from_user_id)));
	}
	echo '</ul>';
	echo '</div>';
} 

?>
