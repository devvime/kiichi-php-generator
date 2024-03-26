<?php

require_once('functions.php');

$command = isset($argv[1]) ? $argv[1] : '';

switch($command) {
    case '':
        message('kiichii', '');
    break;
    case 'controller':
        controller_action($argv);
    break;
    case 'middleware':
        middleware_action($argv);
    break;
    case 'mail':
        mail_action($argv);
    break;
}