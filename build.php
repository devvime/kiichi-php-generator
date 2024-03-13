<?php

$pharFile = 'kiichi.phar';

$phar = new Phar($pharFile);

$phar->buildFromDirectory('src/');

$stub = <<<STUB
<?php
Phar::mapPhar('$pharFile');
require 'phar://$pharFile/index.php';
__HALT_COMPILER();
STUB;
$phar->setStub($stub);

$phar->compressFiles(Phar::GZ);

echo "\033[02;32m░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";
echo "\033[02;32m░░░░░░░Generated successfully!░░░░░░░░░\033[0m \n";
echo "\033[02;32m░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░\033[0m \n";

?>
