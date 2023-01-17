<?php

include 'vendor/autoload.php';

// $fields = [
// 	'NAME' => 'Vasia',
// 	'SECOND_NAME' => 'Pugovkin',
// 	'LAST_NAME' => 'ssss',
// 	'TITLE' => 'Again',
// 	'PHONE' => [
// 		[
// 			'VALUE' => '123123123',
// 			'VALUE_TYPE' => 'WORK'
// 		]
// 	],
// 	'EMAIL' => [
// 		[
// 			'VALUE' => 'sdfsd@df.com',
// 			'VALUE_TYPE' => 'WORK'
// 		]
// 	],
// 	'COMMENTS' => 'comments....'
// ];

// $fields2 = [
// 	'u_name' => 'Vasia',
// 	'u_sname' => 'Alekseevich',
// 	'u_surname' => 'Pugovkin',
// 	'title' => 'Again',
// 	'u_phone' => '123123123123123',
// 	'u_email' => 'sdsfd@md.com',
// 	'note' => 'comments....'
// ];

$lids = Bitrix\Lead::find([
	'select' => ['ID'],
	'filter' => ['!UF_CRM_IS_REPLACED' => 'Y']
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bitrix to U-ON</title>
	<link rel="stylesheet" href="./main.css">
</head>
<body>
	<div class="container" data-role="menu-navigator">
		<table>
			<thead>
				<th></th>
				<th>Название</th>
				<th>Имя</th>
				<th>Отчество</th>
				<th>Фамилия</th>
				<th>Телефон</th>
				<th>Почта</th>
			</thead>
			<tbody>
<?php
	foreach($lids as $lid) {
		$lid = Bitrix\Lead::get($lid->ID);

		echo "
		<tr data-type='row_check' id='{$lid->getField('ID')}'>
			<td><input data-type type='checkbox'></td>
			<td>{$lid->getField('TITLE')}</td>
			<td>{$lid->getField('NAME')}</td>
			<td>{$lid->getField('SECOND_NAME')}</td>
			<td>{$lid->getField('LAST_NAME')}</td>
			<td>{$lid->getField('PHONE')[0]->VALUE}</td>
			<td>{$lid->getField('EMAIL')[0]->VALUE}</td>
		</tr>";
	}
?>
			</tbody>
		</table>
		<button data-type='send'>Перенести в U-ON</button>
	</div>

	<script src="./main.js"></script>
</body>
</html>