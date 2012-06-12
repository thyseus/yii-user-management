<?
$this->breadcrumbs=array(
	Yum::t('Groups'),
	Yum::t('Browse'));

?>
<h1> <? echo Yum::t('Browse user groups'); ?> </h1>

<? $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

<div class="search-form">
        <div class="row">
                <? echo $form->label($model,'title'); ?>
                <? echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        </div>
        <div class="row buttons">
                <? echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<? $this->endWidget(); ?>

</div>

<?
 $this->widget('zii.widgets.CListView', array(
	'id'=>'usergroup-grid',
	'dataProvider'=>$model->search(),
	'itemView' => '_view',
	)); 
?>
