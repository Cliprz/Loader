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

/**
 * Set fallback paths if classes not founded in core path
 * this setting will search in fallback paths
 */
$autoload->setFallback([
	$baseDir.'Includes',
	#$baseDir.'Add here another path if you wan\'t',
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