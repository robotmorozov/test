<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
for($i = 1; $i <= $arParams['COUNT_BLOCKS']; $i++){
    $arSort[$i] = $arParams['SORT_' . $i];
}

asort($arSort);

foreach($arSort as $key => $value){

    $APPLICATION->IncludeComponent(
        "project:element.list",
        '',
        Array(
            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
            "COUNT" => "1",

            "SORT_FIELD1" => $arParams['IBLOCK_TYPE'],
            "SORT_DIRECTION1" => $arParams['IBLOCK_TYPE'],
            "SORT_FIELD2" => $arParams['IBLOCK_TYPE'],
            "SORT_DIRECTION2" => $arParams['IBLOCK_TYPE'],

            "PREVIEW_WIDTH" => $arParams['PREVIEW_WIDTH_' . $key],
            "PREVIEW_HEIGHT" => $arParams['PREVIEW_HEIGHT_' . $key],
            "TYPE" => $arParams['TYPE_' . $key],
            "ID" => $arParams['ELEMENT_' . $key],
            "CACHE_TYPE" => $arParams['CACHE_TYPE'],
            "CACHE_TIME" => $arParams['CACHE_TIME']
        )
    );

}
?>
