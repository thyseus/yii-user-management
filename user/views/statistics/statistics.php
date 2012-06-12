<?
$this->title = Yum::t('Statistics');

$this->breadcrumbs = array(
    Yum::t('Users') => array('index'),
    Yum::t('Statistics'));

Yum::register('statistics.css');


echo '<table class="statistics" cellspacing=0 cellpadding=0>';
$f = '<tr><td>%s</td><td>%s</td></tr>';
printf($f, Yum::t('Total users'), $total_users);
printf($f, Yum::t('Active users'), $active_users);
//printf($f, Yum::t('Active first visit users'), $active_first_visit_users);
printf($f, Yum::t('New users registered today'), $todays_registered_users);
printf($f, Yum::t('Inactive users'), $inactive_users);
printf($f, Yum::t('Banned users'), $banned_users);
printf($f, Yum::t('Admin users'), $admin_users);
//if (Yum::hasModule('role'))
//	printf($f, Yum::t('Roles'), $roles);
/*	if (Yum::hasModule('profile')) {
		printf($f, Yum::t('Profiles'), $profiles);
		printf($f, Yum::t('Different viewn Profiles'), $profile_views);
		printf($f, Yum::t('Profile fields'), $profile_fields);
		printf($f, Yum::t('Profile field groups'), $profile_field_groups);
	} */
//printf($f, Yum::t('Messages'), $messages);
printf($f, Yum::t('Different users logged in today'), $logins_today);
echo '</table>';
?>
