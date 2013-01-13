<?php
$this->title = Yum::t('Browse user groups');
$this->breadcrumbs=array(
	Yum::t('Groups'),
	Yum::t('Browse'));

$form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

<div class="search-form">
        <div class="row">
                <?php echo $form->label($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        </div>
        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div>

<?php
 $this->widget('zii.widgets.CListView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	'itemView' => '_view',
	));
?>
