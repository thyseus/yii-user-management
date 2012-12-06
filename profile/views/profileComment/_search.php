<div class="wide form">

<? $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <? echo $form->label($model,'id'); ?>
                <? echo $form->textField($model,'id'); ?>
        </div>
    
        <div class="row">
                <? echo $form->label($model,'user_id'); ?>
                <? echo $form->textField($model,'user_id'); ?>
        </div>
    
        <div class="row">
                <? echo $form->label($model,'profile_id'); ?>
                <? echo $form->textField($model,'profile_id'); ?>
        </div>
    
        <div class="row">
                <? echo $form->label($model,'comment'); ?>
                <? echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
        </div>
    
        <div class="row">
                <? echo $form->label($model,'createtime'); ?>
                <? echo $form->textField($model,'createtime'); ?>
        </div>
    
        <div class="row buttons">
                <? echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<? $this->endWidget(); ?>

</div><!-- search-form -->
