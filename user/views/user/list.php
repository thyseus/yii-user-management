<?php
$this->title=Yii::t('UserModule.user','User list');
?>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('username')); ?>:
<?php echo CHtml::encode($model->username); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('password')); ?>:
<?php echo CHtml::encode($model->password); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:
<?php echo CHtml::encode($model->email); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('activationKey')); ?>:
<?php echo CHtml::encode($model->activationKey); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('createtime')); ?>:
<?php echo CHtml::encode($model->createtime); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>:
<?php echo CHtml::encode($model->lastvisit); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('superuser')); ?>:
<?php echo CHtml::encode($model->superuser); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('status')); ?>:
<?php echo CHtml::encode($model->status); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
