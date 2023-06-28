<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult['ITEMS'][0]['ACTIVE_FROM']){
    $arResult['SPECIALDATE'] = $arResult['ITEMS'][0]['ACTIVE_FROM'];
    $this->__component->SetResultCacheKeys(['SPECIALDATE']);
}