<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?$item = $arResult['ITEMS']['0'];?>

<?if(!empty($item)){?>

    <?if($arParams['TYPE'] == 'SLIDER'){?>

        <?if(!empty($item['SLIDER'])){?>

            <div class="grid-item grid-item-<?=$arParams['PREVIEW_WIDTH']?>-<?=$arParams['PREVIEW_HEIGHT']?>">
                <div class="owl-carousel">

                    <?foreach($item['SLIDER'] as $value){?>
                        <div class="item"><img src="<?=$value['src']?>"></div>
                    <?}?>

                </div>
            </div>

        <?}?>

    <?}elseif($arParams['TYPE'] == 'BANNER'){?>

        <div class="grid-item grid-item-<?=$arParams['PREVIEW_WIDTH']?>-<?=$arParams['PREVIEW_HEIGHT']?>" style="background-image: url('<?=$item['BANNER']['src']?>')"></div>

    <?}elseif($arParams['TYPE'] == 'HTML'){?>

        <div class="grid-item grid-item-<?=$arParams['PREVIEW_WIDTH']?>-<?=$arParams['PREVIEW_HEIGHT']?>">
            <?=$item['VALUE']?>
        </div>

    <?}elseif($arParams['TYPE'] == 'PHP'){?>
		
		<div class="grid-item grid-item-<?=$arParams['PREVIEW_WIDTH']?>-<?=$arParams['PREVIEW_HEIGHT']?>">
		<?$str = '';
		eval('$str = ' . $item['VALUE'] . ';');
        echo $str. "\n";?>
		</div>
	<?}?>

<?}?>





