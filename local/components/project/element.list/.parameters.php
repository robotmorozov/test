<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

try
{	
	if (!CModule::IncludeModule('iblock')) { 
		die();
	}
	
	$arTypes = array(
		'BANNER' => 'Баннер',
		'SLIDER' => 'Слайдер',
		'HTML' => 'HTML',
		'PHP' => 'Произвольны код'
	);
	
	$sort = array();
	
	$filter = array(
		'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
	);
	
	$arComponentParameters = CComponentUtil::GetComponentProps('project:base.elements.list', $arCurrentValues);
	
	$arComponentParameters['PARAMETERS']['TYPE'] = array(
        'NAME' => Loc::getMessage('ELEMENTS_LIST_PARAMETERS_TYPE'),
        'TYPE' => 'LIST',
        'DEFAULT' => 'BANNER',
        'PARENT' => 'BASE',
		'VALUES' => $arTypes,
    );
	
	$arComponentParameters['PARAMETERS']['ID'] = array(
        'NAME' => Loc::getMessage('ELEMENTS_LIST_PARAMETERS_ID'),
        'TYPE' => 'STRING',
        'PARENT' => 'BASE',
    );
    
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
