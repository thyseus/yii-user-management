<h2> <? echo Yum::t('Activation did not work'); ?> </h2>

<? if($error == -1) echo Yum::t('The user is already activated'); ?>
<? if($error == -2) echo Yum::t('Wrong activation Key'); ?>
<? if($error == -3) echo Yum::t('Profile found, but no associated user. Possible database inconsistency. Please contact the System administrator with this error message, thank you'); ?>
