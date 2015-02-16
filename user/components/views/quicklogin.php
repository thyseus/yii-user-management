	<?php echo CHtml::beginForm(array('/user/auth')); 
    
    $link = '//' .
    Yii::app()->controller->uniqueid .
    '/' . Yii::app()->controller->action->id;
    echo CHtml::hiddenField('quicklogin', $link);
    ?>
    
        <?php echo CHtml::errorSummary($model); ?>
        
        <div class="row">
        	 <div class="span12">
				<?php echo CHtml::activeLabelEx($model,'username'); ?>
                <?php echo CHtml::activeTextField($model,'username', array('size' => 10)) ?>
              </div>
        </div>
        
        <div class="row" style="padding-top:12px;">
        	 <div class="span12">
            <?php echo CHtml::activeLabelEx($model,'password'); ?>
            <?php echo CHtml::activePasswordField($model,'password', array('size' => 10)); ?>
            </div>
        </div>
        
        <div class="row" style="font-size:10px;">
         <div class="span12">
			<?php
			if(Yum::hasModule('registration') 
					&& Yum::module('registration')->enableRecovery)
			echo CHtml::link(Yum::t('Lost password?'), 
				Yum::module('registration')->recoveryUrl); ?>
			</div>
            </div>
        
        <div class="row submit">
        	 <div class="span12">
            <?php echo CHtml::submitButton(Yum::t('Login')); ?>
            </div>
        </div>
        
    <?php echo CHtml::endForm(); ?>
