<?
$this->title=Yii::t('UserModule.user','User list');
?>

<? $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<? foreach($models as $n=>$model): ?>
<div class="item">
<? echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<? echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('username')); ?>:
<? echo CHtml::encode($model->username); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('password')); ?>:
<? echo CHtml::encode($model->password); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('email')); ?>:
<? echo CHtml::encode($model->email); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('activationKey')); ?>:
<? echo CHtml::encode($model->activationKey); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('createtime')); ?>:
<? echo CHtml::encode($model->createtime); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('lastvisit')); ?>:
<? echo CHtml::encode($model->lastvisit); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('superuser')); ?>:
<? echo CHtml::encode($model->superuser); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('status')); ?>:
<? echo CHtml::encode($model->status); ?>
<br/>

</div>
<? endforeach; ?>
<br/>
<? $this->widget('CLinkPager',array('pages'=>$pages)); ?>
