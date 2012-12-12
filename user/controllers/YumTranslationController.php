<?php

class YumTranslationController extends YumController
{
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				);
	}

	public function accessRules()
	{
		return array(
				array('allow', 
					'actions'=>array('create','update', 'admin', 'delete'),
					'expression' => Yii::app()->user->isAdmin()
					),
				array('deny',  // deny all users
					'users'=>array('*'),
					),
				);
	}

	public function actionCreate() {
		$this->actionUpdate();	
	}

	public function actionUpdate($category = null, $message = null, $language = null)
	{
		$models = array();
			foreach(Yum::getAvailableLanguages() as $language) {
				$models[] = $this->loadModel($category, $message, $language);
			}

		if(isset($_POST['YumTranslation']))
		{
			$category = $_POST['YumTranslation']['category'];
			$message = $_POST['YumTranslation']['message'];

			foreach($_POST as $key => $translation) {
				if(substr($key, 0, 11) == 'translation') {
					$lang = explode('_', $key);
					if(isset($lang[1])) {
						$lang = $lang[1];
						foreach(Yum::getAvailableLanguages() as $language) {
							if($language == $lang) {
								$model = YumTranslation::model()->find(
										'category = :category and message = :message and language = :language ', array(
											':category' => $category,
											':message' => $message,
											':language' => $lang));
								if(!$model)
									$model = new YumTranslation();

								if($translation != '') {
									$model->message = $message;
									$model->category = $category;
									$model->translation = $translation;
									$model->language = $lang;	
									$model->save();
								}
							}
						}
					}
				}
			}
			Yum::setFlash('Translations have been saved');
			$this->redirect(array('admin'));
		}

		$this->render('update',array(
					'models'=>$models,
					));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAdmin()
	{
		$model=new YumTranslation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['YumTranslation']))
			$model->attributes=$_GET['YumTranslation'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

	public function loadModel($category, $message, $language = null)
	{
		$model=YumTranslation::model()->find('category = :category and message = :message and language = :language', array(
					':category' => $category,
					':message' => $message,
					':language' => $language));

		if($model===null) {
			$translation = new YumTranslation;
			$translation->category = $category;
			$translation->message = $message;
			$translation->language = $language;
			return $translation;
		}
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='translation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
