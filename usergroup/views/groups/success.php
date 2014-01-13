<?php 
echo Yum::t('The Usergroup {groupname} has been successfully created', array('groupname' => $model))
?>

<?php 
echo CHtml::Button(Yum::t('Back'), array('id' => $relation.'_done')); 
echo CHtml::Button(Yum::t('Add another Usergroup'), array('id' => $relation.'_create'));
