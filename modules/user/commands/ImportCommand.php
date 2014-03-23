<?php
Yii::import('user.models.*');

class ImportCommand extends CConsoleCommand {
  public function actionCsv ($file, $delimiter = ',') {
    if(!Yii::app()->db)
      throw new CException('No database configured');

    if(!in_array('user', Yii::app()->db->schema->tableNames))
      throw new CException('No table "user" found; is yum installed?');

    if(!$file)
      throw new CException('No file given');

    $data = readfile($file);

    Yum::import($data, $delimiter);
  }
}
