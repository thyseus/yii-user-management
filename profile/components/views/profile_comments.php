<?php
if($comments) {
	echo '<p>'.Yum::t('This users have commented your profile recently') . ': </p>';
	foreach($comments as $comment) {
		printf('<div style="text-align:center;width: 50px;float:left;margin: 0px 10px 10px 0;">%s %s</div>', 
				CHtml::link($comment->user->getAvatar(true), array(
						'//profile/profile/view', 'id' => $comment->user_id)),
				CHtml::link($comment->user->username, array(
						'//profile/profile/view', 'id' => $comment->user_id)));
		printf('<div style="float:left;width:250px; margin-bottom:10px;">%s </div>', 
				substr($comment->comment, 0, 100));
		echo '<div style="clear: both;"></div>';

	}
} else
echo Yum::t('Nobody has commented your profile yet');
?>

<div style="clear: both;"> </div>
