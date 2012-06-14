<div class="view">

	<b><? echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<? echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<? echo CHtml::encode($data->title); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<? echo CHtml::encode($data->text); ?>
	<br />


</div>
