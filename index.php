<?php

include 'vendor/autoload.php';

?><!DOCTYPE html>
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
	$lids = Bitrix\Lead::find([
		'select' => ['ID'],
		'filter' => ['!UF_CRM_IS_REPLACED' => 'Y']
	]);

	foreach($lids as $lid) {
		$lid = Bitrix\Lead::get($lid->ID);

		echo "
		<tr data-type='row_check' id='{$lid->getField('ID')}'>
			<td><input data-type type='checkbox'></td>
			<td>{$lid->getField('TITLE')}</td>
			<td>{$lid->getField('NAME')}</td>
			<td>{$lid->getField('SECOND_NAME')}</td>
			<td>{$lid->getField('LAST_NAME')}</td>
			<td>{$lid->getMultiFieldValue('PHONE')}</td>
			<td>{$lid->getMultiFieldValue('EMAIL')}</td>
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