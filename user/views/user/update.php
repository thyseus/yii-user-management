<div class="container">
<div class="row">
<div class="span12">


<?php
	$this->title=Yum::t('Update user')." ".$user->username;
	$this->pageTitle=Yum::t('Update user')." ".$user->username;

	$this->breadcrumbs = array(
			Yum::t('Users')=>array('index'),
			$user->username=>array('view','id'=>$user->id),
			Yum::t('Update'));

echo $this->renderPartial('/user/_form', array(
			'user'=>$user,
			'passwordform'=>$passwordform,
			'changepassword' => isset($changepassword) ? $changepassword : false,
			'profile'=>$profile,
		));
?>
</div>
</div>
</div>
