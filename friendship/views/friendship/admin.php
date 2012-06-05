<?php
$this->title = Yum::t('Friendship administration');
$this->breadcrumbs = array('Friends', 'Admin');

printf('<p>%s</p>', Yum::t('All friendships in the system'));

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$friendships,
	'enableSorting' => true,
	'enablePagination' => true,
	'filter' => new YumFriendship(),
	'columns' => array(
		array(
			'header' => Yum::t('User'),
			'name' => 'inviter_id',
			'value' => '$data->inviter->username'),
		array(
			'header' => Yum::t('is friend of'),
			'name' => 'friend_id',
			'value' => '$data->invited->username'),
		array(
			'header' => Yum::t('Requesttime'),
			'name' => 'requesttime',
			'value' => 'date(Yum::module()->dateTimeFormat, $data->requesttime)'),
		array(
			'header' => Yum::t('Acknowledgetime'),
			'name' => 'acknowledgetime',
			'value' => 'date(Yum::module()->dateTimeFormat, $data->acknowledgetime)'),
		array(
			'header' => Yum::t('Last update'),
			'name' => 'updatetime',
			'value' => 'date(Yum::module()->dateTimeFormat, $data->updatetime)'),
		array(
			'header' => Yum::t('Status'),
			'name' => 'status',
			'value' => '$data->getStatus()'),


		))); 

?>

