<style type="text/css">
td { vertical-align: top; } 
td td { border: 1px dotted; } 

input { width: 100px; } 
</style>
<div style="width: 800px;">
<h1> Yii User Management Module Installation </h1>

<? echo CHtml::beginForm(array('install')); ?>
	<p> You are about to install the Yii User management Module version
<em><? echo Yii::app()->getModule('user')->version; ?> </em>
 in your Web Application. You require a working database connection to an mysql
Database. Other Databases are not supported at this time. Please make sure 
your Database is Accessible in protected/config/main.php. </p>

	<? if (Yii::app()->db): ?>
	<div class="hint"> Your database connection seems to be working </div>
	<? else: ?>
	<div class="error"> Your database connection <em> doesn't </em> seem to be working </div>
	<? endif; ?>

	<br />
	<h2> Configuration of table Names: </h2>
<table>
	<tr>
	<td>

	<label for="installRole"> User Management </label>
		<p>&nbsp;</p>
	<table>
		<tr>
			<td> Users </td>
			<td> <? echo CHtml::textField('userTable', Yii::app()->db->tablePrefix.$userTable); ?> </td>
		</tr>
			<tr>
				<td> Message translation Table (required) </td>
				<td> <? echo CHtml::textField('translationTable', Yii::app()->db->tablePrefix.$translationTable); ?> </td>
			</tr>
		</table>

	</td>
	<td>
	<label for="installRole"> Role Management submodule </label>
	<? echo CHtml::checkBox('installRole', true); ?>

	<div id="roles">
		<table>
			<tr>
				<td> Roles </td>
				<td> <? echo CHtml::textField('roleTable', Yii::app()->db->tablePrefix.$roleTable); ?> </td>
			</tr>
			<tr>
				<td> Role Assignment </td>
				<td> <? echo CHtml::textField('userRoleTable', Yii::app()->db->tablePrefix.$userRoleTable); ?> </td>
			</tr>
				</table>
	</div>

	</td>
	<td>

	<label for="installMembership"> Membership Management </label>
	<? echo CHtml::checkBox('installMembership', true); ?>

	<div id="membership">
		<table>
			<tr>
				<td> Membership assignment </td>
				<td> <? echo CHtml::textField('membershipTable', Yii::app()->db->tablePrefix.$membershipTable); ?> </td>
			</tr>
			<tr>
				<td> Payment types </td>
				<td> <? echo CHtml::textField('paymentTable', Yii::app()->db->tablePrefix.$paymentTable); ?> </td>
			</tr>
				</table>

	</div>

	</td>
	<td>

	<label for="installPermission"> Permission submodule </label>
	<? echo CHtml::checkBox('installPermission', true); ?>

	<div id="permission">
		<table>
			<tr>
				<td> Permission Assignment </td>
				<td> <? echo CHtml::textField('permissionTable', Yii::app()->db->tablePrefix.$permissionTable); ?> </td>
			</tr>
			<tr>
				<td> Actions </td>
				<td> <? echo CHtml::textField('actionTable', Yii::app()->db->tablePrefix.$actionTable); ?> </td>
			</tr>
				</table>
	</div>

	</td>
	</tr><tr>
	<td>
	<label for="installMessages"> Messages submodule </label>
	<? echo CHtml::checkBox('installMessages', true); ?>
	<div id="messages">
		<table>
			<tr>
				<td> Messages </td>
				<td> <? echo CHtml::textField('messageTable', Yii::app()->db->tablePrefix.$messageTable); ?> </td>
			</tr>
		</table>
	</div>

	</td>
	<td>

	<label for="installMessages"> Usergroups submodule </label>
	<? echo CHtml::checkBox('installUsergroup', true); ?>
	<div id="usergroup">
		<table>
			<tr>
				<td> User groups </td>
				<td> <? echo CHtml::textField('usergroupTable', Yii::app()->db->tablePrefix.$usergroupTable); ?> </td>
			</tr>
			<tr>
				<td> User group messages</td>
				<td> <? echo CHtml::textField('usergroupMessageTable',
                    Yii::app()->db->tablePrefix.$usergroupMessageTable); ?> </td>
				</tr>
		</table>

	</div>
	</td>
	<td>

	<label for="installMessages"> Friendship submodule </label>
	<? echo CHtml::checkBox('installFriendship', true); ?>
	<div id="friendship">
		<table>
			<tr>
				<td> Friendships </td>
				<td> <? echo CHtml::textField('friendshipTable', Yii::app()->db->tablePrefix.$friendshipTable); ?> </td>
			</tr>
		</table>
	</div>
	</td>
	<td>

	<label for="installRole"> Profiles submodule </label>
	<? echo CHtml::checkBox('installProfiles', true); ?>

	<div id="profiles">
		<table>
			<tr>
				<td> Profile Fields </td>
				<td> <? echo CHtml::textField('profileFieldTable', Yii::app()->db->tablePrefix.$profileFieldTable);?> </td>
			</tr>
			<tr> 
				<td> Profile Visits</td>
				<td> <? echo CHtml::textField('profileVisitTable', Yii::app()->db->tablePrefix.$profileVisitTable);?> </td>
			</tr>			
			<tr> 
				<td> Profile Comments</td>
				<td> <? echo CHtml::textField('profileCommentTable', Yii::app()->db->tablePrefix.$profileCommentTable);?> </td>
			</tr>			
			<tr> 
				<td> Profiles </td>
				<td> <? echo CHtml::textField('profileTable', Yii::app()->db->tablePrefix.$profileTable); ?> </td>
			</tr>
		<tr>
			<td> Privacy settings</td>
			<td> <? echo CHtml::textField('privacySettingTable', Yii::app()->db->tablePrefix.$privacySettingTable); ?> </td>
		</tr>
		</table>
	</div>
	</td>
	</tr>
</table>

	<? 
	$js = "
	$('#installUsergroup').click(function() {
	$('#usergroup').toggle();
	});
	$('#installFriendship').click(function() {
	$('#friendship').toggle();
	});
	$('#installMembership').click(function() {
	$('#membership').toggle();
	});
	$('#installRole').click(function() {
	$('#roles').toggle();
	});
	$('#installPermission').click(function() {
	$('#permission').toggle();
	});
	$('#installMessages').click(function() {
	$('#messages').toggle();
	});
	$('#installProfiles').click(function() {
	$('#profiles').toggle();
	});

	";
Yii::app()->clientScript->registerScript('install', $js); ?>

<p> <strong> Every already existing Table from previous yii-user-management installations will be deleted! If you are really sure you
want to install the Yii-User-Management Module, switch the 'debug' parameter to
true, run the installer and switch it back to false, so your data doesn't
get overriden accidentally. </strong> </p>

<? echo CHtml::submitButton('Install module'); ?>
<? echo CHtml::endForm(); ?>

</div>
