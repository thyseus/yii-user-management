<?php
Yii::import('user.models.*');
Yii::import('profile.models.*');
Yii::import('role.models.*');

// Usage: yiic.php import csv --file=value [--delimiter=,] [--enclosure="]
// [--escape=\] [--roles=]
class ImportCommand extends CConsoleCommand {
  public function actionCsv (
    $file,
    $delimiter = ',
    ', $enclosure = '"',
    $escape = '\\',
    $roles = '') {
      if(!Yii::app()->db)
        throw new CException('No database configured');

      if(!in_array('user', Yii::app()->db->schema->tableNames))
        throw new CException('No table "user" found; is yum installed?');

      if(!$file)
        throw new CException('No file given');

      $data = file_get_contents($file);

      Yum::import($data, $delimiter, $enclosure, $escape, $roles);
    }
}
