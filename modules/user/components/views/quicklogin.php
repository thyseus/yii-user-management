	<?php echo CHtml::beginForm(array('/user/auth')); 
    
    $link = '//' .
    Yii::app()->controller->uniqueid .
    '/' . Yii::app()->controller->action->id;
    echo CHtml::hiddenField('quicklogin', $link);
    ?>
    
        <?php echo CHtml::errorSummary($model); ?>
        
        <div class="row">
            <?php echo CHtml::activeLabelEx($model,'username'); ?>
            <?php echo CHtml::activeTextField($model,'username', array('size' => 10)) ?>
        </div>
        
        <div class="row" style="padding-top:12px;">
            <?php echo CHtml::activeLabelEx($model,'password'); ?>
            <?php echo CHtml::activePasswordField($model,'password', array('size' => 10)); ?>
        </div>
        
        <div class="row" style="font-size:10px;">
			<?php
			if(Yum::hasModule('registration') 
					&& Yum::module('registration')->enableRecovery)
			echo CHtml::link(Yum::t('Lost password?'), 
				Yum::module('registration')->recoveryUrl); ?>
			</div>
        
        <div class="row submit">
            <?php echo CHtml::submitButton(Yum::t('Login')); ?>
        </div>
        
    <?php echo CHtml::endForm(); ?>
