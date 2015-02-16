<?php $this->title = Yum::t('Permission Denied'); ?>
<div class="hint">
	<p> <?php echo Yum::t('You are not allowed to view this profile.'); ?> </p>
	<p> <?php echo CHtml::link(
			Yum::t(
				'Back to your profile'), array('profile/profile')); ?> </p>
	</div>
