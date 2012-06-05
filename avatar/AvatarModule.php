<?php
Yii::setPathOfAlias('AvatarModule' , dirname(__FILE__));

class AvatarModule extends CWebModule {
	public $defaultController = 'avatar';

	// override this with your custom layout, if available
	public $layout = 'application.modules.user.views.layouts.yum';

	public $avatarPath = 'images';

	// Set avatarMaxWidth to a value other than 0 to enable image size check
	public $avatarMaxWidth = 0;

	public $avatarThumbnailWidth = 50; // For display in user browse, friend list
	public $avatarDisplayWidth = 200;

	public $enableGravatar = true;

	public $controllerMap=array(
		'avatar'=>array('class'=>'AvatarModule.controllers.YumAvatarController'),
	);

	public function init() {
		$this->setImport(array(
					'application.modules.user.controllers.*',
					'application.modules.user.models.*',
					'application.modules.avatar.controllers.*',
					'application.modules.avatar.models.*',
					));
	}



}
