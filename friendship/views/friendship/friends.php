<?
if(!$profile = @$model->profile)
	return false;

if($profile->show_friends == 2) {
	echo '<div id="friends">';
		if(isset($model->friends)) {
			echo '<h2>' . Yum::t('Friends of {username}', array(
						'{username}' => $model->username)) . '</h2>';
			foreach($model->friends as $friend) {
				?>
					<div class="friend">
					<div class="avatar">
					<?
					echo $friend->getAvatar(true);
				?>
					<div class="username">
					<? 
					echo CHtml::link(ucwords($friend->username),
							Yii::app()->createUrl('//profile/profile/view',array(
									'id'=>$friend->id)));
				?>
					</div>
					</div>
					</div>
					<?
			}
		} else {
			echo Yum::t('{username} has no friends yet', array(
						'{username}' => $model->username)); 
		}
echo '</div><!-- friends -->';
}
Yii::import(
		'application.modules.friendship.controllers.YumFriendshipController');
echo YumFriendshipController::invitationLink(Yii::app()->user->id, $model->id);
?>
