<div class="view" style="float: left;margin-right: 10px;">
<? echo CHtml::link($data->getAvatar(true), array(
			'//avatar/avatar/editAvatar', 'id' => $data->id)); ?> 
<h3> <? echo CHtml::link($data->username, array(
			'//avatar/avatar/editAvatar', 'id' => $data->id)); ?> </h3>
</div>
