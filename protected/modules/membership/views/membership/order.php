<?php $this->breadcrumbs = array(Yum::t('Membership'));?>

<?php $this->title = Yum::t('Membership'); ?>
	
	<div class="form">
		<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'membership-has-company-form',
			'enableAjaxValidation'=>true,
			)); 
			echo $form->errorSummary($model);
		?>

		<div class="row">
		
			<?php echo CHtml::activeRadioButtonList($model, 'membership_id', 
			CHtml::listData(YumRole::model()->findAll('price != 0'), 'id', 'description'),
			array('template' => '<div style="float:left;margin-right:5px;">{input}</div>{label}'));
			?>
			<div class="clear"></div>
		</div>
		<br />
		<div class="row">
			<?php echo $form->labelEx($model,'payment_id'); ?> <br />
			<?php echo CHtml::activeRadioButtonList($model, 'payment_id', 
			CHtml::listData(YumPayment::model()->findAll(), 'id', 'title'),
			array('template' => '<div style="float:left;margin-right:5px;">{input}</div>{label}'));
			?>
			<div class="clear"></div>
		</div>
		<?php echo $form->error($model,'membership_id'); ?>

	<?php
		echo CHtml::submitButton(Yum::t('Order membership'));
		
	?>
	</div> <!-- form -->
	
	<div style="padding:20px 60px 60px;">
		<div class="more-info" id="more-information">mehr Informationen</div>
		<div id="detail-information" style="display:none;">
			<div class="membership-header"></div>
			<div class="clear"></div>
			<div class="membership-details"></div>
			<div class="membership-content"></div>
		</div>
	</div>
	<?php
    Yii::app()->clientScript->registerScript('toggle', "
		$('#detail-information').hide();	  
		$('#more-information').click(function() {
	   	$('#detail-information').fadeToggle('slow');
	   });
    ");
    ?>
	<?php $this->endWidget(); ?>
