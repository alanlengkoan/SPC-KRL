<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']   = 'auth/login';
$route['404_override']         = 'not_found';
$route['translate_uri_dashes'] = FALSE;

// route admin
$route['admin'] = 'admin/dashboard';
