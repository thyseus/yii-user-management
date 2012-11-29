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
<? echo CHtml::encode($model->getAttributeLabel('createTime')); ?>:
<? echo CHtml::encode($model->createTime); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('lastVisit')); ?>:
<? echo CHtml::encode($model->lastVisit); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('superUser')); ?>:
<? echo CHtml::encode($model->superUser); ?>
<br/>
<? echo CHtml::encode($model->getAttributeLabel('status')); ?>:
<? echo CHtml::encode($model->status); ?>
<br/>

</div>
<? endforeach; ?>
<br/>
<? $this->widget('CLinkPager',array('pages'=>$pages)); ?>
