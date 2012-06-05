<?php
Yii::import('zii.widgets.grid.CGridView');

/**
 * 
 **/
class CsvGridView extends CGridView
{
	public function renderFilter()
	{
		if($this->filter!==null)
		{
			echo "<tr class=\"{$this->filterCssClass}\">\n";
			$i = 0;
			$count = count($this->columns);
			foreach($this->columns as $column) {
				$i++;
				if($i == $count)
					$this->renderCsvButton();
				else
					$column->renderFilterCell();
			}
			echo "</tr>\n";
		}
	}

	public function renderCsvButton() {
		echo CHtml::beginForm(array('//user/csv/select'));
		foreach($this->columns as $column)
			if(isset($column->name))
				echo CHtml::hiddenField($column->name, $column->value);
		printf('<td>%s</td>', CHtml::submitButton('CSV'));
		echo CHtml::endForm();
	}

}
?>
