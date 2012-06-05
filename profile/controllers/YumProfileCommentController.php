<?php
Yii::import('application.modules.user.models.*');

class YumProfileCommentController extends YumController
{
	public function accessRules()
	{
		return array(
				array('allow',  
					'actions'=>array('index'),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('create', 'delete'),
					'users'=>array('@'),
					),
				array('allow', 
					'actions'=>array('admin'),
					'users'=>array('admin'),
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionCreate() {
		$model = new YumProfileComment;

		$this->performAjaxValidation($model, 'profile-comment-form');

		if(isset($_POST['YumProfileComment'])) {
			$model->attributes = $_POST['YumProfileComment'];
			$model->save();
			}

		if(isset($model->profile->user) && $user = $model->profile->user)
			$this->renderPartial(Yum::module('profile')->profileView, array(
						'model'=>$user
						), false, true);
	}


	public function actionDelete($id) {
		$comment = YumProfileComment::model()->findByPk($id);

		if($comment->user_id == Yii::app()->user->id
				|| $comment->profile_id == Yii::app()->user->id) {
			$comment->delete();
			$this->redirect(array(Yum::module()->profileView, 'id' => $comment->profile->user_id));
		} else
			throw new CHttpException(400,
					Yum::t('You are not the owner of this Comment or this Profile!'));
	}

	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('ProfileComment');
		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionAdmin() {
		$model=new ProfileComment('search');
		$model->unsetAttributes();

		if(isset($_GET['ProfileComment']))
			$model->attributes = $_GET['ProfileComment'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

}
