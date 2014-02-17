<?php
if(Yum::module()->rtepath != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rtepath);                                                                         
if(Yum::module()->rteadapter != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rteadapter); 

if($profile)
	foreach(YumProfile::getProfileFields() as $field) {
		echo CHtml::openTag('div',array());

		echo $form->LabelEx($profile, $field);
		echo $form->TextField($profile,
				$field);
		echo $form->error($profile,$field); 

		echo CHtml::closeTag('div');
	}
?>
