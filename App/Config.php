<?php

class Config
{
	protected static $config = [];

	protected static $isConfigLoaded = false;

	protected static function loadConfig()
	{
		self::$config = require_once(__DIR__ . '/../config/crms.php');

		self::$isConfigLoaded = true;
	}

	public static function get(string $key)
	{
		if( !self::$isConfigLoaded ) {
			self::loadConfig();
		}

		return self::$config[$key] ?? '';
	}
}