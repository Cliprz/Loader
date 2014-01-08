<?php namespace Cliprz\Loader;

/*
 * This file is part of the Cliprz package.
 *
 * (c) Yousef Ismaeil <cliprz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use InvalidArgumentException;

/**
 * Maybe you install this class from Composer so we make sure you don't use class twice
 */
if (class_exists('Cliprz\Loader\Autoload')) return;

class Autoload {

    /**
     * Namespace separator
     *
     * @const string
     */
    const SEPARATOR = '\\';

    /**
     * Core path that's search for classes in first place
     *
     * @var string|null
     * @access private
     */
    private $corePath;

    /**
     * Holds all classes and paths
     *
     * @var array
     * @access private
     * @static
     */
    private static $classMap = [];

    /**
     * Holds fallback directories
     * Research for class in fallback directories if not exist in the core directory
     *
     * @var array
     * @access private
     * @static
     */
    private static $fallbackMap = [];

    /**
     * __CLASS__ Constructor
     *
     * @param string Core path that's search for classes in first place
     * @access public
     */
    public function __construct ($corePath) {
        try {
            $this->setCore($corePath);
        } catch (InvalidArgumentException $iae) {
            exit($iae->getMessage());
        }
    }

    /**
     * Set the core path
     *
     * @param string path
     * @access private
     * @return void
     * @throws InvalidArgumentException in failure
     */
    private function setCore ($path) {
        $path = rtrim($path,'/\\').DIRECTORY_SEPARATOR;
        if (is_dir($path)) {
            $this->corePath = $path;
        } else {
            throw new InvalidArgumentException(
                sprintf('%s is invalid path.',$path));
        }
    }

    /**
     * Get the core path
     *
     * @access private
     * @return string core path or null in otherwise
     */
    private function getCore () {
        return $this->corePath;
    }

    /**
     * Adds class map
     *
     * @example Adds single map
     * <code>
     * Autoload::addMap('className','Path/To/Class.php');
     * </code>
     * 
     * @example Adds mutli classes maps
     * <code>
     * Autoload::addMap([
     *     'ClassName1' => 'Path/To/ClassName1.php',
     *     'ClassName2' => 'Path/To/ClassName2.php',
     *     'ClassName3' => 'Path/To/ClassName3.php'
     * ]);
     * </code>
     *
     * @param mixed  class name
     * @param string directory path
     * @return void
     */
    public function addMap ($class,$path=null) {
        if (is_array($class)) {
            foreach ($class as $cls => $path) {
                if (array_key_exists($cls,static::$classMap)) {
                    continue;
                }
                static::$classMap[$cls] = $path;
            }
        } else {
            $this->appendToMap($class,$path);
        }
    }
	
    /**
     * Appends new class map to classes map array
     *
     * @param string Class name
     * @param string Class path
     * @access public
     */
    public function appendToMap ($class,$path) {
        if (!array_key_exists($class,static::$classMap)) {
            static::$classMap[$class] = $path;
        }
    }

    /**
     * Get all classes and paths
     *
     * @access public
     * @return array
     */
    public function getClassMap () {
        return (array) static::$classMap;
    }

    /**
     * Set fallback map
     *
     * @param string directory
     * @access public
     * @return void
     */
    public function setFallback (Array $fallback) {
        static::$fallbackMap = array_merge($fallback,static::$fallbackMap);
    }

    /**
     * Get fallback map
     *
     * @access public
     * @return array
     */
    public function getFallback () {
        return (array) static::$fallbackMap;
    }

    /**
     * Our autoload method, load classes or interfaces
     *
     * @param string class name
     * @return boolean true if class loaded or false in otherwise
     */
    public function load ($class) {
        if ($file = $this->search($class)) {
            if (is_file($file)) {
                include ($file);
                return true;
            }
        }
        return false;
    }

    /**
     * Search for classes
     * A really good method to find class or research for class in fallback
     *
     * @param string class name
     * @access private
     * @return string class path or false in otherwise
     */
    private function search($class) {
        // Firstly: if class exists in map return to class path
        if (array_key_exists($class,static::$classMap)) {
            return static::$classMap[$class];
        }

        // Secondly: if class not exists in map

        // Checking if class loaded as PSR-0 standard or Set class name with .php suffix
        $classPath = (false !== $position = strrpos($class,self::SEPARATOR))
            ? $this->PSR0($class,$position) : $class.'.php';

        // Tell the autoload if use PSR-0 or not
        $isPSR0 = (boolean) ((false !== $position) ? true : false);

        // Try to search for class from core path
        if (null != $this->getCore()) {
            if (is_file($this->getCore().$classPath)) {
                $this->appendToMap($class,$this->getCore().$classPath);
                return $this->getCore().$classPath;
            }
        }

        // class still not exists !!
        // Here we use the fallback map to research for class
        if (!empty(static::$fallbackMap)) {
            // Get clean class name without any namespaces
            if ($isPSR0) {
                $classPath = ltrim(substr($classPath,$position + 1),self::SEPARATOR);
            }
            // Loop the fallback until find the class or return false in the end of method
            foreach ($this->getFallback() as $path) {
                if (is_file(($file = rtrim($path,'/\\').DIRECTORY_SEPARATOR.$classPath))) {
                    $this->appendToMap($class,$file);
                    return $file;
                    break;
                }
            }
        }

        return false;
    }

    /**
     * PSR-0 standard, Replace namespace with full path to class
     *
     * @param string class name
     * @param boolean|integer the namespace positions
     * @access private
     * @return string PSR-0 class path
     */
    private function PSR0 ($class,$position) {
        // Remove any SEPARATOR in starting
        $class = ltrim($class,self::SEPARATOR);
        // Get a clean file path to follow PSR-0 standard
        $file  = $this->preparePath(substr($class,0,$position)).DIRECTORY_SEPARATOR;
        // Get class name
        $class = substr($class,$position + 1);
        // Fix any _ mark with DIRECTORY_SEPARATOR to follow PSR-0 standard and add .php suffix
        $file .= str_replace('_',DIRECTORY_SEPARATOR,$class).'.php';
        // Now we get a clean PSR-0 standard file path
        return $file;
    }

    /**
     * Make sure using the best operating system directory separators in path
     *
     * @param string path
     * @access public
     * @return string
     */
    public function preparePath ($path) {
        return str_replace(['/',self::SEPARATOR],DIRECTORY_SEPARATOR,$path);
    }

    /**
     * Creates an alias for a namespace
     *
     * @param string  The original class
     * @param string  The new namespace for this class
     * @param boolean Put original class name with alias by default false
     * @access public
     */
    public function namespaceAlias ($original,$alias=null,$withOriginalClassName=false) {
        $alias = ((isset($alias)) ? rtrim($alias,self::SEPARATOR) : $alias);
        if ($withOriginalClassName == true) {
            // Get clean class name without any namespaces
            $exp = explode(self::SEPARATOR,$original);
            $alias = array_pop($exp).self::SEPARATOR.$alias;
        }
        class_alias($original,$alias);
    }

    /**
     * Install our autoloader on the SPL autoload stack
     *
     * @param boolean Whether to prepend the autoloader or not
     * @access public
     */
    public function register ($prepend=false) {
        spl_autoload_register([$this,'load'],true,$prepend);
    }

    /**
     * Uninstall our autoloader from the SPL autoload stack
     *
     * @access public
     */
    public function unRegister () {
        spl_autoload_unregister([$this,'load']);
    }

}

?>