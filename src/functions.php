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
      case 'kiichi':
        echo "░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\n";
        echo "░░                                                                                            ░░\n";
        echo "░░    COMMANDS:                                                                               ░░\n";
        echo "░░    - start (ex: php kiichi start) - init server on localhost:8080                          ░░\n";
        echo "░░    - new-cotroller -name -tableName (ex: php kiichi new-controller MyController products)  ░░\n";
        echo "░░        - new-cotroller -name -tableName --route /routeName (make route group)              ░░\n";
        echo "░░    - new-middleware -name (ex: php kiichi new-middleware MyMiddleware)                     ░░\n";
        echo "░░    - new-mail -name (ex: php kiichi new-mail MyMail)                                       ░░\n";
        echo "░░                                                                                            ░░\n";
        echo "░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\n";
        echo "\n";
      break;
    }
}

function verify_dir()
{
  $controller_dir = 'src/Controllers';
  $models_dir = 'src/Models';
  $middlewares_dir = 'src/Middlewares';
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
    if (isset($argv[2])):
        $content = str_replace('{{$value[1]}}', ucfirst($argv[2]), $content);
        $content = str_replace('{{$value[5]}}', $argv[5], $content);
        $content = str_replace('{$value[1]}', $argv[2], $content);
    endif;
    if (isset($argv[3])) $content = str_replace('{$tableName[1]}', $argv[3], $content);
    return $content;
}

function controller_action($argv) 
{
    loading();
    if (!isset($argv[3])) {
        message('error', 'Need to inform the name of the database table! EX: php kiichi new-controller controllerName tableName');
        exit;
    }
    if (isset($argv[4]) && !isset($argv[5])) {
        message('error', 'Need to inform the name of the route group! EX: php kiichi new-controller controllerName tableName --route /routeName');
        exit;
    }
    $content = getTpl('controller', $argv);
    $modelContent = getTpl('model', $argv);
    if (file_exists("src/Controllers/".ucfirst($argv[2])."Controller.php")) {
        message('warning', "The controller '".ucfirst($argv[2])."' already exists in 'src/Controllers/".ucfirst($argv[2])."Controller.php'");
        exit;
    } else {
        $fp = fopen("src/Controllers/".ucfirst($argv[2])."Controller.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "Controller created in 'src/Controllers/".ucfirst($argv[2])."Controller.php'");
        loading();
        $md = fopen("src/Models/".ucfirst($argv[2])."Model.php","wb");
        fwrite($md, $modelContent);
        fclose($md);
        message('success', "Model created in 'src/Models/".ucfirst($argv[2])."Model.php'");
        if (isset($argv[4])) {
            switch ($argv[4]) {
                case '--route':
                    loading();
                    $routesTpl = getTpl('routes', $argv);
                    $content = file_get_contents(__DIR__ . "/Routes/api.php");
                    $content = $content . "\n\n" . $routesTpl;
                    $fp = fopen("src/Routes/api.php","wb");
                    fwrite($fp, $content);
                    fclose($fp);
                    message('success', "Route group created in 'src/Routes/api.php'");
                break;
            }
            exit;
        }
    }
}

function middleware_action($argv) 
{
    loading();
    if (!isset($argv[2])) {
        message('error', 'Need to inform the name of the middleware! EX: php kiichi new-middleware name');
        exit;
    }
    $content = getTpl('middleware', $argv);
    if (file_exists("src/Middlewares/".ucfirst($argv[2])."Middleware.php")) {
        message('warning', "The controller '".ucfirst($argv[2])."' already exists in 'src/Middlewares/".ucfirst($argv[2])."Middleware.php'");
        exit;
    } else {
        $fp = fopen("src/Middlewares/".ucfirst($argv[2])."Middleware.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "Middleware created in 'src/Middlewares/".ucfirst($argv[2])."Middleware.php'");
    }
}

function mail_action($argv) 
{
    loading();
    $content = getTpl('mail', $argv);
    if (file_exists("src/Controllers/EmailServiceController.php")) {
        message('warning', "The EmailServiceController already exists in 'src/Controllers/EmailServiceController.php'");
        exit;
    } else {
        $fp = fopen("src/Controllers/EmailServiceController.php","wb");
        fwrite($fp, $content);
        fclose($fp);
        message('success', "EmailServiceController created in 'src/Controllers/EmailServiceController.php'");
    }
}

function start_server($argv) 
{
    $command = "php -S localhost:8080 -t public";
    message('success', "Server started on port 8080 (localhost:8080)");
    loading();
    shell_exec($command);
    exit;
}