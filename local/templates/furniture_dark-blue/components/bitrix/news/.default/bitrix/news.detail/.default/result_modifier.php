<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if($arParams['CANONICAL']){
    $arFilter = ['IBLOCK_ID' => $arParams['CANONICAL'], 'PROPERTY_NEW' => $arResult['ID']];
    $arSelect = ['ID', 'IBLOCK_ID', 'NAME', 'PROPERTY_NEW'];
    $r = CIBlockElement::GetList(false, $arFilter, false, false, $arSelect);
    if($res = $r->Fetch()){
        $arResult['CANONICAL'] = $res;
    }
    $this->__component->SetResultCacheKeys(['CANONICAL']);
}