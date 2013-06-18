<?php
if(Yum::module()->rtepath != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rtepath);                                                                         
if(Yum::module()->rteadapter != false)
	Yii::app()->clientScript-> registerScriptFile(Yum::module()->rteadapter); 

if($profile)
	foreach(YumProfile::getProfileFields() as $field) {
		echo CHtml::openTag('div',array());

		echo CHtml::activeLabelEx($profile, $field);
		echo CHtml::activeTextField($profile,
				$field);
		echo CHtml::error($profile,$field); 

		echo CHtml::closeTag('div');
	}
?>
