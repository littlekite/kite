<?php
class Kite{
    
    public static function createWebApplication()
	{
		return self::createApplication('Web');
	}
	public static function createApplication($class)
	{
		return new $class();
	}
}
?>