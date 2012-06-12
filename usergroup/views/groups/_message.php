<h3> <? echo $data->title; ?> </h3>

<p> <? echo $data->message; ?> </p>

<? echo CHtml::link(Yum::t('Answer'), '', array(
			'onClick' => "$('#usergroup_answer_".$data->id."').toggle(500)")); ?>

<div style="display:none;" id="usergroup_answer_<? echo $data->id; ?>">
<h3> <? echo Yum::t('Answer to this message'); ?> </h3>
<?
$this->renderPartial('_message_form', array(
			'title' => Yum::t('Re: ') . ' ' . $data->title,
			'group_id' => $data->group_id));
?>

</div>

<hr />
