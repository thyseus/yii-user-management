	<? echo CHtml::beginForm(array('/user/auth')); 
    
    $link = '//' .
    Yii::app()->controller->uniqueid .
    '/' . Yii::app()->controller->action->id;
    echo CHtml::hiddenField('quicklogin', $link);
    ?>
    
        <? echo CHtml::errorSummary($model); ?>
        
        <div class="row">
            <? echo CHtml::activeLabelEx($model,'username'); ?>
            <? echo CHtml::activeTextField($model,'username', array('size' => 10)) ?>
        </div>
        
        <div class="row" style="padding-top:12px;">
            <? echo CHtml::activeLabelEx($model,'password'); ?>
            <? echo CHtml::activePasswordField($model,'password', array('size' => 10)); ?>
        </div>
        
        <div class="row" style="font-size:10px;">
			<?
			if(Yum::hasModule('registration') 
					&& Yum::module('registration')->enableRecovery)
			echo CHtml::link(Yum::t('Lost password?'), 
				Yum::module('registration')->recoveryUrl); ?>
			</div>
        
        <div class="row submit">
            <? echo CHtml::submitButton(Yum::t('Login')); ?>
        </div>
        
    <? echo CHtml::endForm(); ?>
