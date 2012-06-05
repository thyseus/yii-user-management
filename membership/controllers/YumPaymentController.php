<?php

Yii::import('application.modules.user.controllers.YumController');
Yii::import('application.modules.user.models.*');
Yii::import('application.modules.membership.models.*');

class YumPaymentController extends YumController {

	public function accessRules() {
		return array(
				array('allow',  
					'actions'=>array('index','view'),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('getOptions', 'create','update'),
					'users'=>array('@'),
					),
				array('allow', 
					'actions'=>array('admin','delete'),
					'users'=>array('admin'),
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionView()
	{
		$this->render('view',array(
					'model' => YumPayment::model()->findByPk($_GET['id'])
					));
	}

	public function actionCreate()
	{
		$this->layout = Yum::module()->adminLayout;
		$model = new YumPayment;

		if(isset($_POST['YumPayment'])) {
			$model->attributes = $_POST['YumPayment'];

			if($model->save()) {

					$this->redirect(array('view','id'=>$model->id));
			}
		}

			$this->render('create',array( 'model'=>$model));
	}


	public function actionUpdate()
	{
		$model = $this->loadModel();

		$this->performAjaxValidation($model, 'payment-form');

		if(isset($_POST['YumPayment']))
		{
			$model->attributes = $_POST['YumPayment'];


			if($model->save()) {
				unset($_SESSION['YumPayment']);

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
					'model'=>$model,
					));
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
		$dataProvider=new CActiveDataProvider('YumPayment');
		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionAdmin()
	{
		$this->layout = Yum::module()->adminLayout;
		$model=new YumPayment('search');
		$model->unsetAttributes();

		if(isset($_GET['YumPayment']))
			$model->attributes = $_GET['YumPayment'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

}
