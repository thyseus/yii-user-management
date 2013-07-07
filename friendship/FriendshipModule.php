<?php
Yii::setPathOfAlias('FriendshipModule' , dirname(__FILE__));

class FriendshipModule extends CWebModule {
	public $friendshipTable = '{{friendship}}';

	public $controllerMap=array(
			'friendship'=>array(
				'class'=>'FriendshipModule.controllers.YumFriendshipController'),
			);

}
