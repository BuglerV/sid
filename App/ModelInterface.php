<?php

/**
 * <h1>Интерфейс модели</h1><br/>
 * <b>Модель</b> - это класс, который содержит
 * данные о конкретной сущности в CRM системе
 * и выполняет взаимодействие с ней по API<br>
 * <h2>Примеры стандартных сущностей CRM систем:</h2>
 * <ul>
 *      <li>Лид</li>
 *      <li>Задача</li>
 *      <li>Сделка</li>
 *      <li>Платёж</li>
 * </ul>
 *
 * @version 0.1.0
 */
interface ModelInterface
{
    /**
     * Создаёт сущность с указанными полями
     * @param array $fields Значения полей
     * @return ModelInterface
     */
    public static function create(array $fields): ModelInterface;

    /**
     * Получает сущность
     * @param int $id Идентификатор сущности
     * @return ModelInterface
     */
    public static function get(int $id): ModelInterface;

    /**
     * Обновляет изменённые поля сущности
     * @return ModelInterface
     * @see ModelInterface::setField()
     * @see ModelInterface::setFields()
     */
    public function update(): ModelInterface;

    /**
     * Получает список фильтров
     * @param array $params Параметры фильтрации.
     * Могут отличатся у разных сущностей в связи с отличиями в API
     * @return array
     */
    public static function find(array $params): array;

    /**
     * Получает значение поля по его ключу
     * @param string $field Ключ поля
     * @return mixed
     */
    public function getField(string $field);

    /**
     * Получает список значений полей в формате [ключ => значение]
     * @param array|null $fields Список ключей. Все поля, если не задан.
     * @return array
     */
    public function getFields(array $fields = null): array;

    /**
     * Устанавливает значение поля по ключу
     * @param string $field Ключ поля
     * @param mixed $value Значение поля
     * @return ModelInterface
     */
    public function setField(string $field, $value): ModelInterface;

    /**
     * Устанавливает значения списка полей по ключам
     * @param array $fields Список полей в формате [ключ => значение]
     * @return ModelInterface
     */
    public function setFields(array $fields): ModelInterface;
}