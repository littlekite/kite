<?php
namespace core;
class Kite{
    
    public static function createWebApplication()
	{
		return self::createApplication('core\Web');
	}
	public static function createApplication($class)
	{
		return new $class();
	}
}
?>