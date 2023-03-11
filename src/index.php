<?php

$comand = $argv[1];

function getTpl($file, $argv)
{
    $content = file_get_contents(__DIR__ . "/tpl/{$file}.txt");
    $content = str_replace('{{$value[1]}}', ucfirst($argv[2]), $content);
    $content = str_replace('{$value[1]}', $argv[2], $content);
    $content = str_replace('{$tableName[1]}', $argv[3], $content);
    return $content;
}

function message($type, $text)
{    
    echo "\033[02;32m░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░█▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀█ \033[0m \n";
    echo "\033[02;32m░░█░░░░█▀▀▀█░█▀▀█░█▀▀▄░▀█▀░█▄░░█░█▀▀█░░█░██░██░██░██░██░██░██░██░██░░░░░░░░░░█ \033[0m \n";
    echo "\033[02;32m░░█░░░░█░░░█░█▄▄█░█░░█░░█░░█░█░█░█░▄▄░░█░██░██░██░██░██░██░██░██░██░░░░░░░░░░█ \033[0m \n";
    echo "\033[02;32m░░█▄▄█░█▄▄▄█░█░░█░█▄▄▀░▄█▄░█░░▀█░█▄▄█░░█▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄█ \033[0m \n";
    echo " \n";
    sleep(1);
    if ($type == 'error'):
        echo "\033[01;31m_/﹋\_\033[0m \n";
        echo "\033[01;31m(҂`_´)\033[0m \n";
        echo "\033[01;31m<,︻╦╤─ ҉ - - => ERROR -> {$text} \033[0m \n";
        echo "\033[01;31m_/﹋\_\033[0m \n";
        echo "\n";
        exit;
    elseif ($type == 'warning'):
        echo "\033[03;33m_/﹋\_\033[0m \n";
        echo "\033[03;33m(҂`_´)\033[0m \n";
        echo "\033[03;33m<,︻╦╤─ ҉ - - => WARNING -> {$text} \033[0m \n";
        echo "\033[03;33m_/﹋\_\033[0m \n";
        echo "\n";
        exit;
    elseif ($type == 'success'):
        echo "\033[02;32m_/﹋\_\033[0m \n";
        echo "\033[02;32m(҂`_´)\033[0m \n";
        echo "\033[02;32m<,︻╦╤─ ҉ - - => SUCCESS -> {$text} \033[0m \n";
        echo "\033[02;32m_/﹋\_\033[0m \n";
        echo "\n";
    endif;
}

if ($comand == 'controller'):

    if ($argv[3] === '' || $argv[3] === null) {
        message('error', 'Need to inform the name of the database table! EX: composer new controller controllerName tableName');
        exit;
    }

    $content = getTpl('controller', $argv);
    $modelContent = getTpl('model', $argv);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "App/Controllers/{$argv[2]}Controller.php")) {
        message('warning', "The controller '".ucfirst($argv[2])."' already exists in 'App/Controllers/".ucfirst($argv[2]).".controller.php'");
        exit;
    } else {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "App/Controllers/".ucfirst($argv[2])."Controller.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        $md = fopen($_SERVER['DOCUMENT_ROOT'] . "App/Models/".ucfirst($argv[2])."Model.php","wb");
        fwrite($md, $modelContent);
        fclose($md);
        message('success', "Controller created in 'App/Controllers/".ucfirst($argv[2])."Controller.php'");
        sleep(1);
        message('success', "Model created in 'App/Models/".ucfirst($argv[2])."Model.php'");
    }

elseif ($comand == 'middleware'):

    if ($argv[2] === '' || $argv[2] === null) {
        message('error', 'Need to inform the name of the middleware! EX: composer new middleware name');
        exit;
    }

    $content = getTpl('middleware', $argv);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "App/Middlewares/{$argv[2]}Middleware.php")) {
        message('warning', "The controller '".ucfirst($argv[2])."' already exists in 'App/Middlewares/".ucfirst($argv[2])."Middleware.php'");
        exit;
    } else {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "App/Middlewares/".ucfirst($argv[2])."Middleware.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "Middleware created in 'App/Middlewares/".ucfirst($argv[2])."Middleware.php'");
    }

elseif ($comand == 'mail'):

    $content = getTpl('mail', $argv);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "App/Controllers/EmailServiceController.php")) {
        message('warning', "The EmailServiceController already exists in 'App/Controllers/EmailServiceController.php'");
        exit;
    } else {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "App/Controllers/EmailServiceController.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "EmailServiceController created in 'App/Controllers/EmailServiceController.php'");
    }

endif;