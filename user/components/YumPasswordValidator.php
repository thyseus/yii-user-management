<?php

/**
 * YumPasswordValidator class file.
 *
 * @author Alexander Sieburg <alex.sieburg@gmail.com>
 * @link http://code.google.com/p/qwerty-yii-extensions/source/browse/trunk/PasswordValidator/
 * @license GPL v3
 */

/**
 * YumPasswordValidator validates that the attribute value is a valid password.
 *
 * Future plans:
 * validate against dictionary
 * validate against password history
 * validate consecutive strings like abcdefgh, 123456...
 *
 * @author Alexander Sieburg <alex.sieburg@gmail.com>
 * @version 0.01
 */
class YumPasswordValidator extends CValidator
{
  /*
   * current yii enconding for use in mb string functions.
   */

  public $encoding;

  /*
   * $var int minimum required password length.
   */
  public $minLen = 8;

  /*
   * $var int maximum allowed password length.
   */
  public $maxLen = 0;

  /*
   * $var int minimum required upper case characters.
   */
  public $minUpperCase = 0;

  /*
   * $var int minimum required lower case characters.
   */
  public $minLowerCase = 0;

  /*
   * $var int minimum required numeric characters.
   */
  public $minDigits = 0;

  /*
   * $var int minimum required symbols (e.g: !"Â§$%&/()=?.....).
   */
  public $minSym = 0;

  /*
   * $var bool allow whitespaces.
   */
  public $allowWhiteSpace = false;

  /*
   * $var int maximum character repetition.
   */
  public $maxRepetition = 0;

  protected function validateAttribute($object, $attribute)
  {
    //$this->encoding = Yii::app()->charset;

    $value = $object->$attribute;

    if ($this->minLen > 0)
    {
      if (strlen($value) < $this->minLen)
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} is too short (min. {num} characters).',
            array('{num}' => $this->minLen));

        $this->addError($object, $attribute, $message);
      }
    }

    if ($this->maxLen > 0)
    {
      if (strlen($value) > $this->maxLen)
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} is too long (max. {num} characters).',
            array('{num}' => $this->maxLen));

        $this->addError($object, $attribute, $message);
      }
    }

    if ($this->minLowerCase > 0)
    {
      if (preg_match_all('/[a-z]/', $value, $matches) < $this->minLowerCase)
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} must include at least {num} lower case letters.',
            array('{num}' => $this->minLowerCase));

        $this->addError($object, $attribute, $message);
      }
    }

    if ($this->minUpperCase > 0)
    {
      if (preg_match_all('/[A-Z]/', $value, $matches) < $this->minUpperCase)
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} must include at least {num} upper case letters.',
            array('{num}' => $this->minUpperCase));

        $this->addError($object, $attribute, $message);
      }
    }

    if ($this->minDigits > 0)
    {
      if (preg_match_all('/[0-9]/', $value, $matches) < $this->minDigits)
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} must include at least {num} digits.',
            array('{num}' => $this->minDigits));
        $this->addError($object, $attribute, $message);
      }
    }

    if ($this->minSym > 0)
    {
      if (preg_match_all('/\W/', $value, $matches) < $this->minSym)
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} must include at least {num} symbols.',
            array('{num}' => $this->minSym));

        $this->addError($object, $attribute, $message);
      }
    }

    if (!$this->allowWhiteSpace)
    {
      if (preg_match('/\s/', $value))
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} must not contain whitespace.',
            array('{num}' => $this->minSym));

        $this->addError($object, $attribute, $message);
      }
    }

    if ($this->maxRepetition > 0)
    {
      if (preg_match('/(.){1}\\1{' . $this->maxRepetition . ',}/', $value))
      {
        $message = $this->message !== null ? $this->message : Yii::t('UserModule.YumPasswordValidator',
            '{attribute} must not contain more than {num} sequentially repeated characters.',
            array('{num}' => $this->maxRepetition + 1));

        $this->addError($object, $attribute, $message);
      }
    }
  }

}
?>
