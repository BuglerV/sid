<?php

/**
 * Класс для удобного получения конфигов.
 */
class Config
{
	/**
	 * Сами настройки.
	 *
	 * @var array
	 */
	protected static $config = [];

	/**
	 * Были ли настройки загружены.
	 *
	 * @var boolean
	 */
	protected static $isConfigLoaded = false;

	/**
	 * Загружает настройки.
	 *
	 * @return void
	 */
	protected static function loadConfig()
	{
		self::$config = require_once(__DIR__ . '/../config/crms.php');

		self::$isConfigLoaded = true;
	}

	/**
	 * Возвращает конкретную настройку по ключу.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public static function get(string $key) : mixed
	{
		if( !self::$isConfigLoaded ) {
			self::loadConfig();
		}

		return self::$config[$key] ?? '';
	}
}