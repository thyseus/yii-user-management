<?php

class YumInstallController extends YumController
{
	public $layout = 'install';
	public $defaultAction = 'install';

	public function accessRules()
	{
		return array(
			array('allow',
			      'actions' => array(
				      'index, start, installer, installation, install, index'),
			      'users' => array('@')),
		);
	}

	public function actionStart()
	{
		$this->actionInstall();
	}

	public function actionInstaller()
	{
		$this->actionInstall();
	}

	public function actionInstallation()
	{
		$this->actionInstall();
	}

	public function actionInstall()
	{
		if ($this->module->debug === true) {
			if (Yii::app()->request->isPostRequest) {
				// A associative array containing the tables to be created.
				$createdTables = array();
				if ($db = Yii::app()->db) {
					$sql = 'set FOREIGN_KEY_CHECKS = 0;';
					$db->createCommand($sql)->execute();

					$transaction = $db->beginTransaction();

					$tables = array(
						'userTable',
						'privacySettingTable',
						'profileTable',
						'profileCommentTable',
						'profileVisitTable',
						'membershipTable',
						'paymentTable',
						'messageTable',
						'roleTable',
						'userRoleTable',
						'permissionTable',
						'friendshipTable',
						'actionTable',
						'usergroupTable',
						'usergroupMessageTable',
						'translationTable');

					/*
					 * Hey, we're dropping your tables. Did anyone said 'backups'?
					 */
					foreach ($tables as $table) {
						if (isset($_POST[$table])) {
							${$table} = $_POST[$table];

							// Clean up existing Installation table-by-table
							$db->createCommand(sprintf('DROP TABLE IF EXISTS %s',
							                           ${$table}))->execute();

						}
					}

					// Create User Table
					$sql = "CREATE TABLE IF NOT EXISTS `" . $userTable . "` (
						`id` int unsigned NOT NULL auto_increment,
						`username` varchar(20) NOT NULL,
						`password` varchar(128) NOT NULL,
						`salt` varchar(128) NOT NULL,
						`activationKey` varchar(128) NOT NULL default '',
						`createtime` int(11) NOT NULL default '0',
						`lastvisit` int(11) NOT NULL default '0',
						`lastaction` int(11) NOT NULL default '0',
						`lastpasswordchange` int(11) NOT NULL default '0',
						`failedloginattempts` int(11) NOT NULL default '0',
						`superuser` int(1) NOT NULL default '0',
						`status` int(1) NOT NULL default '0',
						`avatar` varchar(255) default NULL,
						`notifyType` enum('None', 'Digest', 'Instant', 'Threshold') default 'Instant',
						PRIMARY KEY  (`id`),
						UNIQUE KEY `username` (`username`),
						KEY `status` (`status`),
						KEY `superuser` (`superuser`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

					$db->createCommand($sql)->execute();
					$createdTables['user']['userTable'] = $userTable;

					// Create messages translation table
					$sql = "CREATE TABLE IF NOT EXISTS `{$translationTable}` (
						`message` varbinary(255) NOT NULL,
						`translation` varchar(255) NOT NULL,
						`language` varchar(5) NOT NULL,
						`category` varchar(255) NOT NULL,
						PRIMARY KEY (`message`,`language`,`category`)
							) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

					$db->createCommand($sql)->execute();
					$createdTables['user']['translationTable'] = $translationTable;

					// Insert the translation strings that come with yum
					$sql = file_get_contents(Yii::getPathOfAlias(
								'application.modules.user.docs') . '/yum_translation.sql');

					$db->createCommand($sql)->execute();

					// Install Usergroups submodule
					if (isset($_POST['installUsergroup'])) {
						$sql = "CREATE TABLE IF NOT EXISTS `" . $usergroupTable . "` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`owner_id` int(11) NOT NULL,
							`participants` text NULL,
							`title` varchar(255) NOT NULL,
							`description` text NOT NULL,
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

						$db->createCommand($sql)->execute();
						$createdTables['usergroup']['usergroupTable'] = $usergroupTable;

						$sql = "CREATE TABLE IF NOT EXISTS `" . $usergroupMessageTable . "` (
							`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
							`author_id` int(11) unsigned NOT NULL,
							`group_id` int(11) unsigned NOT NULL,
							`createtime` int(11) unsigned NOT NULL,
							`title` varchar(255) NOT NULL,
							`message` text NOT NULL,
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

						$db->createCommand($sql)->execute();
						$createdTables['usergroup']['usergroupMessageTable'] = $usergroupMessageTable;
					}

					// Install Membership Management submodule
					if (isset($_POST['installMembership'])) {
						$sql = "CREATE TABLE IF NOT EXISTS `{$membershipTable}` (
							`id` int(11) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
							`membership_id` int(11) NOT NULL,
							`user_id` int(11) NOT NULL,
							`payment_id` int(11) NOT NULL,
							`order_date` int(11) NOT NULL,
							`end_date` int(11) DEFAULT NULL,
							`name` varchar(255) DEFAULT NULL,
							`street` varchar(255) DEFAULT NULL,
							`zipcode` varchar(255) DEFAULT NULL,
							`city` varchar(255) DEFAULT NULL,
							`payment_date` int(11) NULL,
							`subscribed` tinyint(1) NOT NULL 
								) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000;";

						$db->createCommand($sql)->execute();
						$createdTables['membership']['membershipTable'] = $membershipTable;

						$sql = " CREATE TABLE IF NOT EXISTS `{$paymentTable}` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`title` varchar(255) NOT NULL,
							`text` text,
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ";
						$db->createCommand($sql)->execute();
						$createdTables['membership']['paymentTable'] = $paymentTable;
					}

					// Install Friendship submodule
					if (isset($_POST['installFriendship'])) {
						$sql = "CREATE TABLE  `" . $friendshipTable . "` (
							`inviter_id` int(11) NOT NULL,
							`friend_id` int(11) NOT NULL,
							`status` int(11) NOT NULL,
							`acknowledgetime` int(11) DEFAULT NULL,
							`requesttime` int(11) DEFAULT NULL,
							`updatetime` int(11) DEFAULT NULL,
							`message` varchar(255) NOT NULL,
							PRIMARY KEY (`inviter_id`, `friend_id`)
						) ENGINE = INNODB;";

						$db->createCommand($sql)->execute();
						$createdTables['friendship']['friendshipTable'] = $friendshipTable;
					}

					// Install Profiles submodule
					if (isset($_POST['installProfiles'])) {
						$sql = "CREATE TABLE IF NOT EXISTS `" . $privacySettingTable . "` (
							`user_id` int unsigned NOT NULL,
							`message_new_friendship` tinyint(1) NOT NULL DEFAULT 1,
							`message_new_message` tinyint(1) NOT NULL DEFAULT 1,
							`message_new_profilecomment` tinyint(1) NOT NULL DEFAULT 1,
							`appear_in_search` tinyint(1) NOT NULL DEFAULT 1,
							`show_online_status` tinyint(1) NOT NULL DEFAULT 1,
							`log_profile_visits` tinyint(1) NOT NULL DEFAULT 1,
							`ignore_users` varchar(255),
							`public_profile_fields` bigint(15) unsigned,
							PRIMARY KEY (`user_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

						$db->createCommand($sql)->execute();
						$createdTables['profile']['privacySettingTable'] = $privacySettingTable;

						// Create Profiles Table
						$sql = "CREATE TABLE IF NOT EXISTS `" . $profileTable . "` (
							`id` int unsigned NOT NULL auto_increment,
							`user_id` int unsigned NOT NULL,
							`lastname` varchar(50) NOT NULL default '',
							`firstname` varchar(50) NOT NULL default '',
							`email` varchar(255) NOT NULL default '',
							`street` varchar(255),
							`city` varchar(255),
							`about` text,
							PRIMARY KEY  (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

						$db->createCommand($sql)->execute();
						$createdTables['profile']['profileTable'] = $profileTable;

						$sql = "CREATE TABLE IF NOT EXISTS `" . $profileCommentTable . "` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`user_id` int(11) NOT NULL,
							`profile_id` int(11) NOT NULL,
							`comment` text NOT NULL,
							`createtime` int(11) NOT NULL,
							PRIMARY KEY (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

						$db->createCommand($sql)->execute();
						$createdTables['profile']['profileCommentTable'] = $profileCommentTable;

						$sql = "CREATE TABLE IF NOT EXISTS `" . $profileVisitTable . "` (
							`visitor_id` int(11) NOT NULL,
							`visited_id` int(11) NOT NULL,
							`timestamp_first_visit` int(11) NOT NULL,
							`timestamp_last_visit` int(11) NOT NULL,
							`num_of_visits` int(11) NOT NULL,
							PRIMARY KEY (`visitor_id`,`visited_id`)
						) ENGINE=InnoDB;";

						$db->createCommand($sql)->execute();
						$createdTables['profile']['profileVisitTable'] = $profileVisitTable;
					}

					// Install Role Management submodule
					if (isset($_POST['installRole'])) {
						// Create Roles Table
						$sql = "CREATE TABLE IF NOT EXISTS `" . $roleTable . "` (
							`id` INT unsigned NOT NULL AUTO_INCREMENT ,
							`title` VARCHAR(255) NOT NULL ,
							`description` VARCHAR(255) NULL,
							`membership_priority` int(11) NULL DEFAULT NULL,
							`price` double COMMENT 'Price (when using membership module)',
							`duration` int COMMENT 'How long a membership is valid',
							PRIMARY KEY (`id`)
						) ENGINE = InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ";

						$db->createCommand($sql)->execute();
						$createdTables['role']['roleTable'] = $roleTable;

						// Create User_has_role Table
						$sql = "CREATE TABLE IF NOT EXISTS `" . $userRoleTable . "` (
							`user_id` int unsigned NOT NULL,
							`role_id` int unsigned NOT NULL,
							PRIMARY KEY (`user_id`, `role_id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

						$db->createCommand($sql)->execute();
						$createdTables['role']['userRoleTable'] = $userRoleTable;

						// Install permission support (at the end will it be a submodule?)
						if (isset($_POST['installPermission'])) {
							$sql = "CREATE TABLE IF NOT EXISTS `" . $actionTable . "` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`title` varchar(255) NOT NULL,
							`comment` text,
							`subject` varchar(255) DEFAULT NULL,
							PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ";

							$db->createCommand($sql)->execute();
							$createdTables['role']['actionTable'] = $actionTable;

							$sql = "CREATE TABLE IF NOT EXISTS `" . $permissionTable . "` (
							`principal_id` int(11) NOT NULL,
							`subordinate_id` int(11) NULL,
							`type` enum('user','role') NOT NULL,
							`action` int(11) NOT NULL,
							`template` tinyint(1) NOT NULL,
							`comment` text,
							PRIMARY KEY (`principal_id`,`subordinate_id`,`type`,`action`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8; ";

							$db->createCommand($sql)->execute();
							$createdTables['role']['permissionTable'] = $permissionTable;
						}
					}

					// Install Messages submodule
					if (isset($_POST['installMessages'])) {
						// Create Messages Table
						$sql = "CREATE TABLE IF NOT EXISTS `" . $messageTable . "` (
							`id` int unsigned NOT NULL auto_increment,
							`timestamp` int unsigned NOT NULL,
							`from_user_id` int unsigned NOT NULL,
							`to_user_id` int unsigned NOT NULL,
							`title` varchar(255) NOT NULL,
							`message` text,
							`message_read` tinyint(1) NOT NULL,
							`answered` tinyint(1),
							`draft` tinyint(1) default NULL,
							PRIMARY KEY  (`id`)
						) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

						$db->createCommand($sql)->execute();
						$createdTables['message']['messageTable'] = $messageTable;
					}

					// Generate demo data
					$salt1 = YumEncrypt::generateSalt();
					$salt2 = YumEncrypt::generateSalt();
					$sql = "INSERT INTO `" . $userTable
					   ."` (`id`, `username`, `password`, `salt`, `activationKey`, `createtime`, `lastvisit`, `superuser`, `status`) VALUES "
					   ."(1, 'admin', '" . YumEncrypt::encrypt('admin', $salt1) . "', '" . $salt1 . "', '', " . time() . ", 0, 1, 1),"
					   ."(2, 'demo', '" . YumEncrypt::encrypt('demo', $salt2) . "', '" . $salt2 . "', '', " . time() . ", 0, 0, 1)";
					$db->createCommand($sql)->execute();

					if (isset($_POST['installMembership'])) {
						$sql = "INSERT INTO `{$paymentTable}` (`title`) VALUES ('Prepayment'), ('Paypal')";

						$db->createCommand($sql)->execute();
					}

					if (isset($_POST['installRole']) && isset($_POST['installPermission'])) {
						$sql = "INSERT INTO `" . $actionTable . "` (`title`) VALUES "
							."('message_write'),"
							."('message_receive'),"
							."('user_create'),"
							."('user_update'),"
							."('user_remove'),"
							."('user_admin')";

						$db->createCommand($sql)->execute();

						$sql = "INSERT INTO `{$permissionTable}` (`principal_id`, `subordinate_id`, `type`, `action`, `template`, `comment`) VALUES "
							."(2, 0, 'role', 1, 0, 'Users can write messages'),"
							."(2, 0, 'role', 2, 0, 'Users can receive messages'),"
							."(2, 0, 'role', 3, 0, 'Users are able to view visits of his profile'),"
							."(1, 0, 'role', 4, 0, ''),"
							."(1, 0, 'role', 5, 0, ''),"
							."(1, 0, 'role', 6, 0, ''),"
							."(1, 0, 'role', 7, 0, '');";

						$db->createCommand($sql)->execute();

						$sql = "INSERT INTO `" . $roleTable . "` (`title`,`description`, `membership_priority`, `price`, `duration`) VALUES "
							."('UserManager', 'These users can manage Users', 0, 0, 0),"
							."('Demo', 'Users having the demo role', 0, 0, 0),"
							."('Business', 'Example Business account', 1, 9.99, 7),"
							."('Premium', 'Example Premium account', 2, 19.99, 28) ";
						$db->createCommand($sql)->execute();

						$sql = "INSERT INTO `" . $userRoleTable . "` (`user_id`, `role_id`) VALUES (2, 3)";

						$db->createCommand($sql)->execute();
					}

					if (isset($_POST['installProfiles'])) {
						$sql = "INSERT INTO `" . $privacySettingTable . "` (`user_id`) values (2)";
						$db->createCommand($sql)->execute();

						$sql = "INSERT INTO `" . $profileTable . "` (`id`, `user_id`, `lastname`, `firstname`, `email`) VALUES "
							."(1, 1, 'admin','admin','webmaster@example.com'),"
							."(2, 2, 'demo','demo','demo@example.com')";
						$db->createCommand($sql)->execute();

					}

					// Do it
					$transaction->commit();

					// Victory
					$this->render('success', array('modules' => $createdTables));
				}
				else
				{
					throw new CException(Yum::t('Database connection is not working'));
				}
			}
			else {
				if(Yii::app()->db->getSchema()->getTable('user'))
					throw new CHttpException(403, Yum::t(
								'Yii-user-management is already installed. Please remove it manually to continue'));

				$this->render('start', array(
					'userTable' => 'user',
					'roleTable' => 'role',
					'privacySettingTable' => 'privacysetting',
					'translationTable' => 'translation',
					'membershipTable' => 'membership',
					'paymentTable' => 'payment',
					'messageTable' => 'message',
					'profileTable' => 'profile',
					'profileCommentTable' => 'profile_comment',
					'profileVisitTable' => 'profile_visit',
					'userRoleTable' => 'user_role',
					'usergroupTable' => 'usergroup',
					'usergroupMessageTable' => 'user_group_message',
					'permissionTable' => 'permission',
					'friendshipTable' => 'friendship',
					'actionTable' => 'action',
				));
			}
		} else {
			throw new CException(Yum::t('User management module is not in Debug Mode'));
		}
	}

	public function actionIndex()
	{
		$this->actionInstall();
	}
}
