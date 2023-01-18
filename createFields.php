<?php

if( PHP_SAPI != 'cli' ) exit();

include 'vendor/autoload.php';

Bitrix\Lead::createIsReplacedCustomField();
