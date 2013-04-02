<?
/**
 * Base controller class
 * @author tomasz.suchanek
 * @since 0.6
 * @package Yum.core
 *
 */

abstract class YumController extends CController {
	public $breadcrumbs = array();
	public $menu = array();
	public $title ='';
	public $_model;

	protected function performAjaxValidation($model, $form) {
		if(isset($_POST['ajax']) && $_POST['ajax'] == $form) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function beforeAction($action) {
		if(Yum::module()->enableOnlineStatus && !Yii::app()->user->isGuest)
			Yii::app()->user->data()->setLastAction();

		if(!isset(Yii::app()->cache))
			throw new CHttpException(500, 'Please enable a caching component for yii-user-management to work.');

		return parent::beforeAction($action);
	}

	public function loadModel($model = false) {
		if(!$model)
			$model = str_replace('Controller', '', get_class($this));

		if($this->_model === null) {
			if(isset($_GET['id']))
				$this->_model = CActiveRecord::model($model)->findByPk($_GET['id']);

			if($this->_model===null && !is_numeric($_GET['id']))
				@$this->_model = CActiveRecord::model($model)->find(
						'name = :name', array(':name' => $_GET['id']));

			if($this->_model===null)
				throw new CHttpException(404,
						Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	public function renderMenu() {
		if(Yii::app()->user->isAdmin())
			$this->widget('YumAdminMenu');
		else if(!Yii::app()->user->isGuest)
			$this->widget('YumUserMenu');
	}

	public function filters()
	{
		return array(
			'accessControl',
		);
	}	
}
?>
