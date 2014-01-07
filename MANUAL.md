Cliprz\Loader\Autoload class
============================
Single PHP file can autoload all classes and interfaces in your project.

Note
----
Read our [Tests](https://github.com/Cliprz/Loader/tree/master/Tests) to understand or loader.

Methods
-------
* [Cliprz\Loader\Autoload::__construct(string $corePath);](#__construct)
* [Cliprz\Loader\Autoload::addMap(mixed $class, string $path = null);](#addMap)
* [Cliprz\Loader\Autoload::appendToMap(string $class, string $path);](#appendToMap)
* [Cliprz\Loader\Autoload::getClassMap();](#getClassMap)
* [Cliprz\Loader\Autoload::setFallback(array $fallback);](#setFallback)
* [Cliprz\Loader\Autoload::getFallback();](#getFallback)
* [Cliprz\Loader\Autoload::preparePath(string $path);](#preparePath)
* [Cliprz\Loader\Autoload::namespaceAlias(string $original,string $alias,boolean $withOriginalClassName = false);](#namespaceAlias)
* [Cliprz\Loader\Autoload::register(boolean $prepend = false);](#register)
* [Cliprz\Loader\Autoload::unRegister();](#unRegister)

<a name="__construct"></a> Cliprz\Loader\Autoload::__construct();
-----------------------------------------------------------------
You must now Cliprz\Loader\Autoload not static class so you must create a instance,
you have a one parameter in constructor contains the core path that's search for classes in first place.

``` php
	include('Path/To/Cliprz/Loader/Autoload.php');
	$autoload = new Cliprz\Loader\Autoload(__DIR__.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR);
```

<a name="addMap"></a> Cliprz\Loader\Autoload::addMap();
-------------------------------------------------------
You can add a classes map to find class fast as in example

``` php
	include('Path/To/Cliprz/Loader/Autoload.php');
	$autoload = new Cliprz\Loader\Autoload(__DIR__.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR);
	$autoload->addMap('ClassName','Path/To/ClassName.php');
```

If you want to add multi classes map you can use Array

``` php
	include('Path/To/Cliprz/Loader/Autoload.php');
	$autoload = new Cliprz\Loader\Autoload(__DIR__.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR);
	$autoload->addMap([
		'Class1' => 'Path/To/Class1.php',
		'Class2' => 'Path/To/Class2.php',
		'Namespace\Class3' => 'Path/To/Namespace/Class3.php'
	]);
```

<a name="appendToMap"></a> Cliprz\Loader\Autoload::appendToMap();
-----------------------------------------------------------------
If you want to append a class to map you can use :

``` php
	$autoload->appendToMap('ClassName','Path/To/ClassName.php');
```

<a name="#getClassMap"></a> Cliprz\Loader\Autoload::getClassMap();
------------------------------------------------------------------
To get all classes map you can use this method

``` php
	var_dump($autoload->getClassMap());
```

<a name="setFallback"></a> Cliprz\Loader\Autoload::setFallback();
-----------------------------------------------------------------
Of course sometimes classes not found in Core path that you set in [Cliprz\Loader\Autoload::__construct(string $corePath);](#__construct) so you can use Fallback paths to research for class if not exists in core path.

``` php
	$autoload->setFallback([
		'Path/To/Includes',
		'Path/To/Libaray',
	]);
```

In example above if class not exists in core path so we research in ```Path/To/Includes``` if not in this path so search in ```Path/To/Library```

<a name="getFallback"></a> Cliprz\Loader\Autoload::getFallback();
-----------------------------------------------------------------
Get fallback paths

``` php
	var_dump($autoload->getFallback());
```

<a name="preparePath"></a> Cliprz\Loader\Autoload::preparePath();
-----------------------------------------------------------------
It's a optional function to use, thats make sure using the best operating system directory separators in path.

``` php
	$autoload->preparePath('Path/To/Something/');
```

<a name="namespaceAlias"></a> Cliprz\Loader\Autoload::namespaceAlias();
-----------------------------------------------------------------------
Creates an alias for a namespace, if namespace is too long you can create a alias :

``` php
	$autoload->namespaceAlias('Project\Library\Foo','MyFoo');
	$foo = new MyFoo();
```

If you use thrid parameters you will Put original class name with alias by default false, if true you will call class with the real name followed by alias :

``` php
	$autoload->namespaceAlias('Project\Library\Foo','MyFoo',true);
	$foo = new Foo\MyFoo();
```

<a name="register"></a> Cliprz\Loader\Autoload::register();
-----------------------------------------------------------
To install our autoloader on the SPL autoload stack

``` php
	$autoload->register();
```

If you use thrid parameter we will prepend the autoloader to SPL

``` php
	$autoload->register(true);
```

<a name="unRegister"></a> Cliprz\Loader\Autoload::unRegister();
---------------------------------------------------------------
To uninstall our autoloader from the SPL autoload stack

``` php
	$autoload->unRegister();
```
