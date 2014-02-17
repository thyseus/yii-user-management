<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'user_id'); ?>
                <?php echo $form->textField($model,'user_id'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'profile_id'); ?>
                <?php echo $form->textField($model,'profile_id'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'comment'); ?>
                <?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'createtime'); ?>
                <?php echo $form->textField($model,'createtime'); ?>
        </div>
    
        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
