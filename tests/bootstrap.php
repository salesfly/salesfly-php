<?php
/**
 * Salesfly Client Library for PHP
 */
// Setup autoloading
$loader = require __DIR__ . '/../vendor/autoload.php';
// Add Autoloading of test classes
$loader->addPsr4('SalesflyTest\\', __DIR__);
