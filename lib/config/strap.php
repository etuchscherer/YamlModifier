<?php

define(APPLICATION_PATH, realpath('.'));

include '../file/dir.php';
include '../file/file.php';

$dir = dir::getInstance(APPLICATION_PATH);

foreach ($dir->getIterator() as $foo) {
    echo $foo;
}