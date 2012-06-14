<? if($profile && !$profile->isNewRecord && $profile->getPublicFields()) { ?>
<table class="table_profile_fields">
<? foreach($profile->getPublicFields() as $field) { ?>

	<tr>
	<th class="label"> <? echo Yum::t($field->title); ?> </th> 
	<td> <? echo $profile->{$field->varname}; ?> </td>
	</tr>

<? } ?>
</table>
<? } ?>

<div class="clear"></div>
