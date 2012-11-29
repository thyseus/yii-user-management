<div class="miniform">
<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'yum-user-form',
	'enableAjaxValidation'=>true,
)); 
	if(isset($_POST['returnUrl']))
		echo CHtml::hiddenField('returnUrl', $_POST['returnUrl']);
	echo $form->errorSummary($model);
?>
<table>
<tr>
<td><? echo $form->labelEx($model,'username') ?></td>
<td><? echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)) ?></td>
<td><? echo $form->error($model,'username') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'password') ?></td>
<td><? echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)) ?></td>
<td><? echo $form->error($model,'password') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'activationKey') ?></td>
<td><? echo $form->textField($model,'activationKey',array('size'=>60,'maxlength'=>128)) ?></td>
<td><? echo $form->error($model,'activationKey') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'createTime') ?></td>
<td><? echo $form->textField($model,'createTime') ?></td>
<td><? echo $form->error($model,'createTime') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'lastVisit') ?></td>
<td><? echo $form->textField($model,'lastVisit') ?></td>
<td><? echo $form->error($model,'lastVisit') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'lastPasswordChange') ?></td>
<td><? echo $form->textField($model,'lastPasswordChange') ?></td>
<td><? echo $form->error($model,'lastPasswordChange') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'superUser') ?></td>
<td><? echo $form->textField($model,'superUser') ?></td>
<td><? echo $form->error($model,'superUser') ?></td>
</tr>
<tr>
<td><? echo $form->labelEx($model,'status') ?></td>
<td><? echo $form->textField($model,'status') ?></td>
<td><? echo $form->error($model,'status') ?></td>
</tr>
</table>	
<?
echo CHtml::Button(Yii::t('app', 'Cancel'), array(
			'onClick' => "$('#dialog_yumuser').dialog('close');"));  
echo CHtml::AjaxSubmitButton(Yii::t('app', 'Create'), array(
			'yumuser/miniCreate'), array(
				'update' => "#dialog_yumuser"), array(
				'id' => 'submit_yumuser')); 
$this->endWidget(); 

?></div> <!-- form -->
