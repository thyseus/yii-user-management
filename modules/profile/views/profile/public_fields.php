<?php if($profile && !$profile->isNewRecord && $profile->getProfileFields()) { ?>
<table class="table_profile_fields">
<?php foreach($profile->getProfileFields() as $field) { ?>
	<tr>
	<th class="label"> <?php echo Yum::t($field); ?> </th> 
	<td> <?php echo $profile->$field; ?> </td>
	</tr>

<?php } ?>
</table>
<?php } ?>

<div class="clear"></div>
