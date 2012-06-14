<h2> <? echo Yum::t('Your account has been activated'); ?> </h2>

<p> <? Yum::t('Click {here} to go to the login form', array(
			'{here}' => CHtml::link(Yum::t('here'), Yum::module()->loginUrl
				))); ?> </p>
