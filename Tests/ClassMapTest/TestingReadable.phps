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

// Add a single map
$autoload->addMap('Foo',$coreClassesPath.'Foo.php');

// Add a multi map
$autoload->addMap([
	'Bar' => $coreClassesPath.'Bar.php',
	'Abc' => $coreClassesPath.'Abc.php',
	'Xyz' => $coreClassesPath.'Xyz.php'
]);

// Install our autoloader on the SPL autoload stack
$autoload->register();

// Call classes from class map 
$Foo = new Foo();
$Bar = new Bar();
$Abc = new Abc();
$Xyz = new Xyz();
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