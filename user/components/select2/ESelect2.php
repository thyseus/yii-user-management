<?php

/**
 * Wrapper for ivaynberg jQuery select2 (https://github.com/ivaynberg/select2)
 * 
 * @author Anggiajuang Patria <anggiaj@gmail.com>
 * @link http://git.io/Mg_a-w
 * @license http://www.opensource.org/licenses/apache2.0.php
 */
class ESelect2 extends CInputWidget
{

    /**
     * @var array select2 options
     */
    public $options = array();

    /**
     * @var array CHtml::dropDownList $data param
     */
    public $data = array();

    /**
     * @var string html element selector
     */
    public $selector;

    /**
     * @var array javascript event handlers
     */
    public $events = array();
    
    protected $defaultOptions = array();

    public function init()
    {
        $this->defaultOptions = array(
            'formatNoMatches' => 'js:function(){return "' . Yii::t('ESelect2.select2', 'No matches found') . '";}',
            'formatInputTooShort' => 'js:function(input,min){return "' . Yii::t('ESelect2.select2', 'Please enter {chars} more characters', array('{chars}' => '"+(min-input.length)+"')) . '";}',
			'formatInputTooLong' => 'js:function(input,max){return "' . Yii::t('ESelect2.select2', 'Please enter {chars} less characters', array('{chars}' => '"+(input.length-max)+"')) . '";}',
            'formatSelectionTooBig' => 'js:function(limit){return "' . Yii::t('ESelect2.select2', 'You can only select {count} items', array('{count}' => '"+limit+"')) . '";}',
            'formatLoadMore' => 'js:function(pageNumber){return "' . Yii::t('ESelect2.select2', 'Loading more results...') . '";}',
            'formatSearching' => 'js:function(){return "' . Yii::t('ESelect2.select2', 'Searching...') . '";}',
        );
    }

    public function run()
    {
        if ($this->selector == null) {
            list($this->name, $this->id) = $this->resolveNameId();
            $this->selector = '#' . $this->id;

            if (isset($this->htmlOptions['placeholder']))
                $this->options['placeholder'] = $this->htmlOptions['placeholder'];

            if (!isset($this->htmlOptions['multiple'])) {
                $data = array();
                if (isset($this->options['placeholder']))
                    $data[''] = '';
                $this->data = $data + $this->data;
            }

            if ($this->hasModel()) {
                echo CHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
            } else {
                $this->htmlOptions['id'] = $this->id;
                echo CHtml::dropDownList($this->name, $this->value, $this->data, $this->htmlOptions);
            }
        }

        $bu = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets/');
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($bu . '/select2.css');

        if (YII_DEBUG)
            $cs->registerScriptFile($bu . '/select2.js');
        else
            $cs->registerScriptFile($bu . '/select2.min.js');

        $options = CJavaScript::encode(CMap::mergeArray($this->defaultOptions, $this->options));
        ob_start();
        echo "jQuery('{$this->selector}').select2({$options})";
        foreach ($this->events as $event => $handler)
            echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";

        $cs->registerScript(__CLASS__ . '#' . $this->id, ob_get_clean() . ';');
        
    }

}
