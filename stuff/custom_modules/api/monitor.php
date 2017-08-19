<?php
include_once(EASYWIDIR . '/stuff/custom_modules/api/config.php');
include_once(EASYWIDIR . '/stuff/custom_modules/virtualizor.php');

$v = new Virtualizor_Enduser_API($host_ip, $key, $key_pass);

	foreach ($v->monitor() as $sid => $moni){
            echo '<pre>',print_r($moni),'</pre>';
        }