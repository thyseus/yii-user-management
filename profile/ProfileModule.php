<?php
Yii::setPathOfAlias('ProfileModule' , dirname(__FILE__));

class ProfileModule extends CWebModule {
	public $layout = 'yumprofile';

	// set this to true to allow all users to access user profiles
	public $profilesViewableByGuests = false;

	public $enableProfileVisitLogging = true;
	public $enablePrivacySetting = true;
	public $enableProfileComments = true;

	public $profileTable = '{{profile}}';
	public $privacySettingTable = '{{privacysetting}}';
	public $profileCommentTable = '{{profile_comment}}';
	public $profileVisitTable = '{{profile_visit}}';
	public $profileFieldTable = '{{profile_field}}';
	public $profileFieldGroupTable = '{{profile_fields_group}}';

	public $profileView = '/profile/view';

	public $publicFieldsView =
		'application.modules.profile.views.profile.public_fields';
	public $profileCommentView =
		'application.modules.profile.views.profileComment._view';
	public $profileCommentIndexView =
		'application.modules.profile.views.profileComment.index';
	public $profileCommentCreateView =
		'application.modules.profile.views.profileComment.create';
  public $profileEditView = '/profile/update';
  public $privacySettingView= '/privacy/update';

	public $controllerMap=array(
			'comments'=>array(
				'class'=>'ProfileModule.controllers.YumProfileCommentController'),
			'privacy'=>array(
				'class'=>'ProfileModule.controllers.YumPrivacysettingController'),
			'groups'=>array(
				'class'=>'ProfileModule.controllers.YumUsergroupController'),
			'profile'=>array(
				'class'=>'ProfileModule.controllers.YumProfileController'),
			'fields'=>array(
				'class'=>'ProfileModule.controllers.YumFieldsController'),
			'fieldsgroup'=>array(
				'class'=>'ProfileModule.controllers.YumFieldsGroupController'),
			);

	public function init() {
		$this->setImport(array(
			'application.modules.user.controllers.*',
			'application.modules.user.models.*',
			'ProfileModule.components.*',
			'ProfileModule.models.*',
		));
	}
}
