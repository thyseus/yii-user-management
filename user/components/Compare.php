<?php
class Compare extends CActiveRecordbehavior
{
  public function compare($other = '') {
    if(!is_object($other))
      return false;

    // does the objects have the same type?
    if(get_class($this->owner) !== get_class($other))
      return false;

    $differences = array();

    foreach($this->owner->attributes as $key => $value) {
      if($this->owner->$key != $other->$key)
        $differences[$key] = array(
            'old' => $this->owner->$key,
            'new' => $other->$key);
    }

    return $differences;
  }
}
?>
