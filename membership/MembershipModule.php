<?php
Yii::setPathOfAlias('MembershipModule' , dirname(__FILE__));

class MembershipModule extends CWebModule {
	public $membershipExpiredView = '/membership/membership_expired';

	// set this to false if you do not want to send a confirmation 
	// message to the user that just ordered a membership
	public $confirmOrders = true;

	public $membershipTable = '{{membership}}';
	public $paymentTable = '{{payment}}';

	// override this with your custom layout, if available
	public $layout = 'application.modules.user.views.layouts.yum';


	public $controllerMap=array(
			'payment'=>array(
				'class'=>'MembershipModule.controllers.YumPaymentController'),
			'membership'=>array(
				'class'=>'MembershipModule.controllers.YumMembershipController'),
			);

	public function beforeControllerAction($controller, $action) {
		if(!Yum::hasModule('role'))
			throw new Exception(
					'Using the membership submodule requires the role module activated');

		return parent::beforeControllerAction($controller, $action);
	}
}
