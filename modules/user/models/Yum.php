<?php
/**
 * Helper class
 * @author tomasz.suchanek@gmail.com
 * @author thyseus@gmail.com
 * @since 0.6
 * @package Yum.core
 *
 */
class Yum {
  public static function powered() {
    return sprintf('Yii User Management version %s.', Yum::module()->version);
  }

  /** Register an asset file of Yum */
  public static function register($file) {
    $url = Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/../assets');

    $path = $url . '/' . $file;
    if(strpos($file, 'js') !== false)
      return Yii::app()->clientScript->registerScriptFile($path);
    else if(strpos($file, 'css') !== false)
      return Yii::app()->clientScript->registerCssFile($path);

    return $path;
  }

  public static function userStatus() {
    if(Yii::app()->user->isGuest)
      return Yum::t('Not logged in');

    $user = Yii::app()->user->data();
    $string = Yum::t('Logged in as: ');
    $string .= $user->username;

    if(Yum::hasModule('profile') && $user->profile)
      $string .= ' ' . Yum::t('%{firstname} | %{lastname} | %{email}', array(
        '%{firstname}' => Yii::app()->user->data()->profile->firstname,
        '%{lastname}' => Yii::app()->user->data()->profile->lastname,
        '%{email}' => Yii::app()->user->data()->profile->email));

    if(Yum::hasModule('profile') && count($user->roles) > 0) {
      $string .= '&nbsp;( ';
      foreach($user->roles as $role)
        $string .= $role->title . '&nbsp;';
      $string .= ')';
    }

    if(Yii::app()->user->isAdmin())
      $string .= Yum::t('(Administrator)');
    return $string;
  }

  public static function hint($message) {
    return '<div class="hint">' . Yum::t($message) . '</div>';
  }

  public static function getAvailableLanguages () {
    $cache_id = 'yum_available_languages';

    $languages = false;
    if(Yii::app()->cache)
      $languages = Yii::app()->cache->get($cache_id);

    if($languages===false) {
      $translationTable = Yum::module()->translationTable;
      $sql = "select language from {$translationTable} group by language";

      $command=Yii::app()->db->createCommand($sql);

      $languages=array();
      foreach($command->queryAll() as $row)
        $languages[$row['language']]=$row['language'];

      if(Yii::app()->cache)
        Yii::app()->cache->set($cache_id, $languages);
    }

    return $languages;
  }
  /* set a flash message to display after the request is done */
  public static function setFlash($message, $delay = 5000) 
  {
    $_SESSION['yum_message'] = Yum::t($message);
    $_SESSION['yum_delay'] = $delay;
  }

  public static function hasFlash() 
  {
    return isset($_SESSION['yum_message']);
  }

  /* retrieve the flash message again */
  public static function getFlash() {
    if(Yum::hasFlash()) {
      $message = @$_SESSION['yum_message'];
      unset($_SESSION['yum_message']);
      return $message;
    }
  }

  /* A wrapper for the Yii::log function. If no category is given, we
   * use the YumController as a fallback value.
   * In addition to that, the message is being translated by Yum::t() */
  public static function log($message,
    $level = 'info',
    $category = 'user.controllers.YumController') {
      if(Yum::module()->enableLogging)
        return Yii::log(Yum::t($message), $level, $category);
    }

  public static function renderFlash()
  {
    if(Yum::hasFlash()) {
      echo '<div class="alert">';
      echo Yum::getFlash();
      echo '</div>';
      Yii::app()->clientScript->registerScript('fade',"
        setTimeout(function() { $('.info').fadeOut('slow'); },
    {$_SESSION['yum_delay']});	
      "); 
    }
  }

  public static function p($string, $params = array()) {
    return '<p>' . Yum::t($string, $params) . '</p>';
  }

  /** Fetch the translation string from db and cache when necessary */
  public static function t($string, $params = array(), $category = 'yum')
  {
    $language = Yii::app()->language;

    $cache_id = sprintf('yum_translations_%s_%s', $language, $category);

    $messages = false;
    if(Yii::app()->cache)
      $messages = Yii::app()->cache->get($cache_id);

    if($messages===false) {
      if(Yum::module()->avoidSql) {
        $translations = YumTranslation::model()->findAll(
          'category = :category and language = :language', array(
            'category' =>  $category,
            'language' =>  $language,
          ));
        $messages=array();
        foreach($translations as $row)
          $messages[$row['message']]=$row->translation;
      } else {
        $translationTable = Yum::module()->translationTable;
        $sql = "select message, translation from {$translationTable} where language = :language and category = :category";

        $command=Yii::app()->db->createCommand($sql);
        $command->bindValue(':category',$category);
        $command->bindValue(':language',$language); 

        $messages=array();
        foreach($command->queryAll() as $row)
          $messages[$row['message']]=$row['translation'];
      }

      if(Yii::app()->cache)
        Yii::app()->cache->set($cache_id, $messages);
    }

    if(isset($messages[$string]))
      return strtr($messages[$string], $params);
    else 
      return strtr($string, $params);
  }

  // returns the Yii User Management module. Frequently used for accessing 
  // options by calling Yum::module()->option
  public static function module($module = 'user') {
    return Yii::app()->getModule($module);
  }

  public static function hasModule($module) {
    return array_key_exists($module, Yii::app()->modules);
  }

  /**
   * Produces note: "Field with * are required"
   * @since 0.6
   * @return string 
   */
  public static function requiredFieldNote()
  {
    return CHtml::tag('p',array('class'=>'note'),Yum::t(
      'Fields with <span class="required">*</span> are required.'
    ),true);		
  }

  public static function generateDemoUser($roles, $password, $status) {
    $firstnames = array( 'Kacie', 'Minh', 'Tammera', 'Rocco', 'Violet', 'Suzi', 'Lavone', 'Judie', 'Nathaniel', 'Lena', 'Garth', 'Maryjane', 'Nyla', 'Marisha', 'Karla', 'Virgina', 'Conception', 'Jillian', 'Chere', 'Orpha', 'Damaris', 'Freeda', 'Rosalyn', 'Dierdre', 'Rae', 'Joel', 'Willia', 'Megan', 'Ozell', 'Enola', 'Esteban', 'Farah', 'Trevor', 'Joslyn', 'Lydia', 'Latoyia', 'Doretha', 'Kristine', 'Loraine', 'In', 'Ebonie', 'Rhiannon', 'Chase', 'Yu', 'Pamula', 'Akilah', 'Teofila', 'Elnora', 'Mike', 'Florida');

    $lastnames = array( 'Tosi', 'Bicknell', 'Deguzman', 'Elizalde', 'Gillock', 'Groff', 'Bradish', 'Hilario', 'Cashen', 'Peralez', 'Hyre', 'Leverich', 'Asher', 'Mcray', 'Pearson', 'Montana', 'Mattingly', 'Christofferse', 'Trybus', 'Danford', 'Pennel', 'Singletary', 'Cosme', 'Felt', 'Formby', 'Hurrell', 'Aguero', 'Arnold', 'Holmstrom', 'Watchman', 'Busch', 'Osbourn', 'Sine', 'Mcglinchey', 'Sherrick', 'Meyerhoff', 'Chaffins', 'Cranor', 'Macmillan', 'Killen', 'Gambill', 'Delosantos', 'Bevill', 'Giannini', 'Rhein', 'Sadberry', 'Baird');

    $firstname = $firstnames[rand(0, count($firstnames) - 1)];
    $lastname = $lastnames[rand(0, count($lastnames) - 1)];

    $user = new YumUser();
    $user->username = sprintf('%s_%s', $firstname, $lastname);
    $user->roles = array($_POST['role']);
    $user->setPassword ($_POST['password']);
    $user->status = $_POST['status'];
    $user->createtime = time();

    if($user->save()) {
      if(Yum::hasModule('profile')) {
        $profile = new YumProfile();
        $profile->user_id = $user->id;
        $profile->firstname = $firstname;
        $profile->lastname = $lastname;
        $profile->email = sprintf('%s@%s.com', $firstname, $lastname);
        $profile->save();
      }
    }
  }

  // Import a batch of users. Usually coming from an .csv file.
  // First line contains the attributes, which can either be
  // a attribute for the user or for the profile table.
  // Existing users will be overwritten with the values from the csv.
  // set $roles with an comma separated list of role titles for roles
  // that should automatically be assigned on creation of new users.
  public static function import($data, $delimiter = ',', $enclosure = '"',
    $escape = '\\', $roles = '') {
      if(!$data)
        throw new CException('No data given');

      $rows = explode("\n", $data);

      $firstrow = str_getcsv($rows[0], $delimiter, $enclosure, $escape);
      $attributes = array();
      $i = 0;
      foreach($firstrow as $row) {
        $attributes[$i] = $row;
        $i++;
      }

      unset($rows[0]);

      foreach($rows as $row) {
        $values = str_getcsv($row, $delimiter, $enclosure, $escape);

        $user = YumUser::model()->findByPk($values[0]);

        // Update existing User
        if($user) {
          $profile = $user->profile;
          foreach($attributes as $key => $attribute) {
            if(isset($user->$attribute) && isset($values[$key]))
              $user->$attribute = htmlentities($values[$key], ENT_IGNORE, 'utf-8', FALSE);
            else if(isset($profile->$attribute) && isset($values[$key]))
              $profile->$attribute = htmlentities($values[$key], ENT_IGNORE, 'utf-8', FALSE);
          }

          $user->save(false);
          if($profile instanceof YumProfile)
            $profile->save(false);

          if($roles)
            foreach(explode(',', $roles) as $role)
              $user->assignRole(trim($role));

        } else if(!$user) { // Create new User
          $user = new YumUser;
          $profile = new YumProfile;

          foreach($attributes as $key => $attribute) {
            if(isset($user->$attribute) && isset($values[$key]))
              $user->$attribute = htmlentities($values[$key], ENT_IGNORE, 'utf-8', FALSE);
            else if(isset($profile->$attribute) && isset($values[$key]))
              $profile->$attribute = htmlentities($values[$key], ENT_IGNORE, 'utf-8', FALSE);
          }

          $user->id = $values[0];
          if(!$user->username && $profile->email)
            $user->username = $profile->email;
          if(!$user->status)
            $user->status = 1;
          $user->createtime = time();

          if($user->username) {
            $user->save(false);
            $profile->user_id = $user->id;
            $profile->save(false);
          }
        }
      }
    }
}
?>
