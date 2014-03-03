<?php

Yii::import('zii.widgets.CPortlet');

class YumAdminMenu extends CPortlet {
	public function init() {
		$this->title = sprintf('%s: %s',
				Yum::t('Logged in as'),
				Yii::app()->user->data()->username);
		$this->contentCssClass = 'menucontent';
		return parent::init();
	}

	public function run() {
		$this->widget('YumMenu', array(
					'items' => $this->getMenuItems()
					));

		parent::run();
	}

	public function getMenuItems() {
		return array(
				array('label'=>'Users', 
					'items' => array(
						array('label'=> 'Statistics', 'url'=>array('//user/statistics/index')),
						array('label' => 'User Administration', 'url' => array('//user/user/admin')),
						array('label' => 'Avatar administration', 'url' => array('//avatar/avatar/admin'), 'visible' => Yum::hasModule('avatar')),
						array('label' => 'Create new User', 'url' => array('//user/user/create')),
						array('label' => 'Generate Demo Data', 'url' => array('//user/user/generateData'), 'visible' => Yum::module()->debug),
						)
					),
				array(
					'label'=>'Roles / Access control',
					'active' => Yii::app()->controller->id == 'role' || Yii::app()->controller->id == 'permission' || Yii::app()->controller->id == 'action', 'visible' => Yum::hasModule('role'), 'items' => array(
						array('label' => 'Roles', 'url' => array('//role/role/admin')),
						array('label' => 'Create new role', 'url' => array('//role/role/create')),
						array('label' => 'Permissions', 'url' => array('//role/permission/admin')),
						array('label' => 'Grant permission', 'url' => array('//role/permission/create')),
						array('label' => 'Actions', 'url' => array('//role/action/admin')),
						array('label' => 'Create new action', 'url' => array('//role/action/create')),
						)
					),
				array('label'=>'Membership',
						'visible' => Yum::hasModule('membership'), 'items' => array(
							array('label' => 'Ordered memberships', 'url' => array('//membership/membership/admin')),
							array('label' => 'Payment types', 'url' => array('//membership/payment/admin')),
							array('label' => 'Create new payment type', 'url' => array('//membership/payment/create')),
							)
						),
				array('label'=>'Profiles',
						'visible' => Yum::hasModule('profile'),
						'items' => array(
							array('label' => 'Manage profiles', 'url' => array('//profile/profile/admin')),
							array('label' => 'Show profile visits', 'url' => array('//profile/profile/visits')),
							)
						),
				array('label' => 'Messages',
						'visible' => Yum::hasModule('message'),
						'items' => array (
							array('label' => 'Admin inbox', 'url' => array('/message/message/index')),
							array('label' => 'Sent messages', 'url' => array('/message/message/sent')),
							array('label' => 'Write a message', 'url' => array('/message/message/compose')),
							),
						),
				array('label' => 'Misc',
						'items' => array(
							array('label' => 'Text translations', 'url' => array('//user/translation/admin')),
							array('label' => 'Upload avatar for admin', 'url' => array('//avatar/avatar/editAvatar'),
								'visible' => Yum::hasModule('avatar')),
							array('label' => 'Change admin Password', 'url' => array('//user/user/changePassword')),
							array('label' => 'Logout', 'url' => array('//user/user/logout')),
							)
						),
				);

	}
}
?>






