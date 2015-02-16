<?php
/**
 * Generates password based on the provided parameters. 
 *
 * Contains adjustments for yii-user-management.
 *
 * @author turi
 * @author thyseus@gmail.com

 */
class EPasswordGenerator extends CApplicationComponent {

	/**
	 * @var int Lenght of password
	 * @var int Number of password capitals
	 * @var int Number of password numerals
	 * @var int Number of password symbols
	 * @return mixed - Generated password
	 * */
	public static function generate(
			$length=8,
			$capitals=0,
			$numerals=0,
			$symbols=0) {
		$chars = "abcdefghijklmnopqrstuvwxyz";
		$caps = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$nums = "0123456789";
		$syms = "!@#$%^&*()-+?";

		$out = "";
		// get count of all required minimum special chars
		$count = $capitals + $numerals + $symbols;

		// build the base password of all lower-case letters
		for ($i = 0; $i < $length; $i++) {
			$out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}

		// create arrays if special character(s) required
		if ($count) {
			// split base password to array; create special chars array
			$tmp1 = str_split($out);
			$tmp2 = array();

			// add required special character(s) to second array
			for ($i = 0; $i < $capitals; $i++) {
				array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
			}
			for ($i = 0; $i < $numerals; $i++) {
				array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
			}
			for ($i = 0; $i < $symbols; $i++) {
				array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
			}

			// hack off a chunk of the base password array that's as big as the special chars array
			$tmp1 = array_slice($tmp1, 0, $length - $count);
			// merge special character(s) array with base password array
			$tmp1 = array_merge($tmp1, $tmp2);
			// mix the characters up
			shuffle($tmp1);
			// convert to string for output
			$out = implode('', $tmp1);
		}
		return $out;
	}

}

?>
