<?php

# configuration
# - php.ini -> phar.readonly = Off

require_once('functions.php');

$command = isset($argv[1]) ? $argv[1] : '';

verify_dir();

switch($command) {
    case '':
        message('kiichi', '');
    break;
    case 'new-controller':
        controller_action($argv);
    break;
    case 'new-middleware':
        middleware_action($argv);
    break;
    case 'new-mail':
        mail_action($argv);
    break;
    case 'start':
        start_server($argv);
    break;
}