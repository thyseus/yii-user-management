<?
// This unit test tests, if the Registration and Activation process provided 
// by Yum works

Yii::import('application.modules.user.models.*');
Yii::import('application.modules.user.controllers.*');

class RegistrationTest extends CDbTestCase
{
    public $fixtures=array();

		public function testRegistration() {
			Yii::app()->controller = new YumRegistrationController('registration');

			$user = new YumRegistrationForm;

			$user->username = 'no whitespaces allowed';
			$this->assertFalse($user->validate());

			$user->username = 'allowed';
			$user->password = 'notthesame';
			$user->password = 'emasehtton';
			$this->assertFalse($user->validate());

			$user->setAttributes(array(
					'username' => 'A_Testuser',
					'password' => 'hiddenpassword1', 
					'verifyPassword' => 'hiddenpassword1', 
					));
			$this->assertTrue($user->validate());

			$profile = new YumRegistrationForm;
			$profile->setAttributes(array(
					'firstname' => 'My first Name !"§$%&/()=',
					'lastname' => 'My last Name !"§$%&/()=<? die() ?>',
					'password' => 'hiddenpassword1', 
					'verifyPassword' => 'hiddenpassword1', 

					));
			$profile->setAttributes($user->getAttributes());
			$this->assertTrue($profile->validate());

			// it is good that $_POST is bloated here because we want to test if
			// only safe Attributes are being assigned:
			$_POST['YumRegistrationForm'] = $user->getAttributes();
			$_POST['YumProfile'] = $profile->getAttributes();
			
		}
}
