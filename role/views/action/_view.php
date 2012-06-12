<div class="view">

	<b><? echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<? echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<? echo CHtml::encode($data->title); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<? echo CHtml::encode($data->comment); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('subject')); ?>:</b>
	<? echo CHtml::encode($data->subject); ?>
	<br />


</div>