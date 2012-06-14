<? 
$this->breadcrumbs = array(Yum::t('Data Generation'));

if(isset($_POST['user_amount'])) {
	echo '<h2> Success </h2>';
	printf('<p> <strong> %d </strong> %s been generated. The associated password is <em>%s</em> </p>',
			$_POST['user_amount'],
			$_POST['user_amount'] == 1 ? 'User has' : 'Users have',
			$_POST['password']
			);
	echo '<br />';
}

echo CHtml::beginForm();

echo '<h2> Random user Generator </h2>';
printf('Generate %s %s users <br />
		belonging to role %s <br />
		with associated password %s',
		CHtml::textField('user_amount', '1', array('size' => 2)),
		CHtml::dropDownList('status', 1, array(
				'-1' => Yum::t('banned'),
				'0' => Yum::t('inactive'),
				'1' => Yum::t('active'))),
		Yum::hasModule('role') ? 
		CHtml::dropDownList('role', '', CHtml::listData(
				YumRole::model()->findAll(), 'id', 'title')) : ' - ',
		CHtml::textField('password', 'Demopassword123')
		);

echo '<br />';
echo CHtml::submitButton(Yum::t('Generate'));
echo CHtml::endForm();
?>
