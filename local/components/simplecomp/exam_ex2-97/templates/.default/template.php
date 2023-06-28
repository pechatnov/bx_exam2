<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<b><?=GetMessage("TITLE")?></b>
<ul>
    <?foreach($arResult['ITEMS'] as $arItem){?>
        <li>[<?=$arItem['ID']?>] - <?=$arItem['LOGIN']?></li>
        <ul>
            <?foreach($arItem['NEWS'] as $new){?>
                <li>- <?=$new['NAME']?>, <?=$new['DATE_ACTIVE_FROM']?></li>
            <?}?>
        </ul>
    <?}?>
</ul>