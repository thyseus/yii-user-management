<?php if($profile && !$profile->isNewRecord && $profile->getPublicFields()) { ?>
<table class="table_profile_fields">
<?php foreach($profile->getPublicFields() as $field) { ?>

	<tr>
	<th class="label"> <?php echo Yum::t($field->title); ?> </th> 
	<td> <?php echo $profile->{$field->varname}; ?> </td>
	</tr>

<?php } ?>
</table>
<?php } ?>

<div class="clear"></div>
