<?
Yii::setPathOfAlias('UsergroupModule' , dirname(__FILE__));
Yii::setPathOfAlias('YumModule' , dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'user');

class UsergroupModule extends CWebModule {
	public $usergroupTable = 'usergroup';
	public $usergroupMessageTable = 'usergroup_message';
	public $userparticipationTable = 'user_usergroup';

	public $adminLayout = 'application.modules.user.views.layouts.yum';
	public $layout = 'application.modules.user.views.layouts.yum';

	public $controllerMap=array(
			'groups'=>array(
				'class'=>'UsergroupModule.controllers.YumUsergroupController'),
			);

	public function init() {
		$this->setImport(array(
					'YumModule.controllers.*',
					'YumModule.models.*',
					'YumModulegroup.controllers.*',
					'YumModulegroup.models.*',
					));
	}


}
