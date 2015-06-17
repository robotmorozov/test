<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__); 

try
{
    if (!Main\Loader::includeModule('iblock'))
        throw new Main\LoaderException(Loc::getMessage('KONSTRUKTOR_PARAMETERS_IBLOCK_MODULE_NOT_INSTALLED'));
		
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

    $arWidth = array(
        1140 => '1 (1140px)',
        564 => '1/2 (564)',
        277 => '1/4 (277)',
    );

    $arHeight = array(
        564 => '1 (564)',
        277 => '1/2 (277)'
    );

	$arTypes = array(
        '-',
		'BANNER' => 'Баннер',
		'SLIDER' => 'Слайдер',
		'HTML' => 'HTML',
		'PHP' => 'Произвольный код'
	);

    $sortDirection = array(
        'ASC' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_SORT_ASC'),
        'DESC' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_SORT_DESC')
    );

    $arComponentParameters = array(
        'PARAMETERS' => array(
			
			'IBLOCK_TYPE' => Array(
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_IBLOCK_TYPE'),
                'TYPE' => 'LIST',
                'VALUES' => $iblockTypes,
                'DEFAULT' => '',
                'REFRESH' => 'Y'
            ),
            'IBLOCK_ID' => array(
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_IBLOCK_ID'),
                'TYPE' => 'LIST',
                'VALUES' => $iblocks,
                'REFRESH' => 'Y'
            ),
            'CACHE_TIME' => array(
                'DEFAULT' => 36000
            ),
        )
    );

    if(!empty($arCurrentValues['IBLOCK_ID'])){

        $arComponentParameters['PARAMETERS']['COUNT_BLOCKS'] = array(
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_COUNT_BLOCKS'),
            'TYPE' => 'NUMBER',
            'REFRESH' => 'Y'
        );

        for($i = 1; $i <= $arCurrentValues['COUNT_BLOCKS']; $i++){
            $arSort[$i] = $arCurrentValues['SORT_' . $i];
        }

        asort($arSort);

        if(!empty($arSort)){

            $count = 1;
            foreach($arSort as $i => $value){

                $elements[$i] = array();
                if(!empty($arCurrentValues['TYPE_' . $i])){
                    $select = Array(
                        "ID",
                        "NAME",
                        "DATE_ACTIVE_FROM"
                    );

                    $filter = Array(
                        "IBLOCK_TYPE" => trim($arCurrentValues['IBLOCK_TYPE']),
                        "IBLOCK_ID" => IntVal($arCurrentValues['IBLOCK_ID']),
                        "SECTION_CODE" => trim($arCurrentValues['TYPE_' . $i])
                    );

                    $res = CIBlockElement::GetList(Array(), $filter, false, false, $select);
                    while($arItem = $res->Fetch())
                    {
                        $elements[$i][$arItem['ID']] = $arItem['NAME'];
                    }
                }

                $arComponentParameters['PARAMETERS']['TYPE_' . $i] = array(
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_TYPE') . $count,
                    'TYPE' => 'LIST',
                    'DEFAULT' => 'BANNER',
                    'PARENT' => 'BASE',
                    'VALUES' => $arTypes,
                    'REFRESH' => 'Y'
                );

                $arComponentParameters['PARAMETERS']['ELEMENT_' . $i] = array(
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_ELEMENT') . $count,
                    'TYPE' => 'LIST',
                    'PARENT' => 'BASE',
                    'VALUES' => $elements[$i],
                    'REFRESH' => 'Y'
                );

                $arComponentParameters['PARAMETERS']['SORT_' . $i] = array(
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_SORT') . $count,
                    'TYPE' => 'STRING',
                    'PARENT' => 'BASE',
                    'REFRESH' => 'Y',
                    'DEFAULT' => $i
                );

                $arComponentParameters['PARAMETERS']['PREVIEW_WIDTH_' . $i] = array(
                    'PARENT' => 'BASE',
                    'TYPE' => 'LIST',
                    'VALUES' => $arWidth,
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_PREVIEW_WIDTH') . $count,
                    'DEFAULT' => 285,
                );

                $arComponentParameters['PARAMETERS']['PREVIEW_HEIGHT_' . $i] = array(
                    'PARENT' => 'BASE',
                    'TYPE' => 'LIST',
                    'NAME' => 'Высотка картинки - ' . $count,
                    'DEFAULT' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_PREVIEW_HEIGHT') . $count,
                    'VALUES' => $arHeight,
                    'TYPE' => 'LIST',
                );
                $count ++;
            }
        }else{
            for ($i = 1; $i <= $arCurrentValues['COUNT_BLOCKS']; $i++) {

                $elements[$i] = array();

                if(!empty($arCurrentValues['TYPE_' . $i])){
                    $select = Array(
                        "ID",
                        "NAME",
                        "DATE_ACTIVE_FROM"
                    );

                    $filter = Array(
                        "IBLOCK_TYPE" => trim($arCurrentValues['IBLOCK_TYPE']),
                        "IBLOCK_ID" => IntVal($arCurrentValues['IBLOCK_ID']),
                        "SECTION_CODE" => trim($arCurrentValues['TYPE_' . $i])
                    );

                    $res = CIBlockElement::GetList(Array(), $filter, false, false, $select);
                    while($arItem = $res->Fetch())
                    {
                        $elements[$i][$arItem['ID']] = $arItem['NAME'];
                    }
                }

                $arComponentParameters['PARAMETERS']['TYPE_' . $i] = array(
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_TYPE') . $count,
                    'TYPE' => 'LIST',
                    'DEFAULT' => 'BANNER',
                    'PARENT' => 'BASE',
                    'VALUES' => $arTypes,
                    'REFRESH' => 'Y'
                );

                $arComponentParameters['PARAMETERS']['ELEMENT_' . $i] = array(
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_ELEMENT') . $count,
                    'TYPE' => 'LIST',
                    'PARENT' => 'BASE',
                    'VALUES' => $elements[$i],
                    'REFRESH' => 'Y'
                );

                $arComponentParameters['PARAMETERS']['SORT_' . $i] = array(
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_SORT') . $count,
                    'TYPE' => 'STRING',
                    'PARENT' => 'BASE',
                    'REFRESH' => 'Y',
                    'DEFAULT' => $i
                );

                $arComponentParameters['PARAMETERS']['PREVIEW_WIDTH_' . $i] = array(
                    'PARENT' => 'BASE',
                    'TYPE' => 'LIST',
                    'VALUES' => $arWidth,
                    'NAME' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_PREVIEW_WIDTH') . $count,
                    'DEFAULT' => 285,
                );

                $arComponentParameters['PARAMETERS']['PREVIEW_HEIGHT_' . $i] = array(
                    'PARENT' => 'BASE',
                    'TYPE' => 'LIST',
                    'NAME' => 'Высотка картинки - ' . $count,
                    'DEFAULT' => Loc::getMessage('KONSTRUKTOR_PARAMETERS_PREVIEW_HEIGHT') . $count,
                    'VALUES' => $arHeight,
                    'TYPE' => 'LIST',
                );
            }
        }
    }
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
?>