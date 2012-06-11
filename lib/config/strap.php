<?php

require_once '../file/dir.php';
require_once '../logProcessor/message.php';
require_once '../logProcessor/bundle.php';

$message1 = message::getInstance('fuinda', time());
$message2 = message::getInstance('groupons are the best!', time());

$bundle  = new bundle();

var_dump($bundle->addMessage($message1)->addMessage($message2)->toJson());