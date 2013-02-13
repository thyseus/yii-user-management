<?
Yii::setPathOfAlias('AvatarModule' , dirname(__FILE__));

class AvatarModule extends CWebModule {
	public $defaultController = 'avatar';

	public $enableGravatar = true;

	// enable gravatar automatically for new registered users?
	public $enableGravatarDefault = true;

	// override this with your custom layout, if available
	public $adminLayout = 'application.modules.user.views.layouts.yum';
	public $layout = 'application.modules.user.views.layouts.yum';

	public $avatarPath = 'images';

	// Set avatarMaxWidth to a value other than 0 to enable image size check
	public $avatarMaxWidth = 0;

	public $avatarThumbnailWidth = 50; // For display in user browse, friend list
	public $avatarDisplayWidth = 200;


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
