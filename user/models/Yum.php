<?php
/**
 * Helper class
 * @author tomasz.suchanek@gmail.com
 * @since 0.6
 * @package Yum.core
 *
 */
class Yum
{ 
	/** Register an asset file of Yum */
	public static function register($file)
	{
		$url = Yii::app()->getAssetManager()->publish(
				Yii::getPathOfAlias('application.modules.user.assets'));

		$path = $url . '/' . $file;
		if(strpos($file, 'js') !== false)
			return Yii::app()->clientScript->registerScriptFile($path);
		else if(strpos($file, 'css') !== false)
			return Yii::app()->clientScript->registerCssFile($path);

		return $path;
	}

	public static function hint($message) 
	{
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
			$category = 'application.modules.user.controllers.YumController') {
		if(Yum::module()->enableLogging)
			return Yii::log(Yum::t($message), $level, $category);
	}

	public static function renderFlash()
	{
		if(Yum::hasFlash()) {
			echo '<div class="info">';
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
				$translations = YumTranslation::model()->findAll('category = :category and language = :language', array(
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

	public static function resolveTableName($tablename, CDbConnection $connection=null)
	{
		return $tablename;
	}

	// returns the yii user module. Mostly used for accessing options
	// by calling Yum::module()->option
	public static function module($module = 'user') {
		return Yii::app()->getModule($module);
	}

	public static function hasModule($module) {
		return array_key_exists($module, Yii::app()->modules);
	}


	/**
	 * Parses url for predefined symbols and returns real routes
	 * Following symbols are allowed:
	 *  - {yum} - points to base path of Yum
	 *  - {users} - points to user controller 
	 *  - {messsages} - points to base messages module
	 *  - {roles} - points to base roles module
	 *  - {profiles} - points to base profile module
	 * @param string $url
	 * @since 0.6
	 * @return string 
	 */
	public static function route($url)
	{
		$yumBaseRoute=Yum::module()->yumBaseRoute;
		$tr=array();
		$tr['{yum}']=$yumBaseRoute;
		$tr['{messages}']=$yumBaseRoute.'/messages';
		$tr['{roles}']=$yumBaseRoute.'/role';
		$tr['{profiles}']=$yumBaseRoute.'/profiles';
		$tr['{user}']=$yumBaseRoute.'/user';
		if(is_array($url))
		{
			$ret=array();
			foreach($url as $k=>$entry)
				$ret[$k]=strtr($entry,$tr);
			return $ret;
		}
		else
			return strtr($url,$tr);

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

}
?>
