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

// Call namespacing classes as PSR-0 autoload 
$Foo = new Project\Foo();
$Bar = new Project\Bar();
$Abc = new Library\Abc();
$Xyz = new Library\Xyz();
echo '<pre>';
echo $Foo;
echo $Bar;
echo $Abc;
echo $Xyz;
echo '</pre>';

// Dump classes map
var_dump($autoload->getClassMap());

// Uninstall our autoloader from the SPL autoload stack
$autoload->unRegister();

?>