<?

class YumRegistration extends YumActiveRecord {
	const REG_DISABLED = 0;
	const REG_SIMPLE = 1;
	const REG_EMAIL_CONFIRMATION = 2;
	const REG_CONFIRMATION_BY_ADMIN = 3;
	const REG_EMAIL_AND_ADMIN_CONFIRMATION = 4;
	const REG_NO_PASSWORD = 5; 
	const REG_NO_PASSWORD_ADMIN_CONFIRMATION = 6;
}

?>
