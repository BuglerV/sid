<?php

namespace UON;

use ModelInterface;
use Curl;
use Config;

class Lead implements ModelInterface
{
	public $fields = [];

	protected $id;

	protected static $methodsMap = [
		'lead.add' => 'lead/create',
		'lead.get' => 'lead/{id}',
		'lead.list' => 'lead/search',
	];

	public function __construct(int $id, array $fields)
	{
		$this->id = $id;
		$this->fields = $fields;
	}

	protected static function getToken(): string
	{
		return Config::get('uon.token'); // extended_fields
	}

    /**
     * Создаёт сущность с указанными полями
     * @param array $fields Значения полей
     * @return ModelInterface
     */
    public static function create(array $fields): ModelInterface
	{
		$finalFields = [
			'extended_fields' => []
		];

		$extended_fields = Config::get('uon.extended_fields');

		foreach($fields as $field => $value) {
			if( !isset( $extended_fields[$field] ) ) {
				$finalFields[$field] = $value;

				continue;
			}

			$finalFields['extended_fields'][$extended_fields[$field]] = $value;
		}

		$responce = static::postCurlRequest('lead.add', $finalFields);

		return static::get($responce['id']);
	}

    /**
     * Получает сущность
     * @param int $id Идентификатор сущности
     * @return ModelInterface
     */
    public static function get(int $id): ModelInterface
	{
		$responce = static::getCurlRequest('lead.get', ['ID' => $id])['lead'][0];

		return new static($id, (array) $responce);
	}

    /**
     * Обновляет изменённые поля сущности
     * @return ModelInterface
     * @see ModelInterface::setField()
     * @see ModelInterface::setFields()
     */
    public function update(): ModelInterface
	{
		return $this;
	}

    /**
     * Получает список фильтров
     * @param array $params Параметры фильтрации.
     * Могут отличатся у разных сущностей в связи с отличиями в API
     * @return array
     */
    public static function find(array $params): array
	{
		return (array) static::postCurlRequest('lead.list', $params);
	}

	protected static function getUrl(string $method, array $fields = []) : string
	{
		$token = self::getToken();

		$method = self::$methodsMap[$method];

        if( strpos($method, '{id}') ) {
            $method = str_replace('{id}', $fields['ID'], $method);
        }

		return "https://api.u-on.ru/$token/$method.json";
	}

	protected static function getCurlRequest(string $method, array $fields = []) : array
	{
		$curl = new Curl;
		$responce = $curl->exec( self::getUrl($method, $fields) );

		return (array) json_decode($responce);
	}

	protected static function postCurlRequest(string $method, array $fields = []): array
	{
		$curl = new Curl;
		$responce = $curl->execPost( self::getUrl($method, $fields), $fields );

		return (array) json_decode($responce);
	}

    /**
     * Получает значение поля по его ключу
     * @param string $field Ключ поля
     * @return mixed
     */
    public function getField(string $field){
		return $this->fields[$field] ?? null;
	}

    /**
     * Получает список значений полей в формате [ключ => значение]
     * @param array|null $fields Список ключей. Все поля, если не задан.
     * @return array
     */
    public function getFields(array $fields = null): array
	{
		$result = [];

		foreach( $fields as $field ) {
			$result[$field] = $this->getField($field);
		}

		return $result;
	}

    /**
     * Устанавливает значение поля по ключу
     * @param string $field Ключ поля
     * @param mixed $value Значение поля
     * @return ModelInterface
     */
    public function setField(string $field, $value): ModelInterface{
		return $this;
	}

    /**
     * Устанавливает значения списка полей по ключам
     * @param array $fields Список полей в формате [ключ => значение]
     * @return ModelInterface
     */
    public function setFields(array $fields): ModelInterface{
		return $this;
	}
}