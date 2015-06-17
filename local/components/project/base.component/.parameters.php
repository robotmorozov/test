<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__); 

try
{
	if (!Main\Loader::includeModule('iblock'))
		throw new Main\LoaderException(Loc::getMessage('BASE_COMPONENT_PARAMETERS_IBLOCK_MODULE_NOT_INSTALLED'));
	
	$iblockTypes = \CIBlockParameters::GetIBlockTypes(Array("-" => " "));
	
	$iblocks = array(0 => " ");
	if (isset($arCurrentValues['IBLOCK_TYPE']) && strlen($arCurrentValues['IBLOCK_TYPE']))
	{
	    $filter = array(
	        'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
	        'ACTIVE' => 'Y'
	    );
	    $rsIBlock = \CIBlock::GetList(array('SORT' => 'ASC'), $filter);
	    while ($arIBlock = $rsIBlock -> GetNext())
	    {
	        $iblocks[$arIBlock['ID']] = $arIBlock['NAME'];
	    }
    }

    $dateFormats = CIBlockParameters::GetDateFormat('Формат даты', "ADDITIONAL_SETTINGS");
    $dateFormats['VALUES']['d.m.y'] = '22.02.07';
	
	$arComponentParameters = array(
		'PARAMETERS' => array(
			'IBLOCK_TYPE' => Array(
				'PARENT' => 'BASE',
				'NAME' => Loc::getMessage('BASE_COMPONENT_PARAMETERS_IBLOCK_TYPE'),
				'TYPE' => 'LIST',
				'VALUES' => $iblockTypes,
				'DEFAULT' => '',
				'REFRESH' => 'Y'
			),
			'IBLOCK_ID' => array(
				'PARENT' => 'BASE',
				'NAME' => Loc::getMessage('BASE_COMPONENT_PARAMETERS_IBLOCK_ID'),
				'TYPE' => 'LIST',
				'VALUES' => $iblocks
			),
            "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		)
	);
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
?>