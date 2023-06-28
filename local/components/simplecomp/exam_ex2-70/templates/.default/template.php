<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->SetViewTarget('min_max_price');
?>
<div style="color:red; margin: 34px 15px 35px 15px"><?=GetMessage('MIN_PRICE', ['#MIN_PRICE#' => $arResult['MIN_PRICE']])?></div>
<div style="color:red; margin: 34px 15px 35px 15px"><?=GetMessage('MAX_PRICE', ['#MAX_PRICE#' => $arResult['MAX_PRICE']])?></div>
<?
$this->EndViewTarget();
?>

<?//print_arr($arResult)?>
<p>
    <?=GetMessage('FILTER')?>
    <br>
    <a href="/ex2/simplecomp_ex2-70/?F=Y">/ex2/simplecomp_ex2-70/?F=Y</a>
    <br>
    <a href="/ex2/simplecomp_ex2-70/">/ex2/simplecomp_ex2-70/</a>
</p>
---
<p><b><?=GetMessage('TITLE')?></b></p>
<ul>
    <?foreach($arResult['ITEMS'] as $arItem){?>
        <li><b><?=$arItem['NAME']?></b> - <?=$arItem['DATE_ACTIVE_FROM']?>
            <?echo '('.implode(', ', $arItem['SECTIONS']).')'?>
            <ul>
                <?foreach($arItem['PRODS'] as $prod){?>
                    <?
                    $this->AddEditAction($prod['ID'].$arItem['ID'], $prod['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_CATALOG_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($prod['ID'].$arItem['ID'], $prod['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_CATALOG_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('PROD_DELETE_CONFIRM')));
                    ?>
                    <li id="<?=$this->GetEditAreaId($prod['ID'].$arItem['ID']);?>">
                        <?=$prod['NAME']?> - <?=$prod['PROPERTY_PRICE_VALUE']?>
                        - <?=$prod['PROPERTY_MATERIAL_VALUE']?>
                        - <?=$prod['PROPERTY_ARTNUMBER_VALUE']?>
                    </li>
                <?}?>
            </ul>
        </li>
    <?}?>
</ul>