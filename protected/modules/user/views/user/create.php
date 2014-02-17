<?php
$this->title = Yum::t("Create user");
$this->pageTitle = Yum::t("Create user");
$this->breadcrumbs = array(
		Yum::t('Users') => array('index'),
		Yum::t('Create'));

echo $this->renderPartial('_form', array(
			'user'=>$user,
			'passwordform'=>$passwordform,
			'profile'=>isset($profile) ? $profile : null)); ?>
