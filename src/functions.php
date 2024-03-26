<?php

function message($type, $text)
{
    echo "\n";
    echo "\n";
    echo "长工工⼕廾工 尸廾尸\n";
    echo "\n";
    $str = str_repeat('░', strlen($text));
    loading();
    switch($type) {
      case 'error':
        echo "\033[01;31m░░{$str}░░\033[0m \n";
        echo "\033[01;31m░░{$text}░░\033[0m \n";
        echo "\033[01;31m░░{$str}░░\033[0m \n";
        echo "\n";
      break;
      case 'warning':
        echo "\033[03;33m░░{$str}░░\033[0m \n";
        echo "\033[03;33m░░{$text}░░\033[0m \n";
        echo "\033[03;33m░░{$str}░░\033[0m \n";
        echo "\n";
      break;
      case 'success':
        echo "\033[02;32m░░{$str}░░\033[0m \n";
        echo "\033[02;32m░░{$text}░░\033[0m \n";
        echo "\033[02;32m░░{$str}░░\033[0m \n";
        echo "\n";
      break;
      case 'kiichii':
        echo "\033[02;32m░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░KIICHII PHP GENERATOR!░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░COMMANDS:░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░- cotroller -name -tableName (ex: controller MyController products)░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░- middleware -name (ex: middleware MyMiddleware)░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░- mail -name (ex: mail MyMail)░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
        echo "\033[02;32m░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
      break;
    }
}

function verify_dir()
{
  $controller_dir = 'App/Controllers';
  $models_dir = 'App/Models';
  $middlewares_dir = 'App/Middlewares';
  if (!is_dir($controller_dir)) mkdir($controller_dir, 0777, true);
  if (!is_dir($models_dir))mkdir($models_dir, 0777, true);
  if (!is_dir($middlewares_dir))mkdir($middlewares_dir, 0777, true);
}

function loading() {
  $speed = 5e3;
  $pointer = 0;
  $square = '◼';
  $loading = [
      array(
          "\033[0;32m{$square}\033[0m", // green
          "\033[1;33m{$square}\033[0m", // yellow
          "\033[0;31m{$square}\033[0m", // red
      ),
      array(
          "\033[0;31m{$square}\033[0m", // red
          "\033[0;32m{$square}\033[0m", // green
          "\033[1;33m{$square}\033[0m", // yellow
      ),
      array(
          "\033[1;33m{$square}\033[0m", // yellow
          "\033[0;31m{$square}\033[0m", // red
          "\033[0;32m{$square}\033[0m", // green
      ),
  ];

  for ($i=0 ; $i<=100 ; $i++) {
      echo implode(' ', $loading[$pointer++]);
      if ($pointer > 2) {
          $pointer = 0;
      }
      echo "\033[5D";
      usleep($speed);
  }
}

function getTpl($file, $argv)
{
    $content = file_get_contents(__DIR__ . "/tpl/{$file}.txt");
    $content = str_replace('{{$value[1]}}', ucfirst($argv[2]), $content);
    $content = str_replace('{$value[1]}', $argv[2], $content);
    $content = str_replace('{$tableName[1]}', $argv[3], $content);
    return $content;
}

function controller_action($argv) 
{
    loading();
    verify_dir();
    if (!isset($argv[3])) {
        message('error', 'Need to inform the name of the database table! EX: composer new controller controllerName tableName');
        exit;
    }
    $content = getTpl('controller', $argv);
    $modelContent = getTpl('model', $argv);
    if (file_exists("App/Controllers/{$argv[2]}Controller.php")) {
        message('warning', "The controller '".ucfirst($argv[2])."' already exists in 'App/Controllers/".ucfirst($argv[2]).".controller.php'");
        exit;
    } else {
        $fp = fopen("App/Controllers/".ucfirst($argv[2])."Controller.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "Controller created in 'App/Controllers/".ucfirst($argv[2])."Controller.php'");
        loading();
        $md = fopen("App/Models/".ucfirst($argv[2])."Model.php","wb");
        fwrite($md, $modelContent);
        fclose($md);
        message('success', "Model created in 'App/Models/".ucfirst($argv[2])."Model.php'");
    }
}

function middleware_action($argv) 
{
    loading();
    verify_dir();
    if (!isset($argv[2])) {
        message('error', 'Need to inform the name of the middleware! EX: composer new middleware name');
        exit;
    }
    $content = getTpl('middleware', $argv);
    if (file_exists("App/Middlewares/{$argv[2]}Middleware.php")) {
        message('warning', "The controller '".ucfirst($argv[2])."' already exists in 'App/Middlewares/".ucfirst($argv[2])."Middleware.php'");
        exit;
    } else {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/App/Middlewares/".ucfirst($argv[2])."Middleware.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "Middleware created in 'App/Middlewares/".ucfirst($argv[2])."Middleware.php'");
    }
}

function mail_action($argv) 
{
    loading();
    verify_dir();
    $content = getTpl('mail', $argv);
    if (file_exists("App/Controllers/EmailServiceController.php")) {
        message('warning', "The EmailServiceController already exists in 'App/Controllers/EmailServiceController.php'");
        exit;
    } else {
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/App/Controllers/EmailServiceController.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "EmailServiceController created in 'App/Controllers/EmailServiceController.php'");
    }
}