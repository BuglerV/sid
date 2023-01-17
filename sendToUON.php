<?php

include 'vendor/autoload.php';

$ids = explode(',', $_POST['ids']);

foreach( $ids as $id ) {

	$bitrix = Bitrix\Lead::get($id);
	$bitrix->setField('UF_CRM_IS_REPLACED','Y')->update();

	UON\Lead::create([
		'u_name' => $bitrix->getField('NAME'),
		'u_sname' => $bitrix->getField('SECOND_NAME'),
		'u_surname' => $bitrix->getField('LAST_NAME'),
		'title' => $bitrix->getField('TITLE'),
		'u_phone' => $bitrix->getField('PHONE')[0]->VALUE,
		'u_email' => $bitrix->getField('EMAIL')[0]->VALUE,
		'note' => $bitrix->getField('COMMENTS')
	]);

}