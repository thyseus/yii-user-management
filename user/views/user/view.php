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

	if($profiles) {
		$profileFields = YumProfileField::model()->forOwner()->findAll();
		if ($profileFields && $model->profile) {
			foreach($profileFields as $field) {
				array_push($attributes, array(
							'label' => Yum::t($field->title),
							'type' => 'raw',
							'value' => is_array($model->profile)
							? $model->profile->getAttribute($field->varname)
							: $model->profile->getAttribute($field->varname) ,
							));
			}
		}
	}

	array_push($attributes,
		/*
		There is no added value to showing the password/salt/activationKey because 
		these are all encrypted 'password', 'salt', 'activationKey',*/
		array(
			'name' => 'createTime',
			'value' => date(UserModule::$dateFormat,$model->createTime),
			),
		array(
			'name' => 'lastVisit',
			'value' => date(UserModule::$dateFormat,$model->lastVisit),
			),
		array(
			'name' => 'lastPasswordChange',
			'value' => date(UserModule::$dateFormat,$model->lastPasswordChange),
			),
		array(
			'name' => 'superUser',
			'value' => YumUser::itemAlias("AdminStatus",$model->superUser),
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
		$profileFields = YumProfileField::model()->forAll()->findAll();
		if ($profileFields) {
			foreach($profileFields as $field) {
				array_push($attributes,array(
							'label' => Yii::t('UserModule.user', $field->title),
							'name' => $field->varname,
							'value' => $model->profile->getAttribute($field->varname),
							));
			}
		}
	}

	array_push($attributes,
			array(
				'name' => 'createTime',
				'value' => date(UserModule::$dateFormat,$model->createTime),
				),
			array(
				'name' => 'lastVisit',
				'value' => date(UserModule::$dateFormat,$model->lastVisit),
				)
			);

	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>$attributes,
				));
}


if(Yum::hasModule('role') && Yii::app()->user->isAdmin()) {
	Yii::import('YumModulesRoot.role.models.*');
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

if(Yii::app()->user->isAdmin())
	echo CHtml::Button(
			Yum::t('Update User'), array(
				'submit' => array('user/update', 'id' => $model->id)));

	if(Yum::hasModule('profile'))
	echo CHtml::Button(
			Yum::t('Visit profile'), array(
				'submit' => array('//profile/profile/view', 'id' => $model->id)));


	?>
