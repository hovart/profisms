<?php
define('BASE_PATH', dirname(dirname(__DIR__)));
const DATA = BASE_PATH . '/public/data/';
const SAVED = DATA . '/saved/';
const CONFIG = BASE_PATH . '/config/';
global $BController, $User, $BView;
$BController = new \Multi\BController();
$User = new \Multi\User();
$BView = new \Multi\Bview();