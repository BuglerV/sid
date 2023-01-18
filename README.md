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

Потом:

```cmd
composer update
php createFields.php
```
