<?php
if(Yum::module()->rtepath != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rtepath);
if(Yum::module()->rteadapter != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rteadapter);

if($profile)
	foreach(YumProfile::getProfileFields() as $field) {
		echo CHtml::openTag('div',array());

		echo $form->labelEx($profile, $field);
		echo $form->textField($profile, $field);
		echo $form->error($profile,$field);

		echo CHtml::closeTag('div');
	}
?>
