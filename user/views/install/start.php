<style type="text/css">
td { vertical-align: top; } 
td td { border: 1px dotted; } 

input { width: 100px; } 
</style>
<div style="width: 800px;">
<h1> Yii User Management Module Installation </h1>

<?php echo CHtml::beginForm(array('install')); ?>
	<p> You are about to install the Yii User management Module version
<em><?php echo Yii::app()->getModule('user')->version; ?> </em>
 in your Web Application. You require a working database connection to an mysql
Database. Other Databases are not supported at this time. Please make sure 
your Database is Accessible in protected/config/main.php. </p>

	<?php if (Yii::app()->db): ?>
	<div class="hint"> Your database connection seems to be working </div>
	<?php else: ?>
	<div class="error"> Your database connection <em> doesn't </em> seem to be working </div>
	<?php endif; ?>

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
			<td> <?php echo CHtml::textField('userTable', $userTable); ?> </td>
		</tr>
			<tr>
				<td> Message translation Table (required) </td>
				<td> <?php echo CHtml::textField('translationTable', $translationTable); ?> </td>
			</tr>
		</table>

	</td>
	<td>
	<label for="installRole"> Role Management submodule </label>
	<?php echo CHtml::checkBox('installRole', true); ?>

	<div id="roles">
		<table>
			<tr>
				<td> Roles </td>
				<td> <?php echo CHtml::textField('roleTable', $roleTable); ?> </td> 
			</tr>
			<tr>
				<td> Role Assignment </td>
				<td> <?php echo CHtml::textField('userRoleTable', $userRoleTable); ?> </td>
			</tr>
				</table>
	</div>

	</td>
	<td>

	<label for="installMembership"> Membership Management </label>
	<?php echo CHtml::checkBox('installMembership', true); ?>

	<div id="membership">
		<table>
			<tr>
				<td> Membership assignment </td>
				<td> <?php echo CHtml::textField('membershipTable', $membershipTable); ?> </td> 
			</tr>
			<tr>
				<td> Payment types </td>
				<td> <?php echo CHtml::textField('paymentTable', $paymentTable); ?> </td> 
			</tr>
				</table>

	</div>

	</td>
	<td>

	<label for="installPermission"> Permission submodule </label>
	<?php echo CHtml::checkBox('installPermission', true); ?>

	<div id="permission">
		<table>
			<tr>
				<td> Permission Assignment </td>
				<td> <?php echo CHtml::textField('permissionTable', $permissionTable); ?> </td>
			</tr>
			<tr>
				<td> Actions </td>
				<td> <?php echo CHtml::textField('actionTable', $actionTable); ?> </td>
			</tr>
				</table>
	</div>

	</td>
	</tr><tr>
	<td>
	<label for="installMessages"> Messages submodule </label>
	<?php echo CHtml::checkBox('installMessages', true); ?>
	<div id="messages">
		<table>
			<tr>
				<td> Messages </td>
				<td> <?php echo CHtml::textField('messageTable', $messageTable); ?> </td> 
			</tr>
		</table>
	</div>

	</td>
	<td>

	<label for="installMessages"> Usergroups submodule </label>
	<?php echo CHtml::checkBox('installUsergroup', true); ?>
	<div id="usergroup">
		<table>
			<tr>
				<td> User groups </td>
				<td> <?php echo CHtml::textField('usergroupTable', $usergroupTable); ?> </td> 
			</tr>
			<tr>
				<td> User group messages</td>
				<td> <?php echo CHtml::textField('usergroupMessagesTable',
						$usergroupMessagesTable); ?> </td> 
				</tr>
		</table>

	</div>
	</td>
	<td>

	<label for="installMessages"> Friendship submodule </label>
	<?php echo CHtml::checkBox('installFriendship', true); ?>
	<div id="friendship">
		<table>
			<tr>
				<td> Friendships </td>
				<td> <?php echo CHtml::textField('friendshipTable', $friendshipTable); ?> </td> 
			</tr>
		</table>
	</div>
	</td>
	<td>

	<label for="installRole"> Profiles submodule </label>
	<?php echo CHtml::checkBox('installProfiles', true); ?>

	<div id="profiles">
		<table>
			<tr>
				<td> Profile Fields </td>
				<td> <?php echo CHtml::textField('profileFieldTable', $profileFieldTable);?> </td>
			</tr>
			<tr> 
				<td> Profile Visits</td>
				<td> <?php echo CHtml::textField('profileVisitTable', $profileVisitTable);?> </td> 
			</tr>			
			<tr> 
				<td> Profile Comments</td>
				<td> <?php echo CHtml::textField('profileCommentTable', $profileCommentTable);?> </td> 
			</tr>			
			<tr> 
				<td> Profiles </td>
				<td> <?php echo CHtml::textField('profileTable', $profileTable); ?> </td> 
			</tr>
		<tr>
			<td> Privacy settings</td>
			<td> <?php echo CHtml::textField('privacySettingTable', $privacySettingTable); ?> </td>
		</tr>
		</table>
	</div>
	</td>
	</tr>
</table>

	<?php 
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

<?php echo CHtml::submitButton('Install module'); ?>
<?php echo CHtml::endForm(); ?>

</div>
