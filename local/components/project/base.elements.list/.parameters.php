<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

try
{
    $arComponentParameters = CComponentUtil::GetComponentProps('project:base.component', $arCurrentValues);

    $arWidth = array(
        1140 => '1 (1140px)',
        564 => '1/2 (564)',
        277 => '1/4 (277)',
    );

    $arHeight = array(
        564 => '1 (564)',
        277 => '1/2 (277)'
    );
	
	$sortDirection = array(
		'ASC' => Loc::getMessage('BASE_ELEMENTS_LIST_PARAMETERS_SORT_ASC'),
		'DESC' => Loc::getMessage('BASE_ELEMENTS_LIST_PARAMETERS_SORT_DESC')
	);

	$parameters = array(
		'COUNT' =>  array(
			'PARENT' => 'BASE',
			'NAME' => Loc::getMessage('BASE_ELEMENTS_LIST_PARAMETERS_COUNT'),
			'TYPE' => 'STRING',
			'DEFAULT' => '0'
		),
        'PREVIEW_WIDTH' => array(
            'PARENT' => 'BASE',
			'TYPE' => 'LIST',
			'VALUES' => $arWidth,
            'NAME' => Loc::getMessage('BASE_ELEMENTS_LIST_PARAMETERS_PREVIEW_WIDTH'),
            'DEFAULT' => 285,
        ),
        'PREVIEW_HEIGHT' => array(
            'PARENT' => 'BASE',
			'TYPE' => 'LIST',
            'NAME' => Loc::getMessage('BASE_ELEMENTS_LIST_PARAMETERS_PREVIEW_HEIGHT'),
            'DEFAULT' => 282,
			'VALUES' => $arHeight,
			'TYPE' => 'LIST',
        ),
	);

    $arComponentParameters['PARAMETERS'] = array_merge($arComponentParameters['PARAMETERS'], $parameters);
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
