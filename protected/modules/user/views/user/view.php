<?
$profiles = Yum::hasModule('profile');

if(Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL & $profiles)
$this->title = Yum::t('View user "{email}"',array(
			'{email}'=>$model->profile->email));
else
$this->title = Yum::t('View user "{username}"',array(
			'{username}'=>$model->username));

$this->breadcrumbs = array(Yum::t('Users') => array('index'), $model->username);

echo Yum::renderFlash();

if(Yii::app()->user->isAdmin()) {
	$attributes = array(
			'id',
			);

	if(!Yum::module()->loginType & UserModule::LOGIN_BY_EMAIL)
		$attributes[] = 'username';

	if($profiles && $model->profile) 
		foreach(YumProfile::getProfileFields() as $field) 
			array_push($attributes, array(
						'label' => Yum::t($field),
						'type' => 'raw',
						'value' => $model->profile->getAttribute($field)
						));

	array_push($attributes,
		/*
		There is no added value to showing the password/salt/activationKey because 
		these are all encrypted 'password', 'salt', 'activationKey',*/
		array(
			'name' => 'createtime',
			'value' => date(UserModule::$dateFormat,$model->createtime),
			),
		array(
			'name' => 'lastvisit',
			'value' => date(UserModule::$dateFormat,$model->lastvisit),
			),
		array(
			'name' => 'lastpasswordchange',
			'value' => date(UserModule::$dateFormat,$model->lastpasswordchange),
			),
		array(
			'name' => 'superuser',
			'value' => YumUser::itemAlias("AdminStatus",$model->superuser),
			),
		array(
			'name' => Yum::t('Activation link'),
			'value' =>$model->getActivationUrl()),
		array(
				'name' => 'status',
			'value' => YumUser::itemAlias("UserStatus",$model->status),
			)
		);

	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>$attributes,
				));

} else {
	// For all users
	$attributes = array(
			'username',
			);

	if($profiles) {
		$profileFields = YumProfile::getProfileFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				array_push($attributes,array(
							'label' => Yum::t($field),
							'name' => $field,
							'value' => $model->profile->getAttribute($field),
							));
			}
		}
	}

	array_push($attributes,
			array(
				'name' => 'createtime',
				'value' => date(UserModule::$dateFormat,$model->createtime),
				),
			array(
				'name' => 'lastvisit',
				'value' => date(UserModule::$dateFormat,$model->lastvisit),
				)
			);

	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>$attributes,
				));
}


if(Yum::hasModule('role') && Yii::app()->user->isAdmin()) {
	Yii::import('application.modules.role.models.*');
	echo '<h2>'.Yum::t('This user belongs to these roles:') .'</h2>';

	if($model->roles) {
		echo "<ul>";
		foreach($model->roles as $role) {
			echo CHtml::tag('li',array(),CHtml::link(
						$role->title,array('//role/role/view','id'=>$role->id)),true);
		}
		echo "</ul>";
	} else {
		printf('<p>%s</p>', Yum::t('None'));
	}
}

if(Yii::app()->user->isAdmin()) {
	echo CHtml::link(Yum::t('User administration'), 
			array('//user/user/admin'), array(
				'class' => 'btn'));

	echo CHtml::link(Yum::t('Update User'), 
			array('user/update', 'id' => $model->id), array(
				'class' => 'btn'));

}

if(Yum::hasModule('profile'))
echo CHtml::link(Yum::t('Visit profile'), array(
			'//profile/profile/view', 'id' => $model->id), array(
'class' => 'btn'));


	?>
