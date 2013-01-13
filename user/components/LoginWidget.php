<?php
Yii::import('zii.widgets.CPortlet');

class LoginWidget extends CPortlet
{
	public $view = 'quicklogin';
	public $title = null;
	public function init()
	{
		if($this->title === NULL)
			$this->title=Yii::t('user', 'Login');
		parent::init();
	}

	protected function renderContent()
	{
		$this->render($this->view, array('model' => new YumUserLogin()));
	}
} 
?>
