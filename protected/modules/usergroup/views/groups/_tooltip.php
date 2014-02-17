<?php

$template = '<p> %s: %s </p>';

if($data->privacy && $data->privacy->show_online_status)
	if($data->isOnline()) {
		echo Yum::t('User is Online!');
		echo CHtml::image(Yum::register('images/green_button.png'));
	}

printf($template, Yum::t('Username'), $data->username);

echo CHtml::link(Yum::t('Write a message'), array(
			'//message/message/compose', 'to_user_id' => $data->id)) . '<br />';
echo CHtml::link(Yum::t('Visit profile'), array(
			'//profile/profile/view', 'id' => $data->id));



