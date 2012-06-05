<?php
/**
 * This function implements the RESTful Api features of yii-user-management
 * @since 0.8rc2 
 **/
class YumRestController extends CController	
{
	public function beforeAction($action) {

		if(!Yum::module()->enableRESTapi) 
			throw new CHttpException(404);	
		else if($this->_checkAuth()) 
			return parent::beforeAction($action);
		else
			throw new CHttpException(403);	
	}

	public function actionUpdate($mode, $id)
	{

		switch($mode)
		{
			case 'user':
				$model = YumUser::model()->findByPk($id);
				break;
			default:
		}

		parse_str(file_get_contents('php://input'), $put_vars);

		if($model instanceof YumUser) {
			foreach($put_vars as $key => $value)
				if($model->hasAttribute($key))
					$model->$key = $value;

			if($model->save())
				$this->_sendResponse(200, 
						CJSON::encode($model));	
			else {
				$msg = "<h1>Error</h1>";
				$msg .= sprintf("Couldn't update %s", $mode);
				$msg .= "<ul>";
				foreach($model->errors as $attribute => $attr_errors) {
					$msg .= "<li>Attribute: $attribute</li>";
					$msg .= "<ul>";
					foreach($attr_errors as $attr_error)
						$msg .= "<li>$attr_error</li>";
					$msg .= "</ul>";
				}
			}
		}
	}

	public function actionCreate($mode)
	{
		switch($mode)
		{
			case 'user':
				$model = new YumUser;
				$profile = new YumProfile;
				break;
			default:
		}
		$username = $_POST['username'] or $this->_sendResponse(
				501, 'Username missing');
		$password = $_POST['password'] or $this->_sendResponse(
				501, 'Password missing');

		foreach($_POST as $key => $value)
			if($profile->hasAttribute($key))
				$profile->$key = $value;

		if($profile->validate() && $model->register($username, $password, $profile))
			$this->_sendResponse(200, 
					CJSON::encode(array($model, $profile)));	
		else {
			$msg = "<h1>Error</h1>";
			$msg .= sprintf("Couldn't create %s", $mode);
			$msg .= "<ul>";
			foreach($model->errors as $attribute => $attr_errors) {
				$msg .= "<li>Attribute: $attribute</li>";
				$msg .= "<ul>";
				foreach($attr_errors as $attr_error)
					$msg .= "<li>$attr_error</li>";
				$msg .= "</ul>";
			}

			foreach($profile->errors as $attribute => $attr_errors) {
				$msg .= "<li>Attribute: $attribute</li>";
				$msg .= "<ul>";
				foreach($attr_errors as $attr_error)
					$msg .= "<li>$attr_error</li>";
				$msg .= "</ul>";
			}
			$msg .= "</ul>";
			$this->_sendResponse(500, $msg );

		}
	}
	public function actionView($mode, $id) {
		switch($mode)
		{
			case 'user':
				$result = YumUser::model()->findByPk($id);
				if($result instanceof YumUser)
					$result->password = null; // do not send password for security
				break;
			default:
				$this->_sendResponse(501, sprintf(
							'Error: Mode %s not supported',
							$mode));	
				Yii::app()->end();

		}
		if(is_null($result))
			$this->_sendResponse(404, 'No Item found with id '.$id);
		else
			$this->_sendResponse(200, CJSON::encode($result));
	}

	public function actionList($model) {
		switch($mode)
		{
			case 'users':
				$result = YumUser::model()->findAll();
				foreach($result as $key => $user)
					unset($result[$key]->password); // do not send password for security
				break;
			default:
				$this->_sendResponse(501, sprintf(
							'Error: Mode %s not supported',
							$mode));	
				Yii::app()->end();
		}

		// Did we get some results?
		if(is_null($result)) {
			$this->_sendResponse(200, 
					sprintf('No items where found for mode <b>%s</b>', $mode) );
		} else {
			$this->_sendResponse(200, CJSON::encode($result));
		}
	}

	private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
	{
		// set the status
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);
		// and the content type
		header('Content-type: ' . $content_type);

		// pages with body are easy
		if($body != '')
		{
			// send the body
			echo $body;
			exit;
		}
		// we need to create the body if none is passed
		else
		{
			// create some body messages
			$message = '';

			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}

			// servers don't always have a signature turned on 
			// (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			// this should be templated in a real-world solution
			$body = '
				<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				<title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
				</head>
				<body>
				<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
				<p>' . $message . '</p>
				<hr />
				<address>' . $signature . '</address>
				</body>
				</html>';

			echo $body;
			exit;
		}
	}
	private function _getStatusCodeMessage($status)
	{
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
				200 => 'OK',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				402 => 'Payment Required',
				403 => 'Forbidden',
				404 => 'Not Found',
				500 => 'Internal Server Error',
				501 => 'Not Implemented',
				);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}

	private function _checkAuth() {
		foreach(array('HTTP_X_USERNAME', 'PHP_AUTH_USER') as $var) 
			if(isset($_SERVER[$var]) && $_SERVER[$var] != '')
				$username = $_SERVER[$var];

		foreach(array('HTTP_X_PASSWORD', 'PHP_AUTH_PW') as $var) 
			if(isset($_SERVER[$var]) && $_SERVER[$var] != '')
				$password = $_SERVER[$var];

		if($username && $password) {
			$user = YumUser::model()->find('LOWER(username)=?',array(
						strtolower($username)));

			if(Yum::module()->RESTfulCleartextPasswords 
					&& $user !==null 
					&& $user->superuser 
					&& md5($password) == $user->password)
				return true;

			if(!Yum::module()->RESTfulCleartextPasswords 
					&& $user !==null 
					&& $user->superuser 
					&& $password == $user->password)
				return true;

		}
		$this->_sendResponse(401, 'Error: Username or password is invalid');
	}
}

?>
