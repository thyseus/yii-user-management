<div class="view">

	<b><? echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<? echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<? echo CHtml::encode($data->language); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('text_email_registration')); ?>:</b>
	<? echo CHtml::encode($data->text_email_registration); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('text_email_recovery')); ?>:</b>
	<? echo CHtml::encode($data->text_email_recovery); ?>
	<br />

	<b><? echo CHtml::encode($data->getAttributeLabel('text_email_activation')); ?>:</b>
	<? echo CHtml::encode($data->text_email_activation); ?>
	<br />


</div>
