<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


class SimpleComp_71 extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['IBLOCK_CATALOG_ID'] = (int) $arParams['IBLOCK_CATALOG_ID'];
        $arParams['IBLOCK_SIZER_ID'] = (int) $arParams['IBLOCK_SIZER_ID'];
        $arParams['DETAIL_URL'] = (string) $arParams['DETAIL_URL'];
        $arParams['ELEMENTS_COUNT'] = (int) $arParams['ELEMENTS_COUNT'];

        return $arParams;
    }

    private function setResult()
    {
        //sizer
        $sizer = [];
        $arNavParams = ['nPageSize' => $this->arParams['ELEMENTS_COUNT']];
        $arFilter = ['IBLOCK_ID' => $this->arParams['IBLOCK_SIZER_ID']];
        $arSelect = ['ID', 'NAME'];
        $ob = CIBlockElement::getList(false, $arFilter, false, $arNavParams, $arSelect);
        while($res = $ob->Fetch()){
            $sizer[$res['ID']] = $res;
        }
        $this->arResult["NAV_STRING"] = $ob->GetPageNavStringEx($navComponentObject, false, false);

        //items
        $prop = $this->arParams['USER_PROP'];
        $arOrder = ['NAME' => 'ASC', 'SORT' => 'ASC'];
        $arFilter = ['IBLOCK_ID' => $this->arParams['IBLOCK_CATALOG_ID'], '!PROPERTY_'.$prop => false];
        $arSelect = ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_'.$prop, 'PROPERTY_PRICE', 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL'];
        $ob = CIBlockElement::getList($arOrder, $arFilter, false, false, $arSelect);
        $ob->SetUrlTemplates($this->arParams['DETAIL_URL']);
        while($res = $ob->GetNext()){

            foreach($res['PROPERTY_FIRM_VALUE'] as $val){

                if($sizer[$val]){
                    $sizer[$val]['PRODS'][] = $res;
                }
            }
        }

        foreach($sizer as $val){

            if($val['PRODS']){
                $this->arResult['ITEMS'][] = $val;
            }
        }

        $this->arResult['SECTIONS_COUNT'] = count($this->arResult['ITEMS']);
    }

    public function executeComponent()
    {
        if(!Bitrix\Main\Loader::includeModule('iblock')) return;

        $arNavParams = ['nPageSize' => $this->arParams['ELEMENTS_COUNT']];
        $arNavigation = CDBResult::GetNavParams($arNavParams);

        if($this->startResultCache(false, $arNavigation)){
            global $CACHE_MANAGER;
            $CACHE_MANAGER->RegisterTag('SimpleComp_71');

            $this->setResult();
            $this->setResultCacheKeys(['SECTIONS_COUNT']);
            $this->includeComponentTemplate();
        }

        global $APPLICATION;
        $APPLICATION->setTitle(GetMessage('SECTION_COUNT', ['#SECTION_COUNT#' => $this->arResult['SECTIONS_COUNT']]));

        $arButtons = CIBlock::GetPanelButtons($this->arParams['IBLOCK_CATALOG_ID']);
        $this->addIncludeAreaIcon(
            [
                "TITLE" => "ИБ в админке",
                "URL" => $arButtons['submenu']['element_list']['ACTION_URL'],
                "IN_PARAMS_MENU" => true
            ]
        );
    }
}