<?php
Yii::import('application.modules.user.controllers.YumController');
Yii::import('application.modules.user.models.Yum');
Yii::import('application.modules.role.models.*');
Yii::import('application.modules.membership.models.*');

class YumMembershipController extends YumController {
	public $defaultAction = 'index';

	public function accessRules() {
		return array(
				array('allow', 
					'actions'=>array('index', 'order', 'extend'),
					'users'=>array('@'),
					),
				array('allow', 
					'actions'=>array('admin','delete', 'update', 'view', 'orders'),
					'expression' => 'Yii::app()->user->isAdmin()',
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionView()
	{
		return false;
	}

	public function actionExtend() {
		$membership = YumMembership::model()->findByPk($_POST['membership_id']);
		if(!$membership)
			throw new CHttpException(404);

		if($membership->user_id != Yii::app()->user->id)
			throw new CHttpException(403);

		$subscription = $_POST['subscription'];
		$membership->subscribed = $subscription == 'cancel' ? -1 : $subscription;
		$membership->save(false, array('subscribed'));
		Yum::setFlash('Your subscription setting has been saved');
		$this->redirect(Yum::module('membership')->membershipIndexRoute);
	}

	public function actionUpdate($id = null) {
		if($id !== null) 
			$model = YumMembership::model()->findByPk($id);

		if(isset($_POST['YumMembership'])) {
			$model = YumMembership::model()->findByPk($_POST['YumMembership']['id']); 
			$model->attributes = $_POST['YumMembership'];
			if($model->confirmPayment()) 
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
					'model'=>$model,
					));
	}

	public function actionOrder()
	{
		$model = new YumMembership;

		if(isset($_POST['YumMembership'])) {
			$model->attributes = $_POST['YumMembership'];
			if($model->save()) {
				$this->redirect(array('index'));
			}
		}

		$this->render('order',array( 'model'=>$model));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
			{
				if(isset($_POST['returnUrl']))
					$this->redirect($_POST['returnUrl']); 
				else
					$this->redirect(array('admin'));
			}
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('YumMembership', array(
					'criteria' => array(
						'condition' => 'user_id = '.Yii::app()->user->id),
					));

		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionOrders()
	{
		$model=new YumMembership('search');
		$model->unsetAttributes();

		if(isset($_GET['YumMembership']))
			$model->attributes = $_GET['YumMembership'];

		$this->render('orders',array(
					'model'=>$model,
					));
	}

	public function actionAdmin() {
		$this->layout = Yum::module()->adminLayout;

		$model=new YumMembership('search');
		$model->unsetAttributes();

		if(isset($_GET['YumMembership']))
			$model->attributes = $_GET['YumMembership'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

}
