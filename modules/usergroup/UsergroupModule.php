<?php
Yii::setPathOfAlias('UsergroupModule' , dirname(__FILE__));

class UsergroupModule extends CWebModule {
	public $usergroupTable = '{{usergroup}}';
	public $usergroupMessageTable = '{{usergroup_message}}';
	public $userparticipationTable = '{{user_usergroup}}';

	public $adminLayout = 'user.user.views.layouts.yum';
	public $layout = 'user.user.views.layouts.yum';

	public $controllerMap=array(
			'groups'=>array(
				'class'=>'UsergroupModule.controllers.YumUsergroupController'),
			);

	public function init() {
		$this->setImport(array(
					'user.user.controllers.*',
					'user.user.models.*',
					'user.usergroup.controllers.*',
					'user.usergroup.models.*',
					));
	}


}
