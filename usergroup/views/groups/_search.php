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
                <? echo $form->label($model,'owner_id'); ?>
                <? echo $form->textField($model,'owner_id'); ?>
        </div>
    
        <div class="row">
                <? echo $form->label($model,'title'); ?>
                <? echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        </div>
    
        <div class="row">
                <? echo $form->label($model,'description'); ?>
                <? echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        </div>
    
        <div class="row buttons">
                <? echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<? $this->endWidget(); ?>

</div><!-- search-form -->
