<?php
const _HOST = 'localhost';
const _DB = 'rhein_php';
const _USER = 'root';
const _PASS = '';
const _MODULE = 'home';
const _ACTION = 'dashboard';


//Create host
define('_WEB_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/user_management/');
define('_WEB_HOST_TEMPLATES', _WEB_HOST . 'templates');

//create path
define('_WEB_PATH', __DIR__);
define('_WEB_PATH_TEMPLATES', _WEB_PATH . '/templates');
