<?
// This is a customized variant of CMenu for Yii-User-Management
// @since 0.8 

Yii::import('zii.widgets.CMenu');

class YumMenu extends CMenu {
	public function init() {
		parent::init();
		$this->activateParents = true;
		Yii::app()->clientScript->registerScript('menutoggle', 
				"$('.parent').click(function() { $(this).next().fadeToggle(250);});");
	}

	/**
	 * Recursively renders the menu items.
	 * @param array the menu items to be rendered recursively
	 */
	protected function renderMenuRecursive($items) {
		foreach($items as $item) {
			echo CHtml::openTag('li', isset($item['itemOptions']) ? $item['itemOptions'] : array());
			if(isset($item['url']))
				echo CHtml::link($item['label'],$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
			else
				echo CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
			if(isset($item['items']) && count($item['items']))
			{
				echo "\n".CHtml::openTag('ul',$this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo CHtml::closeTag('ul')."\n";
			}
			echo CHtml::closeTag('li')."\n";
		}
	}

	/**
	 * Normalizes the {@link items} property so that the 'active' state is properly identified for every menu item.
	 * @param array the items to be normalized.
	 * @param string the route of the current request.
	 * @param boolean whether there is an active child menu item.
	 * @return array the normalized menu items
	 */
	protected function normalizeItems($items,$route,&$active) {
		foreach($items as $i=>$item) {
			if(isset($item['visible']) && !$item['visible']) {
				unset($items[$i]);
				continue;
			}
				$items[$i]['label']=CHtml::encode(Yum::t($item['label']));
			$hasActiveChild=false;

			$items[$i]['linkOptions']['class'] = '';
			if(isset($item['items'])) {
				$items[$i]['linkOptions']['class'] .= ' parent';
				$items[$i]['items']=$this->normalizeItems($item['items'],$route,$hasActiveChild);
				if(empty($items[$i]['items']) && $this->hideEmptyItems)
					unset($items[$i]['items']);
			}
			if(!isset($item['active']))
			{
				if($this->activateParents && $hasActiveChild || $this->isItemActive($item,$route))
					$active=$items[$i]['active']=true;
				else
					$items[$i]['active']=false;
			}
			else if($item['active'])
				$hasActiveChild=true;

			if(isset($item['items']) && $hasActiveChild)
				$items[$i]['linkOptions']['class'] .= ' active';

			if($items[$i]['active'] && $this->activeCssClass!='') {
				$items[$i]['linkOptions']['class'].=' '.$this->activeCssClass;
			}
		}
		return array_values($items);
	}
}
