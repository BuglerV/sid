<?php

include 'vendor/autoload.php';

$fields = [
	'NAME' => 'Vasia',
	'SECOND_NAME' => 'Pugovkin',
	'LAST_NAME' => 'ssss',
	'TITLE' => 'Again',
	'PHONE' => [
		[
			'VALUE' => '123123123',
			'VALUE_TYPE' => 'WORK'
		]
	],
	'EMAIL' => [
		[
			'VALUE' => 'sdfsd@df.com',
			'VALUE_TYPE' => 'WORK'
		]
	],
	'COMMENTS' => 'comments....'
];

$fields2 = [
	'u_name' => 'Vasia',
	'u_sname' => 'Alekseevich',
	'u_surname' => 'Pugovkin',
	'title' => 'Again',
	'u_phone' => '123123123123123',
	'u_email' => 'sdsfd@md.com',
	'note' => 'comments....'
];

// Bitrix\Lead::createIsReplacedCustomField();

// $b = Bitrix\Lead::create($fields);
// $lids = Bitrix\Lead::find([
// 	'select' => ['ID','TITLE'],
// 	'filter' => ['!UF_CRM_IS_REPLACED' => 'Y']
// ]);

// $b = Bitrix\Lead::get(60);
// $b->setField('NAME','Sonia');
// print_r($b);
// $b->update();

// $b->setField('SECOND_NAME','12312312312323');
// $b->update();
// $b->update();
// $b->update();


// print_r($lids);
// print_r($b);

// print_r(require_once('./config/crms.php'));

// $u = UON\Lead::create($fields2);
// $u = UON\Lead::get(2);

// $u->setField('title','sdfsdfsdf')->update();

$u = UON\Lead::find([]);

print_r($u);