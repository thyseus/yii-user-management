<?php 
printf('<h2> %s </h2>', $title); 
printf('<p> %s </p>', $content); 


if (isset($partial) && is_array($partial) && $partial != array())
	foreach ($partial as $p)
		echo (isset($p['params'])) ? $this->renderPartial($p['view'], $p['params']) : $this->renderPartial($p['view']);

?>