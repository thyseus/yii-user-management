<div class="view" style="float: left;margin-right: 10px;">
<?php echo CHtml::link($data->getAvatar(true), array(
			'//avatar/avatar/editAvatar', 'id' => $data->id)); ?> 
<h3> <?php echo CHtml::link($data->username, array(
			'//avatar/avatar/editAvatar', 'id' => $data->id)); ?> </h3>
</div>
