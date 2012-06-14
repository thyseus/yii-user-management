<?

Yii::import('application.modules.user.controllers.YumController');
Yii::import('application.modules.user.models.*');
Yii::import('application.modules.role.models.*');

class YumActionController extends YumController {

	public function filters() {
		return array(
			'accessControl', 
		);
	}

	public function accessRules() {
		return array(
			array('allow',  
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('create','update'),
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
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$this->layout = Yum::module()->adminLayout;
		$model=new YumAction;

		$this->performAjaxValidation($model, 'action-form');

		if(isset($_POST['YumAction']))
		{
			$model->attributes=$_POST['YumAction'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model, 'action-form');

		if(isset($_POST['YumAction']))
		{
			$model->attributes=$_POST['YumAction'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('YumAction');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$this->layout = Yum::module()->adminLayout;
		$model=new YumAction('search');
		$model->unsetAttributes();  
		if(isset($_GET['YumAction']))
			$model->attributes=$_GET['YumAction'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

}
