<?php

// Call Cliprz\Loader\Autoload class file
include (realpath('../../Autoload.php'));

// Set base path
$baseDir = __DIR__.DIRECTORY_SEPARATOR;

// Set classes core path
$coreClassesPath = $baseDir.'Classes'.DIRECTORY_SEPARATOR;

/**
 * Create Cliprz\Loader\Autoload instance
 * and set the core path that's search for classes in first place
 */
$autoload = new Cliprz\Loader\Autoload($coreClassesPath);

// Install our autoloader on the SPL autoload stack
$autoload->register();

// Call classes from core path 
$Foo = new Foo();
$Bar = new Bar();
echo '<pre>';
echo $Foo;
echo $Bar;
echo '</pre>';

// Dump classes map
var_dump($autoload->getClassMap());

// Uninstall our autoloader from the SPL autoload stack
$autoload->unRegister();

?>