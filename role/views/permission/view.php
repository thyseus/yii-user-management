<?php
if(isset($actions))
	foreach($actions as $action) {
		printf('<h2>%s</h2>', $action->title);
		echo Yum::t(
				'The following users have permission to perform the action {action}:',
				array(
					'{action}' => $action->title));
		if($action->permissions) {
			foreach($action->permissions as $permission) {
				echo '<ul>';
				if($permission->type == 'user') {
					$user = YumUser::model()->findByPk($permission->principal_id);
					printf('<li>%s</li>', CHtml::link(
								$user->username, array('/user/view', 'id' => $user->id)));
				}
				if($permission->type == 'role') {
					$role = YumRole::model()->findByPk($permission->principal_id);
					printf('<li>role %s</li>', CHtml::link(
								$role->title, array('/role/view', 'id' => $role->id)));
				}
				echo '</ul>';
			}
		}
	} else 
echo Yum::t('No user has permission');
?>

