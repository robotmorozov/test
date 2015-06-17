<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage('KONSTRUKTOR_DESCRIPTION_NAME'),
	"DESCRIPTION" => Loc::getMessage('KONSTRUKTOR_DESCRIPTION_DESCRIPTION'),
	"ICON" => '/images/icon.gif',
	"SORT" => 10,
	"PATH" => array(
		"ID" => 'general',
		"NAME" => Loc::getMessage('KONSTRUKTOR_DESCRIPTION_GROUP'),
		"SORT" => 10,
	),
);

?>