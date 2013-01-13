<?php
$this->title = Yum::t("Create user");
$this->breadcrumbs = array(
		Yum::t('Users') => array('index'),
		Yum::t('Create'));

echo $this->renderPartial('_form', array(
			'model'=>$model,
			'passwordform'=>$passwordform,
			'profile'=>isset($profile) ? $profile : null)); ?>
