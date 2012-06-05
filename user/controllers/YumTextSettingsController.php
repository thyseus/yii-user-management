<?php

class YumTextSettingsController extends YumController {

	public function accessRules()
	{
		return array(
				array('allow', 
					'actions'=>array('admin','delete', 'create', 'update', 'view','index'),
					'expression' => 'Yii::app()->user->isAdmin()'
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionView()
	{
		$this->render('/textsettings/view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$model=new YumTextSettings;

		foreach($_POST as $key => $value) {
			if(is_array($value))
				$_SESSION[$key] = $value;
		}

		if(isset($_SESSION['YumTextSettings'])) 
			$model->attributes = $_SESSION['YumTextSettings'];

		$this->performAjaxValidation($model, 'yum-text-settings-form');

		$YumTextSettingsData = Yii::app()->request->getPost('YumTextSettings');
		if($YumTextSettingsData !== null)
		{
			$model->attributes = $YumTextSettingsData;


			if($model->save()) {
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('/textsettings/create',array(
			'model' => $model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model, 'yum-text-settings-form');

		$YumTextSettingsData = Yii::app()->request->getPost('YumTextSettings');
		if($YumTextSettingsData !== null)
		{
			$model->attributes = $YumTextSettingsData;


			if($model->save())
			{
				$this->redirect(array('view','id'=>$model->id));
			}}

			$this->render('/textsettings/update',array(
						'model'=>$model,
						));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(Yii::app()->request->getQuery('ajax') === null)
			{
				$returnUrl = Yii::app()->request->getPost('returnUrl');
				$this->redirect(!empty($returnUrl) ? $returnUrl : array('admin'));
			}
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	public function actionAdmin()
	{
		$model=new YumTextSettings('search');

		$YumTextSettingsData = Yii::app()->request->getQuery('YumTextSettings');
		if($YumTextSettingsData !== null)
			$model->attributes = $YumTextSettingsData;

		$this->render('/textsettings/admin',array(
			'model' => $model,
		));
	}

}
