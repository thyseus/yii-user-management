<?php
Yii::setPathOfAlias('UsergroupModule' , dirname(__FILE__));

class UsergroupModule extends CWebModule {
	public $usergroupTable = '{{usergroup}}';
	public $usergroupMessageTable = '{{usergroup_message}}';
	public $userparticipationTable = '{{user_usergroup}}';

	public $adminLayout = 'application.modules.user.views.layouts.yum';
	public $layout = 'application.modules.user.views.layouts.yum';

	public $controllerMap=array(
			'groups'=>array(
				'class'=>'UsergroupModule.controllers.YumUsergroupController'),
			);

	public function init() {
		$this->setImport(array(
					'application.modules.user.controllers.*',
					'application.modules.user.models.*',
					'application.modules.usergroup.controllers.*',
					'application.modules.usergroup.models.*',
					));
	}


}
