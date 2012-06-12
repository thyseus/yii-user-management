<div class="view">

	<b><? echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<? echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('varname')); ?>:</b>
	<? echo CHtml::encode($data->varname); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<? echo CHtml::encode($data->title); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('field_type')); ?>:</b>
	<? echo CHtml::encode($data->field_type); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('field_size')); ?>:</b>
	<? echo CHtml::encode($data->field_size); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('field_size_min')); ?>:</b>
	<? echo CHtml::encode($data->field_size_min); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('required')); ?>:</b>
	<? echo CHtml::encode($data->required); ?>
	<br />

	<? /*
	<b><? echo CHtml::encode($data->getAttributeLabel('match')); ?>:</b>
	<? echo CHtml::encode($data->match); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('range')); ?>:</b>
	<? echo CHtml::encode($data->range); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('error_message')); ?>:</b>
	<? echo CHtml::encode($data->error_message); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('other_validator')); ?>:</b>
	<? echo CHtml::encode($data->other_validator); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('default')); ?>:</b>
	<? echo CHtml::encode($data->default); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<? echo CHtml::encode($data->position); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('visible')); ?>:</b>
	<? echo CHtml::encode($data->visible); ?>
	<br />

	*/ ?>

</div>
