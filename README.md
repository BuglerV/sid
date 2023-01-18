## Тестовое задание.

```

composer update

```

Для работы необходимо создать дополнительное поле 'title' в U-ON и получить идентификатор этого поля.
После отредактировать config/crms.php файл:

```php

return [
	'bitrix.token' => 'БИТРИКС_ТОКЕН',

	'uon.token' => 'ЮОН_ТОКЕН',
	'uon.extended_fields' => [
		'title' => 'ИДЕНТИФИКАТОР_СОЗДАННОГО_ПОЛЯ'
	]
];

```

Так же нужно в Bitrix24 создать новое поле 'IS_REPLACED'. Либо запустить автоматически:

```php

include 'vendor/autoload.php';

Bitrix\Lead::createIsReplacedCustomField();

```
