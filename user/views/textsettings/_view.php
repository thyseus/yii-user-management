<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<?php echo CHtml::encode($data->language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_email_registration')); ?>:</b>
	<?php echo CHtml::encode($data->text_email_registration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_email_recovery')); ?>:</b>
	<?php echo CHtml::encode($data->text_email_recovery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_email_activation')); ?>:</b>
	<?php echo CHtml::encode($data->text_email_activation); ?>
	<br />


</div>
