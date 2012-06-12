<?
$this->title = Yum::t('My friends');
$this->breadcrumbs = array(Yum::t('Friends'));



if($friends) {
	echo '<div class="view-light">';

	echo '<table width="100%">';

	foreach($friends as $friend) {
		$options = array();
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'groups-form',
			'enableAjaxValidation'=>false,
			));

		echo CHtml::activeHiddenField($friend, 'inviter_id');
		echo CHtml::activeHiddenField($friend, 'friend_id');

		if($friend->status == 1) { // Confirmation Pending
			if($friend->inviter_id == Yii::app()->user->id) {
				$options = CHtml::submitButton(Yum::t('Cancel request'),array(
							'id'=>'cancel_request', 'name'=>'YumFriendship[cancel_request]'));
			} else {
				$options = CHtml::submitButton(Yum::t('Confirm'), array(
							'id'=>'add_request','name'=>'YumFriendship[add_request]'));
//				$options .= CHtml::submitButton(Yum::t('Ignore'), array(
//							'id'=>'ignore_request','name'=>'YumFriendship[ignore_request]'));
				$options .= CHtml::submitButton(Yum::t('Deny'), array(
							'id'=>'deny_request','name'=>'YumFriendship[deny_request]'));
			}
		} else if($friend->status == 2) { // Users are friends
			$options = CHtml::submitButton(Yum::t('Remove friend'),array(
						'id'=>'remove_friend','name'=>'YumFriendship[remove_friend]','confirm' => Yum::t('Are you sure you want to remove this friend?')));
		}
				if($friend->inviter_id == Yii::app()->user->id)
					$label = $friend->invited;
				else
					$label = $friend->inviter;

			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td class="text-right">%s</td></tr>',
					$label->getAvatar(true),
					CHtml::link($label->username, array(
							'//profile/profile/view', 'id'=>$label->id)),
					$friend->getStatus(),
					CHtml::link(Yum::t('Write a message'), array(
							'//message/message/compose', 'to_user_id'=>$label->id)),
							$friend->status != 3 ? $options : ''

							);

$this->endWidget();
	}
	echo '</table>';
	echo '</div>';
} else {
	echo Yum::t('You do not have any friends yet');
}

?>

