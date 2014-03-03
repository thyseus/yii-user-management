<?php
Yii::import('application.modules.user.UserModule');
Yii::import('zii.widgets.CPortlet');

class ProfileCommentsWidget extends CPortlet
{
	public $decorationCssClass = 'portlet-decoration profilecomments';

	public function init() {
		$this->title = Yum::t('Profile Comments');
		if(Yii::app()->user->isGuest)
			return false;

		parent::init();
	}

	protected function renderContent()
	{
		parent::renderContent();
		if(Yii::app()->user->isGuest)
			return false;

			$user = YumUser::model()->findByPk(Yii::app()->user->id);
			$this->render('profile_comments', array(
						'comments' => Yii::app()->user->data()->profile->recentComments()));
	}
} 
?>
