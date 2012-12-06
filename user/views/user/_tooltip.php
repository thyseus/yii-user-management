<?

$template = '<p> %s: %s </p>';

if(Yum::hasModule('profile') && Yum::module('profile')->enablePrivacySetting) {
	if($data->privacy && $data->privacy->show_online_status) {
		if($data->isOnline()) {
			echo Yum::t('User is Online!');
			echo CHtml::image(Yum::register('images/green_button.png'));
		}
	}
}

printf($template, Yum::t('Username'), $data->username);

printf($template, Yum::t('First visit'), date(UserModule::$dateFormat, $data->createtime));
printf($template, Yum::t('Last visit'), date(UserModule::$dateFormat, $data->lastvisit));

if(Yum::hasModule('messages')){
	echo CHtml::link(Yum::t('Write a message'), array(
				'//message/message/compose', 'to_user_id' => $data->id)) . '<br />';
}

if(Yum::hasModule('profile')){
	echo CHtml::link(Yum::t('Visit profile'), array(
				'//profile/profile/view', 'id' => $data->id));
}



