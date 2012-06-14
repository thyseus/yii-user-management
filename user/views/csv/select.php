<?
$this->breadcrumbs = array(
		Yum::t('Users') => array('//user/user/admin'),
		Yum::t('Csv export'));

echo CHtml::beginForm(array('//user/csv/export')); 

echo CHtml::checkBoxList('profile_fields',
		array(), $profile_fields, array(
			'checkAll' => Yum::t('Select all'),
			));

echo '<br />';
echo '<br />';

echo CHtml::submitButton(Yum::t('Start export'));

echo CHtml::endForm();
?>
