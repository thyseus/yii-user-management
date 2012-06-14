<?

Yii::import('application.modules.user.controllers.YumController');
Yii::import('application.modules.user.models.*');
Yii::import('application.modules.profile.models.*');

class YumProfileController extends YumController {
	public $_model;

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'admin', 'visits'),
				'expression' => 'Yii::app()->user->isAdmin()'
				),
			array('allow',
				'actions'=>array('view', 'update', 'edit'),
				'users' => array('@'),
				),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdate($id = null) {
		if(!$id)
			$id = Yii::app()->user->id;

		$user = $this->loadModel($id);
		$profile = $user->profile;

		if(isset($_POST['YumUser']) || isset($_POST['YumProfile'])) {
			$user->attributes=@$_POST['YumUser'];
			$profile->attributes = @$_POST['YumProfile'];
			$profile->user_id = $user->id;


			$profile->validate();
			$user->validate();

			if(!$user->hasErrors() && !$profile->hasErrors()) {
				if($user->save() && $profile->save()) {
					Yum::setFlash('Your changes have been saved');
					$this->redirect(array('//profile/profile/view', 'id'=>$user->id));
				}
			}
		}

		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial(Yum::module('profile')->profileEditView,array(
						'user'=>$user,
						'profile'=>$profile,
						));
		else
			$this->render(Yum::module('profile')->profileEditView,array(
						'user'=>$user,
						'profile'=>$profile,
						));
	}

	public function actionVisits() {
		$this->layout = Yum::module()->adminLayout;

		$this->render('visits',array(
			'model'=>new YumProfileVisit(),
		));

	}

	public function beforeAction($action) {
		if(!isset($this->layout))
			$this->layout = Yum::module('profile')->layout;
		return parent::beforeAction($action);
	}

	public function loadModel($id = null) {
		if(!$id)
			$id = Yii::app()->user->id;

		if(is_numeric($id))
			return $this->_model = YumUser::model()->findByPk($id);
		else if(is_string($id))
			return $this->_model = YumUser::model()->find("username = '{$id}'");
	}

	public function actionView($id = null) {
		if(!Yum::module('profile')->profilesViewableByGuests 
				&& Yii::app()->user->isGuest)
			throw new CHttpException(403);

		// If no profile id is provided, take myself
		if(!$id)
			$id = Yii::app()->user->id;

		$view = Yum::module('profile')->profileView;

		$this->loadModel($id);
		$this->updateVisitor(Yii::app()->user->id, $id);

		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial($view, array(
						'model' => $this->_model), false, true);
		else
			$this->render($view, array(
						'model' => $this->_model), false, true);

	}

	public function updateVisitor($visitor_id, $visited_id) {
		if(!Yum::module('profile')->enableProfileVisitLogging)
			return false;

		// If the user does not want to log his profile visits, cancel here
		if(Yum::module('profile')->enableProfileVisitLogging
				&& isset(Yii::app()->user->data()->privacy) 
				&& !Yii::app()->user->data()->privacy->log_profile_visits)
			return false;
			
		// Visiting my own profile doesn't count as visit
		if($visitor_id == $visited_id)
			return true;

		$visit = YumProfileVisit::model()->find(
				'visitor_id = :visitor_id and visited_id = :visited_id', array(
					':visitor_id' => $visitor_id,
					':visited_id' => $visited_id));
		if($visit) {
			$visit->save();
		} else {
			$visit = new YumProfileVisit();
			$visit->visitor_id = $visitor_id;
			$visit->visited_id = $visited_id;
			$visit->save();
		}
	}

	public function actionIndex()
	{
		if(Yii::app()->user->isAdmin())
			$this->actionAdmin();
		else
			$this->redirect('view');
	}

	public function actionAdmin()
	{
		$this->layout = Yum::module()->adminLayout;
		$model = new YumProfile;

		$dataProvider=new CActiveDataProvider('YumProfile', array(
			'pagination'=>array(
				'pageSize'=>Yum::module()->pageSize,
			),
			'sort'=>array(
				'defaultOrder'=>'id',
			),
		));

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,'model'=>$model,
		));
	}
}
