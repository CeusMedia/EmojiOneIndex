<?php
(@include 'vendor/autoload.php') or die('Please use composer to install required packages.' . PHP_EOL);

error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );

$index	= new Index();
print $index->render();
