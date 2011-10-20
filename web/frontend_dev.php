<?php

// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it or make something more sophisticated.
if (!in_array(@$_SERVER['REMOTE_ADDR'], array('172.16.222.1', '127.0.0.1', '::1', '82.117.234.33', '202.166.163.3'))
    && !in_array(substr(@$_SERVER['REMOTE_ADDR'], 0, strrpos(@$_SERVER['REMOTE_ADDR'], '.')+1), array('192.168.1.')))
{
  die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
