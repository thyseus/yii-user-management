<?php

$columns = YumProfile::getProfileFields();

 $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'profiles-grid',
			'dataProvider'=>$dataProvider,
			'filter'=>null,
			'columns'=>$columns,
			)
); ?>


