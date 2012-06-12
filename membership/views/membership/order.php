<? $this->breadcrumbs = array(Yum::t('Membership'));?>

<? $this->title = Yum::t('Membership'); ?>
	
	<div class="form">
		<? $form=$this->beginWidget('CActiveForm', array(
		'id'=>'membership-has-company-form',
			'enableAjaxValidation'=>true,
			)); 
			echo $form->errorSummary($model);
		?>

		<div class="row">
		
			<? echo CHtml::activeRadioButtonList($model, 'membership_id', 
			CHtml::listData(YumRole::model()->findAll('price != 0'), 'id', 'description'),
			array('template' => '<div style="float:left;margin-right:5px;">{input}</div>{label}'));
			?>
			<div class="clear"></div>
		</div>
		<br />
		<div class="row">
			<? echo $form->labelEx($model,'payment_id'); ?> <br />
			<? echo CHtml::activeRadioButtonList($model, 'payment_id', 
			CHtml::listData(YumPayment::model()->findAll(), 'id', 'title'),
			array('template' => '<div style="float:left;margin-right:5px;">{input}</div>{label}'));
			?>
			<div class="clear"></div>
		</div>
		<? echo $form->error($model,'membership_id'); ?>

	<?
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
	<?
    Yii::app()->clientScript->registerScript('toggle', "
		$('#detail-information').hide();	  
		$('#more-information').click(function() {
	   	$('#detail-information').fadeToggle('slow');
	   });
    ");
    ?>
	<? $this->endWidget(); ?>
