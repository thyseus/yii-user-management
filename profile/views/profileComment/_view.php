<div class="guestbook">
	<div class="guestbook-header">
			<strong><? echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</strong>
			<? echo CHtml::link(CHtml::encode($data->user->username), array(
						'//profile/profile/view', 'id' => $data->user_id)); ?>
			|
			<strong><? echo CHtml::encode($data->getAttributeLabel('createtime')); ?>:</strong>
			<? $locale = CLocale::getInstance(Yii::app()->language);
			echo $locale->getDateFormatter()->formatDateTime($data->createtime, 'medium', 'medium'); ?>
	</div>
		
	<div class="guestbook-avatar">
		<? echo $data->user->getAvatar(true); ?>
	</div>

	<div class="guestbook-comment">
		<? echo CHtml::encode($data->comment); ?>
	</div>
	
	<div class="guestbook-footer">
			<?
				// the owner of the profile as well as the owner of the comment can remove
				if($data->user_id == Yii::app()->user->id
						|| $data->profile_id == Yii::app()->user->id) {
					echo CHtml::Button(Yum::t('Remove comment'), array(
								'confirm' => Yum::t('Are you sure to remove this comment from your profile?'),
								'submit' => array( '//profile/comments/delete', 'id' => $data->id)));
				}		
			?>
	</div>

</div>
