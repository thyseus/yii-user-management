<?php
$this->title = Yum::t(ucfirst($user->username) .'\'s friends');
$this->breadcrumbs = array('Friends', $user->username);

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'groups-form',
	'enableAjaxValidation'=>false,
)); 

	
	$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$friends,
	//'filter' => $friends,
		'columns'=>array(
			array(
				'name'=>'id',
				'filter' => false,
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->id),
				array(Yum::route("friendship/update"),"id"=>$data->id))',
			),
			array(
				'name'=>'inviter',
				'filter' => false,
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->inviter->username),
				array(Yum::route("friendship/update"),"id"=>$data->id))',
			),
				array(
				'name'=>'invited',
				'filter' => false,
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->invited->username),
				array(Yum::route("friendship/update"),"id"=>$data->id))',
			),
			array(
				'name'=>'status',
				'filter' => false,
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->getStatus()),
				array(Yum::route("friendship/update"),"id"=>$data->id))',
			),
			
			array(
				'class'=>'CButtonColumn',
			),
)));

/*
if($friends) {
	echo '<table>';
	echo '<th></th></th><th>Username</th><th>Status</th>';

	foreach($friends as $friend) {
		switch ($friend->status)
		{
			case 1:
			if($friend->inviter_id == Yii::app()->user->id)
			{
			echo CHtml::activeHiddenField($friend,'friendship_id',array('value'=>$friend->id)); 
			$avatar=null;
			$avatar=CHtml::image(Yii::app()->baseurl . '/users/images/' . $friend->invited->avatar);
			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
			$avatar,
			CHtml::link($friend->invited->username, Yii::app()->createUrl('user/profile/view',array('id'=>$friend->invited->id))),
			$friend->getStatus(), 
			CHtml::submitButton('Cancel Friend Request',array('id'=>'cancel_request','name'=>'YumFriendship[cancel_request]')));
		}else{
			echo CHtml::activeHiddenField($friend,'friendship_id',array('value'=>$friend->id)); 
			$avatar=null;
			$avatar=CHtml::image(Yii::app()->baseurl . '/users/images/' . $friend->inviter->avatar);
			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
			$avatar,
			CHtml::link($friend->inviter->username, Yii::app()->createUrl('user/profile/view',array('id'=>$friend->inviter->id))),
			$friend->getStatus(), 
			CHtml::submitButton('Add',array('id'=>'add_request','name'=>'YumFriendship[add_request]')),
			CHtml::submitButton('Ignore',array('id'=>'ignore_request','name'=>'YumFriendship[ignore_request]')),
			CHtml::submitButton('Deny',array('id'=>'deny_request','name'=>'YumFriendship[deny_request]')));
		}
			break;
			
			case 2:
			if($friend->inviter_id == Yii::app()->user->id)
			{
			echo CHtml::activeHiddenField($friend,'friendship_id',array('value'=>$friend->id)); 
			$avatar=null;
			$avatar=CHtml::image(Yii::app()->baseurl . '/users/images/' . $friend->invited->avatar);
			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
			$avatar,
			CHtml::link($friend->invited->username, Yii::app()->createUrl('user/profile/view',array('id'=>$friend->invited->id))),
			$friend->getStatus(), 
			CHtml::submitButton('Remove Friend',array('id'=>'remove_friend','name'=>'YumFriendship[remove_friend]')));
			}else{
			echo CHtml::activeHiddenField($friend,'friendship_id',array('value'=>$friend->id)); 
			$avatar=null;
			$avatar=CHtml::image(Yii::app()->baseurl . '/users/images/' . $friend->inviter->avatar);
			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
			$avatar,
			CHtml::link($friend->inviter->username, Yii::app()->createUrl('user/profile/view',array('id'=>$friend->inviter->id))),
			$friend->getStatus(), 
			CHtml::submitButton('Remove Friend',array('id'=>'remove_friend','name'=>'YumFriendship[remove_friend]')));
			}
			break;

			
			default:
			
			break;
		}
	}
	
echo '</table>';	
} else {
	echo Yum::t('You do not have any friends yet');
	
}
*/

$this->endWidget();
?>

