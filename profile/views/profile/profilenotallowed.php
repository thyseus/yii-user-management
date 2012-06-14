<? $this->title = Yum::t('Permission Denied'); ?>
<div class="hint">
	<p> <? echo Yum::t('You are not allowed to view this profile.'); ?> </p>
	<p> <? echo CHtml::link(
			Yum::t(
				'Back to your profile'), array('profile/profile')); ?> </p>
	</div>
