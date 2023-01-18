<?php

namespace Bitrix;

use ModelInterface;
use Curl;
use Config;

class Lead implements ModelInterface
{
	/**
	 * Массив полей модели.
	 *
	 * @var array
	 */
	public $fields = [];

	/**
	 * Массив измененных полей модели.
	 *
	 * @var array
	 */
	public $updatedFields = [];

	/**
	 * ID модели.
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * Создает объект.
	 *
	 * @param integer $id
	 * @param array $fields
	 */
	public function __construct(int $id, array $fields)
	{
		$this->id = $id;
		$this->fields = $fields;
	}

	/**
	 * Возвращает токен для доступа к API.
	 *
	 * @return string
	 */
	protected static function getToken(): string
	{
		return Config::get('bitrix.token');;
	}

	/**
	 * Генерирует правильный URL.
	 *
	 * @param string $method
	 * @return string
	 */
	protected static function getUrl(string $method) : string
	{
		$token = self::getToken();

		return "https://b24-56b2y7.bitrix24.ru/rest/1/$token/$method.json";
	}

	/**
	 * Создает дополнительное поле IS_REPLACED для определения перенесена ли подель.
	 *
	 * @return void
	 */
	public static function createIsReplacedCustomField()
	{
		self::postCurlRequest('crm.lead.userfield.add', [
			'FIELD_NAME' => 'IS_REPLACED',
			'USER_TYPE_ID' => 'string',
			'SETTINGS' => [
				'DEFAULT_VALUE' => 'N'
			]
		]);
	}

	/**
	 * Инициализирует GET запрос.
	 *
	 * @param string $method
	 * @param array $fields
	 * @return mixed
	 */
	protected static function getCurlRequest(string $method, array $fields = [])
	{
		$curl = new Curl;

		$responce = $curl->exec( self::getUrl($method) . '?' . http_build_query($fields) );

		return json_decode($responce)->result;
	}

	/**
	 * Инициализирует POST запрос.
	 *
	 * @param string $method
	 * @param array $fields
	 * @return mixed
	 */
	protected static function postCurlRequest(string $method, array $fields = [])
	{
		$curl = new Curl;
		$responce = $curl->execPost( self::getUrl($method), $fields );

		return json_decode($responce)->result;
	}

    /**
     * Создаёт сущность с указанными полями
     * @param array $fields Значения полей
     * @return ModelInterface
     */
    public static function create(array $fields): ModelInterface
	{
		$responce = static::postCurlRequest('crm.lead.add', ['FIELDS' => $fields]);
		
		return static::get($responce);
	}

    /**
     * Получает сущность
     * @param int $id Идентификатор сущности
     * @return ModelInterface
     */
    public static function get(int $id): ModelInterface
	{
		$responce = static::getCurlRequest('crm.lead.get', ['ID' => $id]);

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
		if( $this->updatedFields ) {
			static::postCurlRequest('crm.lead.update', [
				'FIELDS' => $this->updatedFields,
				'ID' => $this->id
			]);

			$this->fields = array_merge( $this->fields, $this->updatedFields );

			$this->updatedFields = [];
		}

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
		return (array) static::postCurlRequest('crm.lead.list', $params);
	}

    /**
     * Получает значение поля по его ключу
     * @param string $field Ключ поля
     * @return mixed
     */
    public function getField(string $field){
		if( isset( $this->updatedFields[$field] ) ) {
			return $this->updatedFields[$field];
		}

		return $this->fields[$field] ?? null;
	}

    /**
     * Безопасно получает первое значение мульти поля (PHONE, EMAIL) по его ключу
     * @param string $field Ключ поля
     * @return mixed
     */
    public function getMultiFieldValue(string $field) {
		if( isset( $this->updatedFields[$field] ) ) {
			$value = $this->updatedFields[$field];
		} else {
			$value = $this->fields[$field] ?? null;
		}

		if( !is_array($value) || !count($value) ) {
			return '';
		}

		return $value[0]->VALUE;
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
		$oldValue = $this->getField($field);

		if( $oldValue !== $value ) {
			$this->updatedFields[$field] = $value;
		}

		return $this;
	}

    /**
     * Устанавливает значения списка полей по ключам
     * @param array $fields Список полей в формате [ключ => значение]
     * @return ModelInterface
     */
    public function setFields(array $fields): ModelInterface{
		foreach($fields as $field => $value) {
			$this->setField($field, $value);
		}

		return $this;
	}
}