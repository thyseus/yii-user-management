<?php

class SiteController extends CController {
  public $layout = 'main';
  public $breadcrumbs = array();

  public function actionIndex() {
    $this->render('index');
  }

  public function actionError() {
    if($error=Yii::app()->errorHandler->error) {
      if(Yii::app()->request->isAjaxRequest)
        echo $error['message'];
      else
        $this->render('error', $error);
    }
  }
}
