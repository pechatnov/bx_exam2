<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<p>Метка времени: <?=time()?></p>
<p><b><?=GetMessage('TITLE')?></b></p>
<ul>
    <?foreach($arResult['ITEMS'] as $arItem){?>
        <li>
            <b><?=$arItem['NAME']?></b>
            <ul>
                <?foreach($arItem['PRODS'] as $prod){?>
                    <li>
                        <?=$prod['NAME']?> <?=$prod['PROPERTY_PRICE']?>
                         - <?=$prod['PROPERTY_MATERIAL_VALUE']?>
                         - <?=$prod['PROPERTY_ARTNUMBER_VALUE']?>
                         - (<?=$prod['DETAIL_PAGE_URL']?>)
                    </li>
                <?}?>
            </ul>
        </li>
    <?}?>
</ul>
<?if($arParams['ELEMENTS_COUNT']) echo $arResult["NAV_STRING"]?>
<?//print_arr($arResult)?>