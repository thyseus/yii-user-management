<?php
$this->title = Yum::t('Permissions List');
$this->breadcrumbs=array(
		Yum::t('Permissions')=>array('index'),
		Yum::t('View'),
		);
if(isset($actions))
{
	foreach($actions as $action)
	{
		printf('<h2>%s</h2>', $action->title);
		if($action->permissions)
		{
			echo Yum::t('The following users have permission to perform this action');
			foreach($action->permissions as $permission)
			{
				echo '<ul>';
				if($permission->type == 'user') {
					$user = YumUser::model()->findByPk($permission->principal_id);
					printf('<li>%s</li>', CHtml::link($user->username, array('/user/view', 'id' => $user->id)));
				}
				if($permission->type == 'role') {
					$role = YumRole::model()->findByPk($permission->principal_id);
					printf('<li>role %s</li>', CHtml::link($role->title, array('/role/view', 'id' => $role->id)));
				}
				echo '</ul>';
			}
		}
		else
			echo Yum::t('No users with this action');
	}
}

