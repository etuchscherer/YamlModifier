<?php

require_once '../file/dir.php';
require_once '../logProcessor/message.php';
require_once '../logProcessor/bundle.php';

$message = message::getInstance('fuinda', time());

$bundle  = new bundle();

var_dump($bundle->getLastRead());