<?php

class YumUsergroupController extends YumController {
	public function accessRules() {
		return array(
				array('allow',  
					'actions'=>array('index','view'),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('getOptions', 'create','update', 'browse', 'join', 'write'),
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

	public function actionWrite() {
		Yii::import('application.modules.usergroup.models.YumUsergroupMessage');
		$message = new YumUsergroupMessage;

		if(isset($_POST['YumUsergroupMessage'])) {
			$message->attributes = $_POST['YumUsergroupMessage'];
			$message->author_id = Yii::app()->user->id;

			$message->save();
		}	

		$this->redirect(array('//usergroup/groups/view',
					'id' => $message->group_id));

	}	

	public function actionJoin($id = null) {
		if($id !== null) {
			$p = YumUsergroup::model()->findByPk($id);

			$participants = $p->participants;
			if(in_array(Yii::app()->user->id, $participants)) {
				Yum::setFlash(Yum::t('You are already participating in this group'));
			} else {
				$participants[] = Yii::app()->user->id;
				$p->participants = $participants;

				if($p->save(array('participants'))) {
					Yum::setFlash(Yum::t('You have joined this group'));
					Yum::log(Yum::t('User {username} joined group id {id}', array(
									'{username}' => Yii::app()->user->data()->username,
									'{id}' => $id)));

				}
			}
			$this->redirect(array('//usergroup/groups/view', 'id' => $id));
		}
	}

	public function actionView($id) {
		$model = $this->loadModel($id);

		$this->render('view',array(
					'model' => $model,
					));
	}

	public function loadModel($id = false)
	{
		if($this->_model === null)
		{
			if(is_numeric($id))	
				$this->_model = YumUsergroup::model()->findByPk($id);
			else if(is_string($id))	
				$this->_model = YumUsergroup::model()->find('title = :title', array(
							':title' => $id));
			if($this->_model === null)
				throw new CHttpException(404,'The requested Usergroup does not exist.');
		}
		return $this->_model;
	}


	public function actionCreate() {
		$model = new YumUsergroup;

		$this->performAjaxValidation($model, 'usergroup-form');

		if(isset($_POST['YumUsergroup'])) {
			$model->attributes = $_POST['YumUsergroup'];
			$model->owner_id = Yii::app()->user->id;
			$model->participants = array($model->owner_id);

			if($model->save()) 
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array( 'model'=>$model));
	}


	public function actionUpdate()
	{
		$model = $this->loadModel();

		$this->performAjaxValidation($model, 'usergroup-form');

		if(isset($_POST['YumUsergroup']))
		{
			$model->attributes = $_POST['YumUsergroup'];


			if($model->save()) {

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

	public function actionIndex($owner_id = null)
	{
		$criteria = new CDbCriteria;

		if($owner_id != null) {
			$uid = Yii::app()->user->id;
			$criteria->addCondition( array(
						'condition' => "owner_id = {$uid}"));
		}

		$dataProvider=new CActiveDataProvider('YumUsergroup', array(
					'criteria' => $criteria)
				);

		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionBrowse()
	{
		$model=new YumUsergroup('search');
		$model->unsetAttributes();

		if(isset($_GET['YumUsergroup']))
			$model->attributes = $_GET['YumUsergroup'];

		$this->render('browse',array(
					'model'=>$model,
					));
	}

	public function actionAdmin()
	{
		$model=new YumUsergroup('search');
		$model->unsetAttributes();

		if(isset($_GET['YumUsergroup']))
			$model->attributes = $_GET['YumUsergroup'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}

}
