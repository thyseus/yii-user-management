<p> The Payment <? echo $model; ?> has been successfully created </p>

<? echo CHtml::Button(Yii::t('app', 'Back'), array('id' => $relation.'_done')); ?><? echo CHtml::Button(Yii::t('app', 'Add another Payment'), array('id' => $relation.'_create'));
