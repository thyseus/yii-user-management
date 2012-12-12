<?php
Yii::setPathOfAlias('UsergroupModule' , dirname(__FILE__));
Yii::setPathOfAlias('YumModulesRoot' , dirname(dirname(__FILE__)));

class UsergroupModule extends CWebModule {
	public $usergroupTable = 'user_group';
	public $usergroupMessageTable = 'user_group_message';

	public $userparticipationTable = 'user_usergroup';

	public $controllerMap=array(
			'groups'=>array(
				'class'=>'UsergroupModule.controllers.YumUsergroupController'),
			);

	public function init() {
		$this->setImport(array(
					'YumModulesRoot.user.controllers.*',
					'YumModulesRoot.user.models.*',
					'UsergroupModule.controllers.*',
					'UsergroupModule.models.*',
					));
	}


}
