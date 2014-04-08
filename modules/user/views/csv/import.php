<h2> <?php echo Yum::t('User import'); ?>
<?php
echo CHtml::beginForm(array('//user/csv/import'), 'POST', array(
  'enctype' => 'multipart/form-data'));

echo CHtml::fileField('filename', '');

echo CHtml::submitButton(Yum::t('Start import'), array('class' => 'btn'));

echo CHtml::endForm();
?>
