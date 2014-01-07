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

// Call namespacing classes as PSR-0 autoload and create a Alias for the long names
$autoload->namespaceAlias('Project\Library\Foo','MyFoo');
$Foo = new MyFoo();

// Calling Bar object as Project\Library\Bar
$autoload->namespaceAlias('Project\Library\Bar','Bar'); 
$Bar = new Bar();

// Calling Alias with array
$alias = [
	'Project\Library\Abc' => 'Abc',
	'Project\Library\Xyz' => 'Xyz'
];

// Loop aliases
foreach ($alias as $o => $a) {
	$autoload->namespaceAlias($o,$a);
}

$Abc = new Abc();
$Xyz = new Xyz();

// Here i will set alias with third parameter as true
$autoload->namespaceAlias('Project\Library\SimpleClass','simple',true);
// if third parameter is true you will call SimpleClass without namespacing and the alias
$SimpleClass = new SimpleClass\simple();

echo '<pre>';
echo $Foo;
echo $Bar;
echo $Abc;
echo $Xyz;
echo $SimpleClass;
echo '</pre>';

// Dump classes map
var_dump($autoload->getClassMap());

// Uninstall our autoloader from the SPL autoload stack
$autoload->unRegister();

?>