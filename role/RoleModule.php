<?php
Yii::setPathOfAlias('RoleModule' , dirname(__FILE__));

class RoleModule extends CWebModule {
	// set useYiiCheckAccess to true to disable Yums own checkAccess routines.
	// Use this when you implement your own access logic or use yum together with
	// SrBAC
	public $useYiiCheckAccess = false;

	public $layout = 'application.modules.user.views.layouts.yum';

	public $roleTable = '{{role}}';
	public $permissionTable = '{{permission}}';
	public $actionTable = '{{action}}';
	public $userRoleTable = '{{user_role}}';

	public $controllerMap=array(
			'action'=>array(
				'class'=>'RoleModule.controllers.YumActionController'),
			'permission'=>array(
				'class'=>'RoleModule.controllers.YumPermissionController'),
			'role'=>array(
				'class'=>'RoleModule.controllers.YumRoleController'),
			);

}
